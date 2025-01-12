<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    use HasFactory;

    protected $table = 'diagnoses_and_prescriptions';
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'diagnosis',
        'prescription',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }


    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
