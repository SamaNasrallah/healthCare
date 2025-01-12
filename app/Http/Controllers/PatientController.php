<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Diagnosis;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\MedicalAdviceAd;
use App\Models\MedicalRecords;
use App\Models\Patient;
use App\Notifications\AppointmentCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class PatientController extends Controller
{
    public function index(){
        $patient = auth()->user()->patient;
        $notifications = $patient->notifications ?? collect();
        $unreadNotifications = $notifications->whereNull('read_at')->count();
        $advertisement = MedicalAdviceAd::inRandomOrder()->first();
        return view('patient.index',compact('notifications','unreadNotifications','advertisement'));
    }

    public function notification(){
        $patient = auth()->user()->patient;
        $notifications = $patient->notifications;

        return view('patient.notifications', compact('notifications'));
    }


    public function showInvoice()
    {
        $patient = auth()->user()->patient;

        $invoice = Invoice::where('patient_id', $patient->id)->first();

        if (!$invoice) {

            return view('patient.invoice.show', ['invoice' => null, 'diagnosis' => null]);
        }

        $diagnosis = Diagnosis::where('id', $invoice->diagnosis_id)->first();

        return view('patient.invoice.show', compact('invoice', 'diagnosis'));
    }


    public  function markAsRead($id)
    {
        $patient = auth()->user()->patient;
        $notification = $patient->notifications()->find($id);

        if ($notification) {
            $notification->update(['read_at' => now()]);
        }

        return redirect()->route('patient.notifications');
    }
    public function showUploadFormRegister()
    {
        return view('patient.uploadDocumentsRegister');
    }
    public function showUploadForm()
    {
        return view('patient.uploadDocuments');
    }

    public function uploadDocumentsRegister(Request $request)
    {
        $request->validate([
            'documents.*' => 'required|file|mimes:jpeg,png,jpg,pdf,mp4,avi,mov|max:2000000',
        ]);

        $uploadedFiles = [];

        if (!$request->hasFile('documents')) {
            return back()->with('error', 'There is no documents to upload');
        }

        foreach ($request->file('documents') as $document) {

            if ($document->isValid()) {
                try {
                    $fileName = $document->getClientOriginalName();
                    $uniqueFileName = time() . '_' . $fileName;

                    $path = $document->storeAs('documents', $uniqueFileName, 'public');
                    $uploadedFiles[] = $path;
                } catch (\Exception $e) {
                    return back()->with('error', 'Error when store documents');
                }


                $patient = Patient::query()->latest()->first();
                $patient_id = $patient->id;
                try {
                    $doc = new MedicalRecords();
                    $doc->patient_id = $patient_id;
                    $doc->file_name = $uniqueFileName;
                    $doc->file_path = $path;
                    $doc->file_size = $document->getSize();
                    $doc->file_type = $document->getClientMimeType();
                    $doc->uploaded_at = now();
                    $doc->save();
                } catch (\Exception $e) {
                    return back()->with('error', 'Error when saving to MongoDB');
                }
            }
        }

        return redirect(route('patient.dashboard'))->with('success', 'Uploaded documents successfully');
    }

    public function uploadDocuments(Request $request)
    {
        $request->validate([
            'documents.*' => 'required|file|mimes:jpeg,png,jpg,pdf,mp4,avi,mov|max:2000000',
        ]);

        $uploadedFiles = [];

        if (!$request->hasFile('documents')) {
            return back()->with('error', 'There is no documents to upload');
        }

        foreach ($request->file('documents') as $document) {

            if ($document->isValid()) {
                try {
                    $fileName = $document->getClientOriginalName();
                    $uniqueFileName = time() . '_' . $fileName;

                    $path = $document->storeAs('documents', $uniqueFileName, 'public');
                    $uploadedFiles[] = $path;
                } catch (\Exception $e) {
                    return back()->with('error', 'Error when store documents');
                }


                $user_id = Auth::user()->id;
                $patient = Patient::query()->where('user_id', $user_id)->first();

                try {
                    $doc = new MedicalRecords();
                    $doc->patient_id = $patient->id;
                    $doc->file_name = $uniqueFileName;
                    $doc->file_path = $path;
                    $doc->file_size = $document->getSize();
                    $doc->file_type = $document->getClientMimeType();
                    $doc->uploaded_at = now();
                    $doc->save();
                } catch (\Exception $e) {
                    return back()->with('error', 'Error when saving to MongoDB');
                }
            }
        }

        return back()->with('success', 'Uploaded documents successfully');
    }

    public function showMedicalRecords()
    {
        $userId = auth()->id();

        $patient= Patient::where('user_id', $userId)->first();
        if (!$patient) {
            return view('patient.medical-records', ['message' => 'Patient not found.']);
        }

        $medicalRecords = MedicalRecords::where('patient_id', $patient->id)->get();
        $medicalRecords = collect($medicalRecords);

        if ($medicalRecords->isEmpty()) {
            return view('patient.showMedicalRecords')->with('medicalRecords', []);
        }


        return view('patient.showMedicalRecords', compact('medicalRecords'));
    }

    public function deleteDocument($id)
    {
        $record = MedicalRecords::findOrFail($id);

        if (Storage::disk('public')->exists($record->file_path)) {
            Storage::disk('public')->delete($record->file_path);
        }

        $record->delete();

        return redirect()->back()->with('status', 'Document deleted successfully!');
    }

    public function showDoctors(Request $request)
    {
        $specialization = $request->input('specialization');

        $doctors = Doctor::when($specialization, function ($query, $specialization) {
            return $query->where('specialization', $specialization);
        })->get();

        return view('patient.doctors', compact('doctors'));
    }


    public function bookAppointment($doctorId)
    {
        $doctor = Doctor::findOrFail($doctorId);
        return view('patient.bookAppointment', compact('doctor'));
    }



    public function storeAppointment(Request $request, $doctorId)
    {
        $request->validate([
            'appointment_date' => 'required|date|after:today',
        ],[
        'appointment_date.after' => 'The appointment date must be a future date.',
    ]);

        $user = auth()->user();
        $patient = Patient::where('user_id', $user->id)->first();

        if (!$patient) {
            return back()->with('error', 'Patient record not found for this user.');
        }

        $doctor = Doctor::find($doctorId);
        if (!$doctor) {
            return back()->with('error', 'Doctor not found.');
        }

        $existingAppointment = Appointment::where('doctor_id', $doctorId)
            ->where('appointment_date', $request->appointment_date)
            ->first();

        if ($existingAppointment) {
            return redirect()->back()->with('error', 'This appointment time is already booked. Please choose another time.');
        }


        $appointment = new Appointment();
        $appointment->patient_id = $patient->id;
        $appointment->doctor_id = $doctorId;
        $appointment->appointment_date = $request->appointment_date;
        $appointment->status = 'pending';
        $appointment->save();

        $doctor = $appointment->doctor;
        $doctor->notify(new AppointmentCreatedNotification($appointment));

        return back()->with('success', 'Your appointment has been successfully booked. Please wait for doctor approval.');
    }



    public function showAppointments()
    {
        $user = auth()->user();
        $patient = Patient::where('user_id', $user->id)->first();
        $appointments = Appointment::where('patient_id', $patient->id)->get();
        return view('patient.showAppointments', compact('appointments'));
    }



    public function viewDocument($fileName)
    {
        $filePath = storage_path('app/public/documents/' . $fileName);

        if (file_exists($filePath)) {
            return response()->file($filePath);
        } else {
            return abort(404, "File not found");
        }


    }







}
