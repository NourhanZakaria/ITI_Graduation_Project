<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    function user(){
        return $this->belongsToMany(User::class);
   }

   function post(){
    return $this->belongsToMany(Post::class);
   }

   function create()
    {
        return $this->belongsTo(User::class);
    }
   
   
   
}
