<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Http\Resources\Dashboard\RolesResource;
use App\Http\Traits\ResponseTrait;

class RoleController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth('sanctum')->user()->cannot('admin', 'read roles')) {
            return  \response()->json(['status'=>false,'message'=>'Access Forbidden'],403);
        }
        $roles = Role::RolesData($request);
        return RolesResource::collection($roles);
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
    public function store(Request $request)
    {

        if (auth('sanctum')->user()->cannot('admin', 'write roles')) {

            return  \response()->json(['status'=>false,'message'=>'Access Forbidden'],403);
        }
        $this->validate($request,[
            'role'=> 'required|string',
            'permissions'=> 'required'
        ]);
        $inputs['roleName'] = $request['role'];
        $inputs['permissions'] = $request['permissions'];
        Role::updateOrCreate(['roleName'=>$inputs['roleName']],$inputs);
        return $this->returnSuccessMessage(__('role added successfully'));
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
     * @param  Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        if (auth('sanctum')->user()->cannot('admin', 'update roles')) {
            return  \response()->json(['status'=>false,'message'=>'Access Forbidden'],403);
        }
        return $this->returnData('role',new RolesResource($role));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        if (auth('sanctum')->user()->cannot('admin', 'update roles')) {
            return  \response()->json(['status'=>false,'message'=>'Access Forbidden'],403);
        }
//        dd(json_decode($request['permissions']));
        $this->validate($request,[
            'role'=> 'required|string',
            'permissions'=> 'required'
        ]);
        $inputs['roleName'] = $request['role'];
        $inputs['permissions'] = $request['permissions'];
        $role->update($inputs);
        return $this->returnData('permissions',json_decode($request['permissions']),__('role updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if (auth('sanctum')->user()->cannot('admin', 'delete roles')) {
            return  \response()->json(['status'=>false,'message'=>'Access Forbidden'],403);
        }
        try{
            if($role->id == auth()->user()->role_id){
                return  \response()->json(['status'=>false,'message'=>'Access Forbidden'],403);
            }
            $role->delete();
            return $this->returnSuccessMessage('Service Deleted Succeffully');
         } catch (\Exception $e) {
            return $this->returnError(500,'err');
        }
    }
}
