<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Diagnosis;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Patient;
use App\Notifications\DiagnosisNotification;
use App\Notifications\NewInvoiceNotification;
use Illuminate\Http\Request;

class DiagnosisController extends Controller
{
    public function index()
    {
        $user = auth()->id();
        $doctor = Doctor::where('user_id', $user)->first();
        $diagnoses = Diagnosis::with('patient')->where('doctor_id', $doctor->id)->latest()->paginate(10);
        return view('doctor.diagnosis.index', compact('diagnoses'));
    }

    public function create($patient_id)
    {
        $patient = Patient::find($patient_id);
        return view('doctor.diagnosis.create', compact('patient'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'diagnosis' => 'required|string',
            'prescription' => 'required|string',
        ]);

        $user = auth()->id();
        $doctor = Doctor::where('user_id', $user)->first();

        $diagnosis = Diagnosis::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $doctor->id,
            'diagnosis' => $request->diagnosis,
            'prescription' => $request->prescription,
        ]);

        $appointment = Appointment::where('patient_id', $request->patient_id)
            ->where('doctor_id', $doctor->id)
            ->where('status', 'confirmed')
            ->first();

        if ($appointment) {
            $invoice = new Invoice();
            $invoice->patient_id = $appointment->patient_id;
            $invoice->diagnosis_id = $diagnosis->id;
            $invoice->amount = 50;
            $invoice->status = 'unpaid';
            $invoice->issued_at = now();
            $invoice->save();

            $patient = Patient::find($request->patient_id);
            $patient->notify(new NewInvoiceNotification($invoice));
            $patient->notify(new DiagnosisNotification($request->diagnosis, $request->prescription,$doctor));
        }

        if ($appointment) {
            $appointment->status = 'completed';
            $appointment->save();
        }
        return redirect()->route('doctor.appointments.index')->with('success', 'Diagnosis and Prescription saved successfully, and invoice created.');
    }


    public function show($id)
    {
        $diagnosis = Diagnosis::with('patient')->findOrFail($id);
        return view('doctor.diagnosis.show', compact('diagnosis'));
    }
}
