<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lawyer extends Model
{
    use HasFactory;

    function can_be()
    {
        return $this->belongsTo(User::class);
    }

    function followers(){
         return $this->belongsToMany(User::class);
    }

    function chat(){
         return $this->belongsToMany(User::class);
    }

     
    function specialization(){
        return $this->belongsToMany(Specialization::class);
   }

    function lawyer_time(){
        return $this->hasMany(LawyerTime::class);
    }
}
