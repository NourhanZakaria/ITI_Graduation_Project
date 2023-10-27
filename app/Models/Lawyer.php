<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Specialization;


class Lawyer extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'span',
        'user_id',
        'about',
        'location',
    ];

    protected $hidden = [
        'user_id',
        'created_at',
        'updated_at',
    ];

    function user()
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
        return $this->belongsToMany(Specialization::class,'lawyer_specialization','lawyer_id','specialization_id');
   }

    function lawyer_time(){
        return $this->hasMany(LawyerTime::class);
    }

   
}
