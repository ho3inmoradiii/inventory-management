<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function orders(){
        $orders = DB::table('orders')
                    ->join('customers', 'orders.customer_id', '=', 'customers.id')
                    ->where('order_date',date('d/m/Y'))
                    ->select('orders.*', 'customers.name')
                    ->orderBy('orders.id','DESC')
                    ->get();
        return response()->json($orders);
    }

    public function OrderCustomer($id){
        $customer = DB::table('orders')
                    ->join('customers', 'orders.customer_id', '=', 'customers.id')
                    ->where('orders.id',$id)
                    ->select('orders.*', 'customers.name', 'customers.phone', 'customers.address')
                    ->first();
        return response()->json($customer);
    }

    public function OrderDetails($id){
        $orderDetails = DB::table('order_details')
            ->join('products','order_details.product_id','products.id')
            ->where('order_details.order_id',$id)
            ->select('products.product_name','products.product_code','products.image','order_details.*')
            ->get();
//        $orderDetails = DB::table('order_details')
//            ->join('products', 'order_details.product_id', '=', 'products.id')
//            ->where('order_details.order_id',$id)
//            ->select('order_details.pro_quantity','order_details.id','order_details.product_price','order_details.sub_total', 'products.product_name','products.product_code','products.image')
//            ->first();
        return response()->json($orderDetails);
    }
}
