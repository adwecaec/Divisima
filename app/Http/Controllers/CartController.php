<?php

namespace App\Http\Controllers;

use App\Models\Cart;

use App\Models\User;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function showUserCart(Request $request){

        if(!$this->getUser()){
            $user_cart = Cart::where('token', session('_token'))->first();

            if(!empty($request->value) && !empty($request->updateId) && !empty($request->updateSize)) {
                $product = $user_cart->products()->where("product_id",$request->updateId)->first();
                $product->carts()->where('token', session('_token'))->where('size', $request->updateSize)->update(["count" => $request->value]);
                if($request->ajax()){
                    return view('ajax.ajax-cart',[
                        'user' =>$this->getUser(),
                        'cart' => $user_cart,
                        'products' => $user_cart->products
                    ])->render();
                }
            }
        }else{
            $user_cart = Cart::where("user_id",$this->getUser()->id)->first();
            if(!empty($request->value) && !empty($request->updateId) && !empty($request->updateSize)) {
                $product = $user_cart->products()->where("product_id",$request->updateId)->first();
                $product->carts()->where('user_id', $this->getUser()->id)->where('size', $request->updateSize)->update(["count" => $request->value]);
                if($request->ajax()){
                    return view('ajax.ajax-cart',[
                        'user' =>$this->getUser(),
                        'cart' => $user_cart,
                        'products' => $user_cart->products
                    ])->render();
                }
            }
        }

//        if(!empty($request->deleteId)) {
//            $user_cart->products()->detach($request->deleteId);
//            if($request->ajax()){
//                return view('ajax.ajax-cart',[
//                'user' =>$this->getUser(),
//                'products' => $user_cart->products
//            ])->render();
//            }
//        }
        $user = $this->getUser();
        return view('cart.cart', [
            'user' =>$user,
            'cart' => $user_cart,
            'promocodes' => $user->promocodes,
            'products' => isset($user_cart->products) ? $user_cart->products : null
        ]);
    }


    public function deleteFromCart(Request $request){

        if(!$this->getUser()){
            $user_cart = Cart::where('token', session('_token'))->first();
        }else{
            $user_cart = Cart::where("user_id",$this->getUser()->id)->first();
        }

        if(!empty($request['delete-id'])) {
            $user_cart->products()->detach($request['delete-id']);
        }
        session(['success-message-delete' => 'Товар успішно видалено з кошику.']);
         return back();
    }

}
