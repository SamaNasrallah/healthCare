<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function index()
    {
        return view('admin.backup.index');
    }

    public function backupPatientData()
    {

        $patients = Patient::all();
        $patientData = $patients->toJson();

        $path = storage_path('app/backup-temp/patient_data_backup.json');
        file_put_contents($path, $patientData);

        return redirect()->back()->with('status', 'Backup created successfully!');
    }


    public function backupPatientDataEncryption()
    {
        $patients = Patient::all();
        $patientData = $patients->toJson();
        $encryptedData = Crypt::encryptString($patientData);

        $path = storage_path('app/backup-temp/patient_data_backup.json');
        file_put_contents($path, $encryptedData);

        return redirect()->back()->with('status', 'Encrypted backup created successfully!');
    }

}
