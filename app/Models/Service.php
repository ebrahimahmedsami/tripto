<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends model
{
    use hasfactory,softdeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name','status','desc','queue_number','range_time','department_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department(){
        return $this->belongsto(Department::class,'department_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members(){
        return $this->belongstomany(Member::class, 'member_services');
    }

    /**
     * @param $query
     * @param $req
     * @return mixed
     */
    public function scopegetdata($query, $req){
        return $query->when((isset($req['searchterm']) && $req['searchterm'] != null),function($query) use ($req){
            $query->where( 'name', 'like', '%' . $req['searchterm'] . '%' );
        });
    }

    /**
     * interact with the user's created at.
     *
     * @return attribute
    */
    public function createdat(): attribute{
        return new attribute(
            get: fn ($value) => carbon::parse($value)->format('y-m-d'),
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function users(){
        return $this->morphmany(user::class, 'assignable');
    }
}
