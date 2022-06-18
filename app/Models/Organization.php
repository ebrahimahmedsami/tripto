<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Branch;
use App\Models\Department;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name','desc','lat','long','email','address','token','instance_id','welcome_msg','success_msg',
        'error_msg', 'department_msg', 'service_msg','phone','logo','qr_code','website_url','status'
    ];

    /**
     * Get the user's first name.
     *
     * @return Attribute
     */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('Y-m-d'),
        );
    }

    public function branches(){
        return $this->hasMany(Branch::class,'organization_id');
    }

    public function departments(){
        return $this->hasMany(Department::class,'organization_id');
    }

    public function scopeFilter($query, $request){
        return $query->when((isset($request['searchTerm']) && $request['searchTerm'] != null),function($query) use ($request){
            $query->where( 'name', 'LIKE', '%' . $request['searchTerm'] . '%' );
        });
    }

    public function users(){
        return $this->morphMany(User::class, 'assignable');
    }

}
