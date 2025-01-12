<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Diagnosis;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Notification;
use App\Models\Patient;
use App\Models\User;
use App\Notifications\PatientCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AdminController extends Controller
{
    public function index(){
        $totalPatients = Patient::count();
        $totalInvoices = Invoice::count();
        $totalDoctors = Doctor::count();
        $admin = auth()->user();
        $notifications = $admin->notifications;
        $unreadNotifications = $admin->notifications->whereNull('read_at')->count();
        $recentPatients = Patient::latest()->take(5)->get();
        $recentInvoices = Invoice::latest()->take(5)->get();

        return view('admin.index', compact('totalPatients', 'totalInvoices', 'totalDoctors','notifications','unreadNotifications','recentPatients','recentInvoices'));
    }


    public function notification(){
        $admin = auth()->user();
        $notifications = $admin->notifications;

        return view('admin.notifications', compact('notifications'));
    }

    public  function markAsRead($id)
    {
        $admin = auth()->user();
        $notification = $admin->notifications()->find($id);

        if ($notification) {
            $notification->update(['read_at' => now()]);
        }

        return redirect()->route('admin.notifications');
    }

    public function createPatient()
    {
        return view('admin.patients.create');
    }

    public function storePatient(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:3',
            'address' => 'required|string|max:255',
            'dob' => 'required|date',
            'patient_phone_number' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
        ]);

        Log::info('Patient registration started.', ['data' => $validatedData]);

        try {
            do {
                $patientId = 'PID-' . strtoupper(Str::random(8));
            } while (Patient::where('patient_id', $patientId)->exists());

            Log::info('Generated Patient ID:', ['patient_id' => $patientId]);

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'patient',
            ]);

            Log::info('User created successfully.', ['user_id' => $user->id]);

            if ($user) {
                $patient = Patient::create([
                    'patient_id' => $patientId,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone_number' => $request->patient_phone_number,
                    'address' => $request->address,
                    'dob' => $request->dob,
                    'gender' => $request->gender,
                    'user_id' => $user->id,
                ]);
                $patient->notify(new PatientCreatedNotification($patient));
                Log::info('Patient created successfully.', ['patient_id' => $patient->id]);

                return redirect()->route('admin.patients.index')->with('success', 'Patient created successfully with Patient ID: ' . $patientId);
            }

            Log::error('Failed to create user.');

            return back()->withErrors('There was an error creating the patient.');
        } catch (\Exception $e) {
            Log::error('Error occurred while creating patient.', ['error' => $e->getMessage()]);

            return back()->withErrors('Error: ' . $e->getMessage());
        }
    }



    public function createDoctor()
    {
        return view('admin.doctors.create');
    }

    public function storeDoctor(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:3',
            'specialization' => 'required|string|max:255',
            'license_number' => 'required|string|max:255|unique:doctors,license_number',
            'doctor_phone_number' => 'required|string|max:255',
            'experience_years' => 'nullable|integer|min:0',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'doctor',
        ]);

        Doctor::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'specialization' => $request->specialization,
            'email' => $request->email,
            'phone_number' => $request->doctor_phone_number,
            'license_number' => $request->license_number,
            'experience_years' => $request->experience_years,
        ]);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor created successfully!');
    }


    public function indexAdminPatient()
    {
        $patients = Patient::all();
        return view('admin.patients.index', compact('patients'));
    }


    public function editPatient(Patient $patient)
    {
        return view('admin.patients.edit', compact('patient'));
    }


    public function updatePatient(Request $request, Patient $patient)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email,' . $patient->id,
            'phone_number' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $patient->user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
        ]);
        $patient->update($request->all());
        return redirect()->route('admin.patients.index')->with('success', 'Patient updated successfully!');
    }

    public function destroyPatient(Patient $patient)
    {
        $patient->user->delete();
        $patient->delete();
        return redirect()->route('admin.patients.index')->with('success', 'Patient deleted successfully!');
    }


    public function toggleStatusPatient($patientId)
    {

        $patient = Patient::findOrFail($patientId);


        $user = $patient->user;


        $user->is_active = !$user->is_active;
        $user->save();

        return redirect()->route('admin.patients.index')->with('success', 'Patient account status updated successfully!');
    }


    public function indexAdminDoctor()
    {
        $doctors = Doctor::all();
        return view('admin.doctors.index', compact('doctors'));
    }


    public function editDoctor(Doctor $doctor)
    {
        return view('admin.doctors.edit', compact('doctor'));
    }


    public function updateDoctor(Request $request, Doctor $doctor)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email,' . $doctor->id,
            'phone_number' => 'nullable|string',
            'specialization' => 'required|string|max:255',
            'license_number' => 'required|string|max:255|unique:doctors,license_number',
            'experience_years' => 'nullable|integer|min:0',
        ]);

        $doctor->update($request->all());
        $doctor->user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
        ]);
        return redirect()->route('admin.doctors.index')->with('success', 'Doctor updated successfully!');
    }


    public function destroyDoctor(Doctor $doctor)
    {
        $doctor->user->delete();

        $doctor->delete();

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor and associated user deleted successfully!');
    }

    public function toggleStatusDoctor($doctorId)
    {
        $doctor = Doctor::findOrFail($doctorId);

        $user = $doctor->user;

        $user->is_active = !$user->is_active;
        $user->save();

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor account status updated successfully!');
    }



}
