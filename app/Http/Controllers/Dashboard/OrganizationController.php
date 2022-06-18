<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\OrganizationRequest;
use App\Http\Resources\Dashboard\OrganizationResource;
use App\Http\Traits\ResponseTrait;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Organization;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrganizationController extends Controller
{
    use  ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth('sanctum')->user()->cannot('admin', 'read organizations')) {
            return  \response()->json(['status'=>false,'message'=>'Access Forbidden'],403);
        }
         $organizations = Organization::filter($request)
                                     ->orderBy($request->field,$request->type)
                                     ->paginate( $request->per_page );
         return OrganizationResource::collection($organizations);
/*         $this->returnData( 'data', OrganizationResource::collection($organizations), 'Organization Data Returned Successfully' );*/
    }

    /**
     * Store a newly created organization in storage.
     *
     * @param  OrganizationRequest  $request
     * @return Response
     */
    public function store(OrganizationRequest $request)
    {


        if (auth('sanctum')->user()->cannot('admin', 'write organizations')) {
            return  \response()->json(['status'=>false,'message'=>'Access Forbidden'],403);
        }
        $data = $request->except('logo');
        if( isset($request->logo) && $request->logo->isValid())
            $data['logo'] = imageUpload($request->logo, 'images/organization/logo');

        $data['qr_code'] = generateQrcode($request->name,$request->phone);
        $data['welcome_msg'] = $data['temp_msg'];
        $data['success_msg'] = 'GOOOOOOOOOOOD';
        Organization::create($data);
        return $this->returnSuccessMessage('Organization Created Successfully');
    }

    /**
     * Show a newly created organization in storage.
     *
     * @param  Organization  $organization
     * @return Response
     */
    public function show($id)
    {
        $organization = Organization::with('branches.departments.services')->find($id);
        return $this->returnData( 'organization', $organization, 'Organization Data Returned Successfully' );
    }

    public function statistics($id){
        $branches = Branch::whereOrganizationId($id)->count();
        $departments = Department::whereOrganizationId($id)->pluck('id');
        $services = Service::whereIn('department_id', $departments->toArray() )->count();
        $statistics= [
            ['icon' => 'GitMergeIcon', 'color'=>'light-success', 'count' => $branches, 'subtitle' => 'Branches', 'customClass'=>''],
            ['icon' => 'CreditCardIcon', 'color'=>'light-danger', 'count' => $departments->count(), 'subtitle' => 'Departments', 'customClass'=>'mb-2 mb-sm-0'],
            ['icon' => 'ServerIcon', 'color'=>'light-primary', 'count' => $services, 'subtitle' => 'Services', 'customClass'=>'mb-2 mb-xl-0'],
        ];
        return $this->returnData( 'statistics', $statistics, 'statistics Data Returned Successfully' );
    }
    /**
     * Show the form for editing the specified organization.
     *
     * @param  Organization $organization
     * @return Response
     */
    public function edit(Organization $organization)
    {
        if (auth('sanctum')->user()->cannot('admin', 'update organizations')) {
            return  \response()->json(['status'=>false,'message'=>'Access Forbidden'],403);
        }
        return $this->returnData( 'organization', new OrganizationResource($organization), 'Organization Data Returned Successfully' );
    }

    /**
     * Update the specified organization in storage.
     *
     * @param  OrganizationRequest  $request
     * @param  Organization $organization
     * @return \Illuminate\Http\Response
     */
    public function update(OrganizationRequest $request, Organization $organization)
    {
        if (auth('sanctum')->user()->cannot('admin', 'update organizations')) {
            return  \response()->json(['status'=>false,'message'=>'Access Forbidden'],403);
        }
        $data = $request->except('logo');
        if(isset($request->logo) && $request->logo->isValid())
            $data['logo'] = imageUpload($request->logo, 'images/organization/logo');

        $data['welcome_msg'] = $data['temp_msg'];
        $organization->update($data);
        return $this->returnSuccessMessage('Organization Updated Successfully');
    }

    /**
     * Remove the specified organization from storage.
     *
     * @param  Organization $organization
     * @return Response
     */
    public function destroy(Organization $organization)
    {
        if (auth('sanctum')->user()->cannot('admin', 'delete organizations')) {
            return  \response()->json(['status'=>false,'message'=>'Access Forbidden'],403);
        }
        $organization->delete();
        return $this->returnSuccessMessage('Organization Deleted Successfully');
    }

}
