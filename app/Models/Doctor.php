<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\Appointment;

class Doctor extends Model
{ use Notifiable;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'specialization', 'phone_number','license_number','experience_years','user_id'
    ];

    // Doctor Model
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }



}
