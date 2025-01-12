<?php

namespace App\Http\Controllers;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $doctor = Doctor::where('user_id',$user->id)->first();
        $doctorId = $doctor->id;

        $appointments = Appointment::where('doctor_id', $doctorId)
            ->whereIn('status', ['pending', 'confirmed', 'cancelled','completed'])
            ->orderBy('appointment_date', 'asc')
            ->get();

        return view('doctor.appointments.index', compact('appointments'));
    }


    public function confirm($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'confirmed';
        $appointment->save();

        $patient = $appointment->patient;
        $patient->notify(new AppointmentStatusUpdatedNotification($appointment));
        return redirect()->route('doctor.appointments.index');
    }


    public function cancel($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'cancelled';
        $appointment->save();
        $patient = $appointment->patient;
        $patient->notify(new AppointmentStatusUpdatedNotification($appointment));
        return redirect()->route('doctor.appointments.index');
    }
}
