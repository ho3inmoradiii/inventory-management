<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class POSController extends Controller
{
    public function subProduct($id){
        $subProduct = Product::where('category_id',$id)->get();
        return response()->json($subProduct);
    }

    public function OrderDone(Request $request){
        $validated = $request->validate([
            'customer_id' => 'required',
            'payby' => 'required'
        ]);

        $validated['qty'] = $request->qty;
        $validated['sub_total'] = $request->subtotal;
        $validated['vat'] = $request->vat;
        $validated['total'] = $request->total;
        $validated['pay'] = $request->pay;
        $validated['pay'] = $request->pay;
        $validated['order_date'] = date('d/m/Y');
        $validated['order_month'] = date('F');
        $validated['order_year'] = date('Y');

        $order_id = DB::table('orders')->insertGetId($validated);

        $contents = DB::table('pos')->get();

        $data = array();
        foreach ($contents as $content){
            $data['order_id'] = $order_id;
            $data['product_id'] = $content->product_id;
            $data['pro_quantity'] = $content->pro_quantity;
            $data['product_price'] = $content->product_price;
            $data['sub_total'] = $content->sub_total;
            DB::table('order_details')->insert($data);

            $productUpdated = Product::where('id',$content->product_id)->update(['product_quantity' => DB::raw('product_quantity - ' . $content->pro_quantity)]);
        }
        DB::table('pos')->delete();
        return response('Done');
    }

    public function TodaySell(){
        $date = date('d/m/Y');
        $sell = DB::table('orders')->where('order_date',$date)->count();
        return response()->json($sell);
    }

    public function TodayEarning(){
        $date = date('d/m/Y');
        $sell = DB::table('orders')->where('order_date',$date)->sum('pay');
        return response()->json($sell);
    }

    public function StockOut(){
        $product = Product::with('supplier','category')->where('product_quantity','<','1')->get();
        return response()->json($product);
    }

    public function StockIn(){
        $product = Product::where('product_quantity','>','1')->get();
        return response()->json($product);
    }
}
