<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'image' => $this->image,
            'phpne' => $this->phone,
            'status' => $this->status,
            'type' => TypeUser($this->type) ,
            'ability' => [["action"=> "manage", "subject"=> "all"]],
            'group_id' => $this->role_id,
            'created_at'=>$this->created_at,
            'phone'=>$this->phone,
            'group' => @$this->group->roleName,
            'permissions' => $this->group ?  json_decode($this->group->permissions) : [],
        ];
    }
}
