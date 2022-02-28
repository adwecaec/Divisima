<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\OrderListItem;
use App\Models\OrdersList;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout(){
        $user_cart = Cart::where("user_id",$this->getUser()->id)->first();
        return view('checkout.checkout',[
            'user' =>$this->getUser(),
            'products' => $user_cart->products,
        ]);
    }

    public  function saveOrder(Request $request){
        $cart = Cart::where('user_id', $this->getUser()->id)->first();
        $totalSum = 0;
        for ($i = 0; $i < count($cart->products); $i++ ){
            $totalSum += $cart->products[$i]->pivot->count *  $cart->products[$i]['price'];
        }

        try{
            $ordersList = OrdersList::create([
                "user_id"=> $this->getUser()->id,
                "name" =>$request['user-firstname'] . ' ' . $request['user-lastname'],
                "email"=> $request['user-email'],
                "phone"=> $request['user-phone'],
                "address"=> $request['user-address'],
                "comment"=> $request['comment'],
                "total_cost" => $totalSum
            ]);
        }catch(\Exception $e){
            return response()->json(['Adding new order error: ' . $e->getMessage()]);
        }

        try{
            foreach ($cart->products as $product){
                $productPrice =  isset($product->discount) && !empty($product->discount) ? $product->price - (round($product->price * ($product->discount * 0.01))) : $product->price;
                $ordersList->items()->create([
                    "order_id" =>  $ordersList->id,
                    "product_id" => $product->id,
                    "name" => $product->name,
                    "price" => $productPrice,
                    "count" => $product->pivot->count,
                    "total_cost" => $productPrice * $product->pivot->count,
                    "size" => $product->pivot->size,
                ]);

            }
        }catch(\Exception $e){
            return response()->json(['Adding products to new order error: ' . $e->getMessage()]);
        }

//        foreach ($cart->products as $product) {
//            $product->update([
//                "count" => $product->count -
//            ]);
//            $product->pivot->delete();
//        }

        foreach ($cart->products as $product) {
            $product->pivot->delete();
        }



        return redirect('/personal/orders');
    }
}
