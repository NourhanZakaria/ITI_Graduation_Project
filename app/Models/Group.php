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

   function groupAdmin(){
      return $this->belongsToMany(GroupAdmin::class);
   }
   
}
