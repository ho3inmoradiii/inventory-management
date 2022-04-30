<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Helper\File;

class ProductController extends Controller
{
    use File;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('supplier','category')->get();
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {

        $validated = $request->validated();
        if ($request->hasFile('file')){

            $image_url = $this->file($request->file,'backend/product/',240,200);
            $validated['image'] = $image_url;
            $employee = Product::create($validated);
        }else{
            $employee = Product::create($validated);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProductRequest $request, $id)
    {
        $validated = $request->validated();
        if ($request->hasFile('file')){
            $image_url = $this->file($request->file('file'),'backend/product/',240,200);
            if ($request->image != '')
            {
                unlink($request->image);
            }
            $validated['image'] = $image_url;
            $employee = Product::where('id',$id)->update($validated);
        }else{
            $employee = Product::where('id',$id)->update($validated);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product->image){
            unlink($product->image);
            $product->delete();
        }
        $product->delete();
    }
}
