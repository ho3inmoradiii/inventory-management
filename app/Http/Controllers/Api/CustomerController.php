<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Helper\File;

class CustomerController extends Controller
{
    use File;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();
        return response()->json($customers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('file')){
            $image_url = $this->file($request->file,'backend/customer/',240,200);
            $validated['photo'] = $image_url;
            $employee = Customer::create($validated);
        }else{
            $employee = Customer::create($validated);
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
        $customer = Customer::select('name','email','address','phone','photo')->where('id',$id)->firstOrfail();
        return response()->json($customer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCustomerRequest $request, $id)
    {
        $validated = $request->validated();
        if ($request->hasFile('file')){
            $image_url = $this->file($request->file('file'),'backend/customer/',240,200);
            if ($request->photo != '')
            {
                unlink($request->photo);
            }
            $validated['photo'] = $image_url;
            $employee = Customer::where('id',$id)->update($validated);
        }else{
            $employee = Customer::where('id',$id)->update($validated);
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
        $customer = Customer::find($id);
        if ($customer->photo){
            unlink($customer->photo);
            $customer->delete();
        }
        $customer->delete();
    }
}
