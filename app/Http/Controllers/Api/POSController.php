<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class POSController extends Controller
{
    public function subProduct($id){
        $subProduct = Product::where('category_id',$id)->get();
        return response()->json($subProduct);
    }
}
