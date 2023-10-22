<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable=['rate','comment','appointment_id'];
    function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
