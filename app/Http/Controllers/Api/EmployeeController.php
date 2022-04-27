<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Helper\File;

class EmployeeController extends Controller
{
    use File;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();
        return response()->json($employees);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployeeRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('file')){
            $image_url = $this->file($request->file,'backend/employee/',240,200);
            $validated['photo'] = $image_url;
            $employee = Employee::create($validated);
        }else{
            $employee = Employee::create($validated);
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
        $employee = Employee::select('fullName','email','address','joiningDate','phone','photo')->where('id',$id)->first();
        return response()->json($employee);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreEmployeeRequest $request, $id)
    {
        $validated = $request->validated();
        if ($request->hasFile('file')){
            $image_url = $this->file($request->file('file'),'backend/employee/',240,200);
            if ($request->photo != '')
            {
                unlink($request->photo);
            }
            $validated['photo'] = $image_url;
            $employee = Employee::where('id',$id)->update($validated);
        }else{
            $employee = Employee::where('id',$id)->update($validated);
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
        $employee = Employee::find($id);
        $photo = $employee->photo;
        if ($photo){
            unlink($photo);
            $employee->delete();
        }
        $employee->delete();
    }
}
