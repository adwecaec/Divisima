<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductColor;
use App\Models\ProductMaterial;
use App\Models\ProductSeason;
use App\Models\ProductSize;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{


    public function index(Request $request, $group_seo_name,$category_seo_name){
        $group = CategoryGroup::where('name',$group_seo_name)->first();
        $category = Category::where('seo_name',$category_seo_name)->first();
        $category_products = Product::where('category_group_id',$group->id)->where('category_id',$category->id)->get();

        $group_brands = $this->getGroupBrand($group->id);


        if((!empty($request->colors)) || (!empty($request->brands)) || (!empty($request->materials))  || (!empty($request->seasons)) || (!empty($request->sizes))){
            $category_products = Product::where('category_group_id',$group->id)->where('category_id',$category->id)
                ->when(!empty($request->colors), function($query){
                    $color = ProductColor::where('name', request('colors'))->first();
                    return $query->where('product_color_id', $color->id);
                })
                ->when(!empty($request->brands), function($query){
                    $brand = ProductBrand::where('name', request('brands'))->first();
                    return $query->where('product_brand_id',$brand->id);
                })

                ->when(!empty($request->seasons), function($query){
                    $season = ProductSeason::where('name', request('seasons'))->first();
                    return $query->where('product_season_id',$season->id);
                })->get();

            // найти материалы
            if(isset($request->materials) && !empty($request->materials)){
                foreach ($category_products as $key => $value){
                    $is_material = false;
                    for($a = 0; $a < $value->materials->count(); $a++){
                        if($value->materials[$a]['name'] == $request->materials){
                            $is_material = true;
                            break;
                        }
                    }
                    if(!$is_material){
                        unset($category_products[$key]);
                    }
                }
            }
            if(isset($request->sizes) && !empty($request->sizes)){
                foreach ($category_products as $key => $value){
                    $is_size = false;
                    for($a = 0; $a < $value->sizes->count(); $a++){
                        if($value->sizes[$a]['name'] == $request->sizes){
                            $is_size = true;
                            break;
                        }
                    }
                    if(!$is_size){
                        unset($category_products[$key]);
                    }
                }
            }
            if($request->ajax()){
                return view('ajax.ajax',[
                    'products' => $category_products,
                    'group' => $group
                ])->render();
            }
        }

        return view('category.category', [
            'category_products' => $category_products,
            'category' =>$category,
            'group' => $group,
            'group_categories' => $group->categories,
            'brands' => $group_brands,
            'colors' => ProductColor::all(),
            "materials"=> ProductMaterial::all(),
            "seasons" => ProductSeason::all(),
            "sizes" => ProductSize::all(),

        ]);

    }
    public function showSubCategoryProducts(Request $request, $group_seo_name,$category_seo_name,$sub_category_seo_name){
        $group = CategoryGroup::where('name',$group_seo_name)->first();
        $category = Category::where('seo_name',$category_seo_name)->first();
        $sub_category = SubCategory::where('seo_name',$sub_category_seo_name)->where('category_id',$category->id)->first();
        $sub_category_products = Product::where('category_group_id', $group->id)->where('category_sub_id',$sub_category->id)->where('category_id',$category->id)->get();

        if((!empty($request->colors)) || (!empty($request->brands)) || (!empty($request->materials))  || (!empty($request->seasons)) || (!empty($request->sizes))){
        $sub_category_products = Product::where('category_group_id', $group->id)->where('category_sub_id',$sub_category->id)->where('category_id',$category->id)
            ->when(!empty($request->colors), function($query){
                $color = ProductColor::where('name', request('colors'))->first();
                return $query->where('product_color_id', $color->id);
            })
            ->when(!empty($request->brands), function($query){
                $brand = ProductBrand::where('name', request('brands'))->first();
                return $query->where('product_brand_id',$brand->id);
            })

            ->when(!empty($request->seasons), function($query){
                $season = ProductSeason::where('name', request('seasons'))->first();
                return $query->where('product_season_id',$season->id);
            })->get();

        // найти материалы
        if(isset($request->materials) && !empty($request->materials)){
            foreach ($sub_category_products as $key => $value){
                $is_material = false;
                for($a = 0; $a < $value->materials->count(); $a++){
                    if($value->materials[$a]['name'] == $request->materials){
                        $is_material = true;
                        break;
                    }
                }
                if(!$is_material){
                    unset($sub_category_products[$key]);
                }
            }
        }
        if(isset($request->sizes) && !empty($request->sizes)){
            foreach ($sub_category_products as $key => $value){
                $is_size = false;
                for($a = 0; $a < $value->sizes->count(); $a++){
                    if($value->sizes[$a]['name'] == $request->sizes){
                        $is_size = true;
                        break;
                    }
                }
                if(!$is_size){
                    unset($sub_category_products[$key]);
                }
            }
        }
        if($request->ajax()){
            return view('ajax.ajax',[
                'products' => $sub_category_products,
                'group' => $group
            ])->render();
        }
    }

        $group_brands = $this->getGroupBrand($group->id);
        return view('SubCategory.subcategory',[
           'sub_category_products' =>  $sub_category_products,
           'category' =>$category,
           'sub_category' => $sub_category,
            'group' => $group,
            'group_categories' => $group->categories,
           'brands' => $group_brands,
            'colors' => ProductColor::all(),
            "materials"=> ProductMaterial::all(),
            "seasons" => ProductSeason::all(),
            "sizes" => ProductSize::all(),
        ]);
    }
}
