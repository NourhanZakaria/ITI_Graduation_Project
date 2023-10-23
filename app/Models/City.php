<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class City extends Model
{
    use HasFactory;

    function country()
    {
        return $this->belongsTo(Country::class);
    }

    function user(){
        return $this->belongsToMany(User::class);
    }

}
