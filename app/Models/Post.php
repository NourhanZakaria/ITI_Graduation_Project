<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

   
    function user()
    {
        return $this->belongsTo(User::class);
    }

    function group(){
        return $this->belongsToMany(Group::class);
   }
}
