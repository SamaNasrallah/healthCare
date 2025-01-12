<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;


class MedicalRecords extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'medical_records';

    protected $fillable = [
        'patient_id',
        'file_name', 'file_path', 'file_size', 'file_type', 'uploaded_at'
    ];
}
