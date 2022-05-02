<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DateTime;
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
        return response()->json($orderDetails);
    }

    public function OrderSearch(Request $request){
        $validated = $request->validate([
            'date' => 'required'
        ]);

        $orderdate = $request->date;
        $newdate = new DateTime($orderdate);
        $done = $newdate->format('d/m/Y');

        $order = DB::table('orders')
            ->join('customers','orders.customer_id','customers.id')
            ->select('customers.name','orders.*')
            ->where('orders.order_date',$done)
            ->get();

        return response()->json($order);
    }
}
