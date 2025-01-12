<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecords;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PatientProfileController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $patient = Patient::where('user_id', $user->id)->first();
        $id = intval($patient->id);
        $medicalRecords = MedicalRecords::where('patient_id', $id)->get();
        $medicalRecords = collect($medicalRecords);
        return view('patient.profile', compact('user','patient','medicalRecords'));
    }

    public function update(Request $request)
    {

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'dob' => 'required|date',
            'phone_number' => 'required|string|max:255',
            'documents.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
        ]);

        $user = Auth::user();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->save();

        $patient = Patient::where('user_id', $user->id)->first();
        if ($patient) {
            $patient->first_name = $request->first_name;
            $patient->last_name = $request->last_name;
            $patient->email = $request->email;
            $patient->phone_number = $request->phone_number;
            $patient->address = $request->address;
            $patient->dob = $request->dob;
            $patient->save();
        }


        return redirect()->route('patient.profile')->with('status', 'Profile updated successfully!');
    }

}

