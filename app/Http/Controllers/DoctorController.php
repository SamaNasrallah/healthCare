<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\MedicalAdviceAd;
use App\Models\MedicalRecords;
use App\Models\Patient;
use App\Models\User;
use App\Notifications\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DoctorController extends Controller
{
    public function index(){
        $doctor = auth()->user()->doctor;
        $notifications = $doctor->notifications ?? collect();
    
        $unreadNotifications = $notifications->whereNull('read_at')->count();
        $advertisement = MedicalAdviceAd::inRandomOrder()->first();
        $upcomingAppointments = Appointment::where('status', 'confirmed')
            ->where('appointment_date', '>', Carbon::now())
            ->orderBy('appointment_date', 'asc')
            ->count();

        $totalPatients = Patient::count();
        $followedPatients = Patient::whereHas('appointments', function($query) {
            $query->havingRaw('COUNT(*) > 1');
        })->count();
        return view('doctor.index',compact('notifications','unreadNotifications','advertisement'
            ,'upcomingAppointments','totalPatients','followedPatients'));
    }


    public function patient(Request $request)
    {
        $search = $request->query('search');
        $doctorId = auth()->user()->doctor->id;
        $recentPatients = Patient::whereHas('appointments', function ($query) use ($doctorId) {
            $query->where('doctor_id', $doctorId);
        })
            ->withCount(['appointments' => function($query) use ($doctorId) {
                $query->where('doctor_id', $doctorId);
            }])
            ->having('appointments_count', 1)
            ->when($search, function ($query, $search) {
                $query->where('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            })
            ->paginate(10);

        $oldPatients = Patient::whereHas('appointments', function ($query) use ($doctorId) {
            $query->where('doctor_id', $doctorId);
        })
            ->withCount(['appointments' => function($query) use ($doctorId) {
                $query->where('doctor_id', $doctorId);
            }])
            ->having('appointments_count', '>', 1)
            ->when($search, function ($query, $search) {
                $query->where('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            })
            ->paginate(10);

        return view('doctor.patients.index', compact('recentPatients', 'oldPatients'));
    }


    public function show($id)
    {

        $id = intval($id);


        $medicalRecords = MedicalRecords::where('patient_id', $id)->get();

        $medicalRecords = collect($medicalRecords);

        $patient = Patient::findOrFail($id);
        return view('doctor.patients.show', compact('patient','medicalRecords'));
    }

    public function notification(){
        $doctor = auth()->user()->doctor;
        $notifications = $doctor->notifications;
        return view('doctor.notifications', compact('notifications'));
    }

    public function profile(){
        $doctor = auth()->user()->doctor;
        return view('doctor.profile',compact('doctor'));
    }

public  function markAsRead($id)
{
    $doctor = auth()->user()->doctor;
    $notification = $doctor->notifications()->find($id);

    if ($notification) {
        $notification->update(['read_at' => now()]);
    }

    return redirect()->route('doctor.notifications');
}

    public function requestProfileUpdate($patientId)
    {
        $patient = Patient::find($patientId);
        if ($patient) {

            $patient->notify(new UpdateProfileRequest());

            return redirect()->back()->with('status', 'Patient profile update request sent successfully.');
        }

        return redirect()->back()->with('error', 'Patient not found.');
    }

}
