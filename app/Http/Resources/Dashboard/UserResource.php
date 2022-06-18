<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $userData = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'image' => $this->image,
            'status' => $this->status,
            'type' => $this->type,
            'ability' => [["action"=> "manage", "subject"=> "all"]],
            'group_id' => $this->role_id,
            'group' => @$this->group->roleName,
            'permissions' => $this->group ?  json_decode($this->group->permissions) : [],
        ];
        return [
            'accessToken' => $this->createToken('token-name', ['server:update'])->plainTextToken,
            'refreshToken' => $this->createToken('token-name', ['server:update'])->plainTextToken,
            'userData' => $userData
        ];
    }
}
