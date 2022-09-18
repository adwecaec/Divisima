<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\ProductImage;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    /**
     * Страница категории
     *
     * @param Request $request
     * @param $group_seo_name
     * @param $category_seo_name
     * @return Application|Factory|View|string
     */
    public function index(Request $request, $group_seo_name, $category_seo_name): Application|Factory|View|string
    {

        $this->group_seo_name = $group_seo_name;

        $this->category_seo_name = $category_seo_name;

        $this->getPageData();

        if($request->ajax()){
            return view('ajax.ajax',[
                'products' => $this->pageData['products'],
                'group' => $this->pageData['group'],
                "images"=> ProductImage::all(),
            ])->render();
        }


        return view('category.category', $this->pageData);
    }

    /**
     * Получение всех данных для вьюхи
     *
     * @return void
     */
    public function getPageData(): void
    {
        $group = CategoryGroup::getOneBySeoName($this->group_seo_name);

        $category = Category::getOneBySeoName($this->category_seo_name);

        if(!$group || !$category){
            abort(404);
        }

        $products = $category->getPaginateProducts(8);

        $brands = $this->getGroupBrands($group->id);

        $data = [
            'group'            => $group,
            'category'         => $category,
            'products'         => $products,
            'group_categories' => $group->getCategories(),
            'brands'           => $brands
        ];

        $this->pageData = array_merge($data, $this->getProductProperties());
    }

}
