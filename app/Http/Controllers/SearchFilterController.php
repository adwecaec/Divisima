<?php

namespace App\Http\Controllers;


use App\Models\Banner;
use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\Brand;
use App\Models\Color;
use App\Models\ProductImage;
use App\Models\Material;
use App\Models\Season;
use App\Models\Size;
use App\Models\SubCategory;
use App\Services\ElasticSearchService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class SearchFilterController extends Controller
{

    /**
     * Field which determines page of promotion
     *
     * @var bool
     */
    private bool $promotion;

    /**
     * Promotion model
     *
     * @var  Model|null
     */
    private  Model|null $promotionBanner = null;

    /**
     * Category group model
     *
     * @var  Model|null
     */
    private  Model|null $group = null;

    /**
     * Category model
     *
     * @var  Model|null
     */
    private Model|null $category = null;

    /**
     * Подкатегория
     *
     * @var  Model|null
     */
    private  Model|null $subCategory = null;

    /**
     * Global array with full request to elastic
     *
     * @var array
     */
    private array $arrElasticQuery;

    /**
     * Strict mode of search
     *
     * @var string
     */
    private string $filterType;

    /**
     * Elasticsearch service
     *
     * @var ElasticSearchService
     */
    protected ElasticSearchService $elasticSearch;

    /**
     * View
     *
     * @var string
     */
    protected string $view;

    /**
     * Query parameters
     *
     * @var array
     */
    protected array $arrQuery;

    /**
     * "must" key of elastic query
     *
     * @var array
     */
    protected array $must;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->elasticSearch = new ElasticSearchService();
    }

    /**
     * Search page
     *
     * @return Application|Factory|View|string
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(): View|Factory|string|Application
    {
        $this->arrQuery = request()->query();

        $this->setFilterType('must');

        $this->setCategoryAndPromotionVariables();

        $this->setElasticQueryByQueryString();

        $this->setSeoNames();

        $this->setMustArray();

        $this->setPageData();

        if(request()->ajax()){
            return view('pages.components.ajax.pagination',[
                'products' => $this->pageData['products'],
                'group' => $this->pageData['group'],
                "images"=> ProductImage::all(),
            ])->render();
        }

        return view($this->view, $this->pageData);
    }

    /**
     * Sets must array to elastic query
     *
     * @return void
     */
    private function setMustArray(): void
    {
        if($this->atPromotionPage()){
            // if we are at promotion page
            $this->setMustArrayWithPromotion();
            $this->setView('pages.promotions.index');
        }elseif($this->atCategoryGroupPage()){
            // if we are at category group (main) page
            $this->setMustArrayWithGroup();
            $this->setView('pages.main.index');

        }elseif($this->atCategoryPage()){
            // if we at category page
            $this->setMustArrayWithGroupAndCategory();
            $this->setView('pages.category.index');

        }elseif($this->atSubCategoryPage()){
            // if we at subcategory page
            $this->setMustArrayWithAllCategories();
            $this->setView('pages.subcategory.index');
        }
    }

    /**
     * To do search depending on sorting
     *
     * @var string|null $sorting
     * @return LengthAwarePaginator
     */
    private function searchProductsByFilters(string|null $sorting): LengthAwarePaginator
    {
        return $this->elasticSearch->searchByFilters(
            $this->must ?? [],
            $this->arrElasticQuery ?? [],
            $sorting
        );
    }

    /**
     * Sets the must array if we are at subcategory page
     *
     * @return void
     */
    private function setMustArrayWithAllCategories(): void
    {
        $this->must = [
            ['match' => ['category_group_id' => $this->group->id]],
            ['match' => ['category_id' => $this->category->id]],
            ['match' => ['category_sub_id' => $this->subCategory->id]]
        ];
    }

    /**
     * Sets the must array if we are at category page
     *
     * @return void
     */
    private function setMustArrayWithGroupAndCategory(): void
    {
        $this->must = [
            ['match' => ['category_group_id' => $this->group->id]],
            ['match' => ['category_id' => $this->category->id]]
        ];
    }

    /**
     * Sets a must array if we are at category group (main) page
     *
     * @return void
     */
    private function setMustArrayWithGroup(): void
    {
        $this->must = [
            ['match' => ['category_group_seo_name' => $this->group_seo_name]],
        ];
    }

    /**
     * Sets the must array if we are at promotion page
     *
     * @return void
     */
    private function setMustArrayWithPromotion(): void
    {
        $this->must = [
            ['match' => ['category_group_seo_name' => $this->group_seo_name]],
            ['match' => ['banner_id' => $this->promotionBanner->id]],
        ];
    }

    /**
     * Sets default must array
     *
     * @return void
     */
    private function setDefaultMustArray(): void
    {
        $this->must = ['match' => ['category_group_seo_name' => "women"]];
    }

    /**
     * Sets categories seo names for using in request to elastic
     *
     * @return void
     */
    private function setSeoNames(): void
    {
        $this->setCategoryGroupSeoName($this->group ? $this->group->seo_name : '');

        $this->setCategorySeoName($this->category ? $this->category->seo_name : '');

        $this->setSubCategorySeoName($this->subCategory ? $this->subCategory->seo_name : '');
    }

    /**
     * Sets to main elasticsearch query array different filters
     *
     * @return void
     */
    private function setElasticQueryByQueryString(): void
    {
        if(isset($this->arrQuery['colors'])){
            $this->setColorsToElasticQuery();
        }
        if(isset($this->arrQuery['brands'])){
            $this->setBrandsToElasticQuery();
        }
        if(isset($this->arrQuery['seasons'])){
            $this->setSeasonsToElasticQuery();
        }
        if(isset($this->arrQuery['materials'])){
            $this->setMaterialsToElasticQuery();
        }
        if(isset($this->arrQuery['sizes'])){
            $this->setSizesToElasticQuery();
        }
        if(isset($this->arrQuery['priceFrom']) && isset($this->arrQuery['priceTo'])){
            $this->setPriceRangeToElasticQuery();
        }
    }

    /**
     * Sets price range to elasticsearch query
     *
     * @return void
     */
    private function setPriceRangeToElasticQuery(): void
    {
        $requestPriceFrom = explode(' ', $this->arrQuery['priceFrom']);
        $requestPriceTo = explode(' ', $this->arrQuery['priceTo']);

        if(count($requestPriceFrom) > 1){
            $priceFrom = $requestPriceFrom[0];
        }else{
            $priceFrom = $this->arrQuery['priceFrom'];
        }
        if(count($requestPriceTo) > 1){
            $priceTo = $requestPriceTo[0];
        }else{
            $priceTo = $this->arrQuery['priceTo'];
        }

        $this->arrElasticQuery["bool"][$this->filterType][] =  [
            'range' => [
                'price' => [
                    "gte" => $priceFrom,
                    "lte" => $priceTo
                ]
            ]
        ];
    }

    /**
     * Sets the colors to elasticsearch query array for filtration
     *
     * @return void
     */
    private function setColorsToElasticQuery(): void
    {
        $requestColors = explode(' ', $this->arrQuery['colors']);
        $colors = [];

        foreach ($requestColors as $rc){
            $colorModel = Color::getOneBySeoName($rc);
            $colors[] = $colorModel->id;
        }
        $this->arrElasticQuery["bool"][$this->filterType][] =  [
            'terms' => [
                'product_color_id' => $colors
            ]
        ];
    }

    /**
     * Sets the brands to elasticsearch query array for filtration
     *
     * @return void
     */
    private function setBrandsToElasticQuery(): void
    {
        $requestBrands =  explode(' ', $this->arrQuery['brands']);
        $brands = [];
        foreach ($requestBrands as $rb){
            $brandModel = Brand::getOneBySeoName($rb);
            $brands[] = $brandModel->id;
        }
        $this->arrElasticQuery["bool"][$this->filterType][] =  [
            'terms' => [
                'product_brand_id' => $brands
            ]
        ];
    }

    /**
     * Sets the seasons to elasticsearch query array for filtration
     *
     * @return void
     */
    private function setSeasonsToElasticQuery(): void
    {
        $requestSeasons =  explode(' ', $this->arrQuery['seasons']);
        $seasons = [];
        foreach ($requestSeasons as $rs){
            $seasonModel = Season::getOneBySeoName($rs);
            $seasons[] = $seasonModel->id;
        }
        $this->arrElasticQuery["bool"][$this->filterType][] =  [
            'terms' => [
                'product_season_id' => $seasons
            ]
        ];
    }

    /**
     * Sets the materials to elasticsearch query array for filtration
     *
     * @return void
     */
    private function setMaterialsToElasticQuery(): void
    {
        $requestMaterials =  explode(' ', $this->arrQuery['materials']);
        $materials = [];
        foreach ($requestMaterials as $rm){
            $materialModel = Material::getOneBySeoName($rm);
            $materials[] = $materialModel->id;
        }
        $this->arrElasticQuery["bool"][$this->filterType][] =  [
            'terms' => [
                'materials_id' => $materials
            ]
        ];
    }

    /**
     * Sets the sizes to elasticsearch query array for filtration
     *
     * @return void
     */
    private function setSizesToElasticQuery(): void
    {
        $requestSizes  =  explode(' ', $this->arrQuery['sizes']);
        $sizes = [];
        foreach ($requestSizes as $size){
            $sizeModel = Size::getOneBySeoName($size);
            $sizes[] = $sizeModel->id;
        }
        $this->arrElasticQuery["bool"][$this->filterType][] =  [
            'terms' => [
                'sizes_id' => $sizes
            ]
        ];
    }

    /**
     * Sets categories (and maybe promotion) models depending on segments of query string
     *
     * @return void
     */
    private function setCategoryAndPromotionVariables(): void
    {
        $this->promotion = false;

        //в зависимости от присутствия признака того, что запрос со страницы акций
        // выборка происходит по определенным сегментам строки запроса

        $this->group = CategoryGroup::getOneBySeoName(request()->segment(2));

        if(request()->segment(1) == 'promotions'){

            $this->promotion = true;

            $this->promotionBanner = Banner::getOneBySeoName(request()->segment(3));

        }else{

            if(request()->segment(3)){
                $this->category = Category::getOneBySeoName(request()->segment(3));
            }

            if(request()->segment(4)){
                $this->subCategory =  SubCategory::getOneBySeoName(request()->segment(4));
            }
        }
    }


    /**
     * Sets page data for the view
     *
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function setPageData(): void
    {
        if(!$this->group){
            abort(404);
        }

        $sorting = request()->has('orderBy') && !empty(request()->get('orderBy')) ? request()->get('orderBy') : null;

        if($this->atCategoryGroupPage()){
            $banners = Banner::getBannersByGroupId($this->group->id);
        }

        $this->setBreadcrumbs($this->getBreadcrumbs());

        $data  = [
            'group'            => $this->group,
            'products'         => $this->searchProductsByFilters($sorting),
            'group_categories' => $this->group->getCategories(),
            'brands'           => $this->getGroupBrands($this->group->id),
            'category'         => $this->category ?? null,
            'sub_category'     => $this->subCategory ?? null,
            'banner'           => $this->promotionBanner ?? null,
            'banners'          => $banners ?? null,
            'breadcrumbs'      => $this->breadcrumbs
        ];

        $this->pageData = array_merge($data, $this->getProductProperties());
    }

    /**
     * Returns breadcrumbs array
     *
     * @return array[]
     */
    private function getBreadcrumbs(): array
    {
        $breadcrumbs = [];

        if($this->group){
            $breadcrumbs[] = [
                $this->group->name,
                route('index', $this->group->seo_name)
            ];
        }

        if($this->category){
            $breadcrumbs[] = [
                $this->category->name,
                route('category', [$this->group->seo_name, $this->category->seo_name])
            ];
        }

        if($this->subCategory){
            $breadcrumbs[] = [$this->subCategory->name];
        }

        if($this->promotionBanner){
            $breadcrumbs[] = [
                $this->promotionBanner->name,
            ];
        }

        return $breadcrumbs;
    }

    /**
     * Sets filter type variable
     *
     * @param string $type
     * @return void
     */
    private function setFilterType(string $type): void
    {
        $this->filterType = $type;
    }

    /**
     * Defines if we are at promotion page
     *
     * @return bool
     */
    private function atPromotionPage(): bool
    {
        if($this->promotion && $this->group_seo_name != ''){
            return true;
        }

        return false;
    }

    /**
     * Defines if we are at category group page
     *
     * @return bool
     */
    private function atCategoryGroupPage(): bool
    {
        if( $this->group_seo_name != ''
            && $this->category_seo_name === ''
            && $this->sub_category_seo_name === ''
        ){
            return true;
        }

        return false;
    }

    /**
     * Defines if we are at category page
     *
     * @return bool
     */
    private function atCategoryPage(): bool
    {
        if( $this->group_seo_name != ''
            && $this->category_seo_name != ''
            && $this->sub_category_seo_name === ''
        ){
            return true;
        }

        return false;
    }

    /**
     * Defines if we are at subcategory page
     *
     * @return bool
     */
    private function atSubCategoryPage(): bool
    {
        if( $this->group_seo_name != ''
            && $this->category_seo_name != ''
            && $this->sub_category_seo_name != ''
        ){
            return true;
        }

        return false;
    }

    /**
     * Sets view variable
     *
     * @param string $view
     * @return void
     */
    private function setView(string $view): void
    {
        $this->view = $view;
    }
}
