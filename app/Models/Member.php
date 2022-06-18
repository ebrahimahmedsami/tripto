<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Service;


class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','phone', 'status', 'is_oline', 'last_seen'
    ];

    public function services(){
        return $this->belongsToMany(Service::class, 'member_services');
    }
}
