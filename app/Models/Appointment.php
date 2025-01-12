<?php

namespace App\Models;

use App\Models\Doctor;
use App\Models\Patient;


use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id', 'doctor_id', 'appointment_date', 'status'
    ];
    public function doctor()
{
    return $this->belongsTo(Doctor::class, 'doctor_id');
}
public function patient()
{
    return $this->belongsTo(Patient::class, 'patient_id');
}
}
