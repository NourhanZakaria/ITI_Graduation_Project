<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Post;
class Group extends Model
{
    use HasFactory;

    function user_join(){
        return $this->belongsToMany(User::class);
   }

   
   function hasPost(){
    return $this->belongsToMany(Post::class);
   }

   function userCreator()
    {
        return $this->belongsTo(User::class);
    }




 
}
