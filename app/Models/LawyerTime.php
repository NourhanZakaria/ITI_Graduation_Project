<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lawyer;
use App\Models\Appointment;
class LawyerTime extends Model
{
    use HasFactory;
    protected $fillable=['startHour','endHour','day'];
    protected $table="lawyer_time";
    function lawyer()
    {
        return $this->belongsTo(Lawyer::class);
    }

    
   function appointment(){
    return $this->hasMany(Appointment::class);
   }
}
