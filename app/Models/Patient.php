<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
class Patient extends Model
{
    use Notifiable;
    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone_number', 'address', 'dob', 'gender','user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($patient) {
            $patient->patient_id = 'PID-' . strtoupper(Str::random(8));
        });
    }

}
