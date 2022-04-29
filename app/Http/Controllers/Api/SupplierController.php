<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Helper\File;

class SupplierController extends Controller
{
    use File;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return response()->json($suppliers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSupplierRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('file')){
            $image_url = $this->file($request->file,'backend/supplier/',240,200);
            $validated['photo'] = $image_url;
            $employee = Supplier::create($validated);
        }else{
            $employee = Supplier::create($validated);
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
        $supplier = Supplier::select('name','email','address','shopname','phone','photo')->where('id',$id)->firstOrfail();
        return response()->json($supplier);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSupplierRequest $request, $id)
    {
        $validated = $request->validated();
        if ($request->hasFile('file')){
            $image_url = $this->file($request->file('file'),'backend/supplier/',240,200);
            if ($request->photo != '')
            {
                unlink($request->photo);
            }
            $validated['photo'] = $image_url;
            $employee = Supplier::where('id',$id)->update($validated);
        }else{
            $employee = Supplier::where('id',$id)->update($validated);
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
        $supplier = Supplier::find($id);
        if ($supplier->photo){
            unlink($supplier->photo);
            $supplier->delete();
        }
        $supplier->delete();
    }
}
