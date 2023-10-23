<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lawyer;
class Specialization extends Model
{
    use HasFactory;

    function lawyer(){
        return $this->belongsToMany(Lawyer::class);
   }
}
