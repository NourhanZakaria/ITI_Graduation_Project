<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Plan extends Model
{
    use HasFactory;

    function user()
    {
        return $this->hasMany(User::class);
    }
}