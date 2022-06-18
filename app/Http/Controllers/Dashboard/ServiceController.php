<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ServicesRequest;
use http\Client\Response;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Http\Resources\Dashboard\ServicesResource;
use App\Http\Traits\ResponseTrait;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class ServiceController extends Controller
{
    use ResponseTrait;

    public function __construct(){

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth('sanctum')->user()->cannot('admin', 'read services')) {
            return  \response()->json(['status'=>false,'message'=>'Access Forbidden'],403);
        }
        $services = Service::getData($request)
            ->orderBy($request->field,$request->type)
            ->paginate( $request->per_page);
        return ServicesResource::collection($services);
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
     * @param  ServicesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServicesRequest $request)
    {
        if (auth('sanctum')->user()->cannot('admin', 'write services')) {
            return  \response()->json(['status'=>false,'message'=>'Access Forbidden'],403);
        }
        try{
            Service::create($request->validated());
            return $this->returnSuccessMessage('Service Stored Succeffully');

         } catch (ValidationException $e) {
            return $this->validationError($e,'validation err');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Service $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Service $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        if (auth('sanctum')->user()->cannot('admin', 'update services')) {
            return  \response()->json(['status'=>false,'message'=>'Access Forbidden'],403);
        }
        return $this->returnData('service',new ServicesResource($service));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ServicesRequest  $request
     * @param  Service $service
     * @return \Illuminate\Http\Response
     */
    public function update(ServicesRequest $request, Service $service)
    {
        if (auth('sanctum')->user()->cannot('admin', 'update services')) {
            return  \response()->json(['status'=>false,'message'=>'Access Forbidden'],403);
        }
        try{
            $service->update($request->validated());
            return $this->returnSuccessMessage('Service Updated Succeffully');

         } catch (ValidationException $e) {
            return $this->validationError($e,'validation err');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Service $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        if (auth('sanctum')->user()->cannot('admin', 'delete services')) {
            return  \response()->json(['status'=>false,'message'=>'Access Forbidden'],403);
        }
        try{
            $service->delete();
            return $this->returnSuccessMessage('Service Deleted Succeffully');
         } catch (\Exception $e) {
            return $this->returnError(500,'err');
        }
    }
}
