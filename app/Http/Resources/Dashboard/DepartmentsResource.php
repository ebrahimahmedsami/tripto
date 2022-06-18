<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name'=>$this->name,
            'phone'=>$this->phone,
            'status'=>$this->status,
            'created_at'=>$this->created_at,
            'services_count'=>@$this->services->count(),
            'organization_id'=>@$this->organization->name ?? '..',
            'branch_id'=>@$this->branch->name ?? '..',
        ];
    }
}
