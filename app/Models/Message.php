<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'msg_id' , 'member_id', 'body', 'msg_type', 'from_me', 'msg_date', 'contact_number'];
    /**
     * Get all of the models that own comments.
     */
    public function reservable()
    {
        return $this->morphTo();
    }
}
