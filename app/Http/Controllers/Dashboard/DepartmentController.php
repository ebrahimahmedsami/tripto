<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\DepartmentRequest;
use App\Http\Resources\Dashboard\DepartmentsResource;
use App\Http\Traits\ResponseTrait;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DepartmentController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth('sanctum')->user()->cannot('admin', 'read departments')) {
            return  \response()->json(['status'=>false,'message'=>'Access Forbidden'],403);
        }
        $branches = Department::departmentData($request);
        return DepartmentsResource::collection($branches);
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
    public function store(DepartmentRequest $request)
    {
        if (auth('sanctum')->user()->cannot('admin', 'write departments')) {
            return  \response()->json(['status'=>false,'message'=>'Access Forbidden'],403);
        }
        try{
            Department::create($request->all());
            return $this->returnSuccessMessage('Department Stored Succeffully');
        } catch (ValidationException $e) {
            return $this->validationError($e,'validation err');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (auth('sanctum')->user()->cannot('admin', 'update departments')) {
            return  \response()->json(['status'=>false,'message'=>'Access Forbidden'],403);
        }
        try{
            $departments=Department::findOrFail($id);
            if($departments){
                return $this->returnData('departments',$departments);
            }
        } catch (\Exception $e) {
            return $this->validationError($e,'err');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Department $department,DepartmentRequest $request)
    {
        if (auth('sanctum')->user()->cannot('admin', 'update departments')) {
            return  \response()->json(['status'=>false,'message'=>'Access Forbidden'],403);
        }
        try{
            if($department){
               $department->update($request->all());
            }
        } catch (\Exception $e) {
            return $this->validationError($e,'err');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        if (auth('sanctum')->user()->cannot('admin', 'delete departments')) {
            return  \responsenp()->json(['status'=>false,'message'=>'Access Forbidden'],403);
        }
        try{
            if($department){
                $department->delete();
            }
            return $this->returnSuccessMessage('department Deleted Succeffully');
        } catch (\Exception $e) {
            dd($e);
            return $this->returnError(500,'err');
        }
    }
}
