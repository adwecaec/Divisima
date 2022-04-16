<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
{

    protected function validator(array $data){
        $messages = [
            'name-field.min' => 'Заговоловок має містити не менше 2-х символів.',
            'seo-field.min' => 'СЕО має містити не менше 2-х символів.',
            'seo-field.unique' => 'СЕО вже існує.',
        ];
        return Validator::make($data, [
            'name-field' => ['string', 'min:2'],
            'seo-field' => ['string', 'unique:product_colors,seo_name', 'min:2'],
        ], $messages);
    }

    public function index(){
        $colors = ProductColor::orderBy('id', 'desc')->get();
        return view('admin.additional-to-products.color.index', [
            'user' => $this->getUser(),
            'colors' =>$colors
        ]);
    }

    public function add(){
        return view('admin.additional-to-products.color.add',[
            'user' => $this->getUser(),
        ]);
    }
    public function saveAdd(Request $request){
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // ======================= определяем активность чекбокса ======================
        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        ProductColor::create([
            'name' => $request['name-field'],
            'seo_name'=> $request['seo-field'],
            'active' => $active

        ]);
        return redirect('/admin/colors')->with(['success-message' => 'Колір успішно додано.']);
    }
    public function edit($color_id){
        $color = ProductColor::find($color_id);
        if(!$color){
            return response()->view('errors.404-admin', [
                'user' => $this->getUser(),
            ], 404);
        }

        return view('admin.additional-to-products.color.edit',[
            'user' => $this->getUser(),
            'color' => $color
        ]);
    }

    public function saveEdit(Request $request){
        $color = ProductColor::find($request['id']);

        // ================ в случае старого сео не делать валидацию на уникальность==============

        if($request['seo-field'] == $color->seo_name){
            $validator = $this->validator($request->except('seo-field'));
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }else{
            // ================ если сео все же изменили то проверить на уникальность ==============

            $validator = $this->validator($request->all());
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        // ======================= определяем активность чекбокса ======================
        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        $color->update([
            'name' => $request['name-field'],
            'seo_name'=> $request['seo-field'],
            'active' => $active
        ]);
        return redirect('admin/colors')->with(['success-message' => 'Колір успішно змінено.']);
    }

    public function delete($color_id){
        ProductColor::find($color_id)->delete();
        return redirect('admin/colors')->with(['success-message' => 'Колір успішно видалено.']);
    }
}
