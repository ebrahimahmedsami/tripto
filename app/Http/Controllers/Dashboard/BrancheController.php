<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\BranchesRequest;
use App\Http\Resources\Dashboard\BranchesResource;
use App\Http\Traits\ResponseTrait;
use App\Models\Branch;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BrancheController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth('sanctum')->user()->cannot('admin', 'read branches')) {
            return  \response()->json(['status'=>false,'message'=>'Access Forbidden'],403);
        }
        $branches = Branch::branchesData($request);
        return BranchesResource::collection($branches);
    }

    public function getAllOrganizations(){
        $organizations = Organization::all();
        return response()->json(['status'=>true,'data'=>$organizations]);
    }
    public function getAllBranches($org_id){
        $branches= Branch::whereOrganizationId($org_id)->get();
        return response()->json(['status'=>true,'data'=>$branches]);
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
    public function store(BranchesRequest $request)
    {
        if (auth('sanctum')->user()->cannot('admin', 'write branches')) {
            return  \response()->json(['status'=>false,'message'=>'Access Forbidden'],403);
        }
        try{
            Branch::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->desc,
                'organization_id' => $request->org,
            ]);
            return $this->returnSuccessMessage('Branch Stored Succeffully');

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
        if (auth('sanctum')->user()->cannot('admin', 'update branches')) {
            return  \response()->json(['status'=>false,'message'=>'Access Forbidden'],403);
        }
        try{
            $branche = Branch::find($id);
            if($branche){
                return $this->returnData('branch',$branche);
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
    public function update(BranchesRequest $request,$id)
    {
        if (auth('sanctum')->user()->cannot('admin', 'update branches')) {
            return  \response()->json(['status'=>false,'message'=>'Access Forbidden'],403);
        }
        $branche = Branch::find($id);
        try{
            $branche->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->desc,
                'organization_id' => $request->org,
            ]);
            return $this->returnSuccessMessage('Branch Updated Succeffully');
        } catch (ValidationException $e) {
            return $this->validationError($e,'validation err');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        if (auth('sanctum')->user()->cannot('admin', 'delete branches')) {
            return  \response()->json(['status'=>false,'message'=>'Access Forbidden'],403);
        }
        try{
            if($branch){
                $branch->delete();
            }
            return $this->returnSuccessMessage('Branch Deleted Succeffully');
         } catch (\Exception $e) {
            return $this->returnError(500,'Can not delete because have departments and services');
        }
    }
}
