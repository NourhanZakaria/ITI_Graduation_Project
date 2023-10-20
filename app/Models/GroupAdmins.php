<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupAdmins extends Model
{
    use HasFactory;


    function group(){
        return $this->belongsToMany(Group::class);
   }

}
