<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberService extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id','service_id','status','member_type','feedback','completed_feedback','current_members_service',
    ];

    public function service(){
        return  $this->belongsTo(Service::class, 'service_id');
    }
}
