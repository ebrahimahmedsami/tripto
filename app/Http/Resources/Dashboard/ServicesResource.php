<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class ServicesResource extends JsonResource
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
            'id' => (int)$this->id,
            'name'=> (string)$this->name,
            'status'=> (string)$this->status,
            'desc'=> (string)$this->desc,
            'range_time'=> (string)$this->range_time,
            'queue_number'=> (int)$this->queue_number,
            'department_id'=> (int)$this->department_id,
            'department_name'=> (string)@$this->department->name,
            'created_at'=> (string)$this->created_at,
        ];
    }
}
