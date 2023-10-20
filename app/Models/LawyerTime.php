<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LawyerTime extends Model
{
    use HasFactory;

    function lawyer()
    {
        return $this->belongsTo(Lawyer::class);
    }

    
   function appointment(){
    return $this->hasMany(Appointment::class);
   }
}
