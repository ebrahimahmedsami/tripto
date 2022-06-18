<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class RolesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $permissionsCollection  = collect(json_decode($this->permissions));
        foreach (permissions() as $permission){
            $checkPermission = $permissionsCollection->contains('name',$permission);
            if(!$checkPermission){
                $item = ['name'=>$permission,'read'=>false,'write'=>false,'update'=>false,'delete'=>false];
                $permissionsCollection->push((object)$item);
            }
        }
        $selected_count = $permissionsCollection
            ->where('read',true)
            ->where('write',true)
            ->where('update',true)
            ->where('delete',true)->count();
        return [
            'id' => (int)$this->id,
            'name' => (string)$this->roleName,
            'permissions' => $permissionsCollection->toArray(),
            'select_all' => (bool) ($selected_count == $permissionsCollection->count())
        ];
    }
}
