<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Government extends Model
{
    use HasFactory;
    Protected $guardes = [];

    public function cities(){
        return  $this->hasMany(Cities::class, 'government_id');
    }
}