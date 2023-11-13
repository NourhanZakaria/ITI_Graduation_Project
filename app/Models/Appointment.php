<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LawyerTime;
use App\Models\User;
use App\Models\Review;
use Thomasjohnkane\Snooze\Traits\SnoozeNotifiable;
use Illuminate\Notifications\Notifiable;


class Appointment extends Model
{
    use HasFactory;
    use Notifiable, SnoozeNotifiable;

    protected $fillable = [
        'payment_method',
        'appointment_date',
        'client_name',
        'client_phone',
        'client_email',
        'user_id',
        'lawyer_time_id',
    ];

    protected $hidden = [
        'user_id',
        'lawyer_time_id',
        'created_at',
        'updated_at',
    ];

    function lawyer_time()
    {
        return $this->belongsTo(LawyerTime::class);
    }
    function user()
    {
        return $this->belongsTo(User::class);
    }

    function review()
    {
        return $this->belongsTo(Review::class);
    }
}
