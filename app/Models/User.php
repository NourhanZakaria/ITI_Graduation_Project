<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Lawyer;
use App\Models\City;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'image',
        'phone',
        'role',
        'city_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    function lawyer()
    {
        return $this->belongsTo(Lawyer::class);
    }

    function follow(){
        return $this->belongsToMany(Lawyer::class);
    }

    function chat(){
        return $this->belongsToMany(Lawyer::class);
   }

    function user_joinGroup(){
        return $this->belongsToMany(Group::class);
   }

   function user_createGroup(){
      return $this->belongsToMany(Group::class);
   }

    function plane()
    {
        return $this->belongsTo(Plane::class);
    }

    function post()
    {
        return $this->hasMany(Post::class);
    }

    function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    function city()
    {
        return $this->belongsTo(City::class,'city_id');
    }

   
}
