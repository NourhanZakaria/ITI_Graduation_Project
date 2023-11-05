<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LawyerSpecialization extends Model
{
    use HasFactory;

    protected $table = 'lawyer_specialization';
    protected $fillable = [
        'id',
        'lawyer_id',
        'specialization_id',
    ];
}
