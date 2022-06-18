<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    use HasFactory;
    Protected $guardes = [];

    public function government(){
        return  $this->belongsTo(Government::class, 'government_id');
    }
}
