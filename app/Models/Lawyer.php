<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Specialization;
use App\Models\LawyerTime;
use App\Models\User;
class Lawyer extends Model
{
    use HasFactory;
    protected $fillable=['price','span'];

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

    function lawyerTime(){
        return $this->hasMany(LawyerTime::class);
    }
}
