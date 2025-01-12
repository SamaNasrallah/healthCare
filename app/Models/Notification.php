<?php

namespace App\Models;

use App\Models\Notification;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'patient_id', 'message', 'status'
    ];
    public function notifications()
{
    return $this->hasMany(Notification::class, 'doctor_id');
}
}
