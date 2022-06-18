<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = ['roleName','permissions','created_at','updated_at'];

    public function scopeRolesData($query,$req){
        return $query->when((isset($req['searchTerm']) && $req['searchTerm'] != null),function($query) use ($req){
            $query->where( 'roleName', 'LIKE', '%' . $req['searchTerm'] . '%' );
        })
            ->orderBy($req->field,$req->type)
            ->paginate( $req->per_page );
    }
    public function getRoleNameAtripute(){

    }
}
