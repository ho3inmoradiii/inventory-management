<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\POS;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function addToCart(Request $request,$id){
        $product =  Product::where('id',$id)->first();

        $check = POS::where('product_id',$id)->first();
        if ($check){
            $updateCart = POS::where('product_id',$id)->increment('pro_quantity');
            $cart = POS::where('product_id',$id)->first();
            $subTotal = $cart->pro_quantity * $cart->product_price;
            $updatedCart = POS::where('product_id',$id)->update(['sub_total'=>$subTotal]);
        }else{
            $data = array();
            $data['product_id'] = $id;
            $data['pro_name'] = $product->product_name;
            $data['pro_quantity'] = 1;
            $data['product_price'] = $product->selling_price;
            $data['sub_total'] = $product->selling_price;

            $pos = POS::create($data);
        }
    }

    public function cartProduct(){
        $cart = POS::all();
        return response()->json($cart);
    }

    public function removeFromCart($id){
        $cart = POS::where('id',$id)->firstorfail()->delete();
    }

    public function increment($id){
        $qty = POS::where('id',$id)->increment('pro_quantity');

        $cart = POS::where('id',$id)->first();
        $subTotal = $cart->pro_quantity * $cart->product_price;
        $updatedCart = POS::where('id',$id)->update(['sub_total'=>$subTotal]);
        return response('done');
    }

    public function decrement($id){
        $qty = POS::where('id',$id)->decrement('pro_quantity');

        $cart = POS::where('id',$id)->first();
        $subTotal = $cart->pro_quantity * $cart->product_price;
        $updatedCart = POS::where('id',$id)->update(['sub_total'=>$subTotal]);
        return response('done');
    }

    public function vats(){
        $vats = DB::table('extra')->first();
        return response()->json($vats);
    }
}
