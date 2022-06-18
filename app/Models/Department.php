<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Organization;
use App\Models\Branch;
use App\Models\Service;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','desc','phone','status','branch_id','organization_id'
    ];

    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id');
    }

    public function organization(){
        return $this->belongsTo(Organization::class,'organization_id');
    }

    public function services(){
        return $this->hasMany(Service::class,'department_id');
    }
    public function getCreatedAtAttribute($val){
        return Carbon::parse($val)->format('Y-m-d');
    }

    public function scopeDepartmentData($query,$req){
        return $query->when((isset($req['searchTerm']) && $req['searchTerm'] != null),function($query) use ($req){
            $query->where( 'name', 'LIKE', '%' . $req['searchTerm'] . '%' );
        })
        ->orderBy($req->field,$req->type)
        ->paginate( $req->per_page );
    }

    public function users(){
        return $this->morphMany(User::class, 'assignable');
    }
}
