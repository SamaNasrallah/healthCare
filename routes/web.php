<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PatientProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkingHourController;
use App\Models\MedicalAdviceAd;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';
Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/doctor/dashboard', [DoctorController::class, 'index'])->name('doctor.dashboard');
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/patient/dashboard', [PatientController::class, 'index'])->name('patient.dashboard');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'doctor') {
        return redirect()->route('doctor.dashboard');
    } elseif ($user->role === 'patient') {
        return redirect()->route('patient.dashboard');
    } elseif ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return abort(403, 'Unauthorized action.');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/patient/upload-documents/register', [PatientController::class, 'showUploadFormRegister'])->name('patient.uploadDocumentsRegister');
Route::post('/patient/upload-documents/register', [PatientController::class, 'uploadDocumentsRegister'])->name('patient.uploadDocumentsRegister.submit');

Route::middleware(['auth'])->group(function () {
    Route::get('/patient/upload-documents', [PatientController::class, 'showUploadForm'])->name('patient.uploadDocuments');
    Route::post('/patient/upload-documents', [PatientController::class, 'uploadDocuments'])->name('patient.uploadDocuments.submit');
    Route::get('/patient/showMedicalRecords', [PatientController::class, 'showMedicalRecords'])->name('patient.showMedicalRecords');
    Route::delete('/patient/document/{id}', [PatientController::class, 'deleteDocument'])->name('patient.deleteDocument');

    Route::get('/patient/book-appointment/{doctorId}', [PatientController::class, 'bookAppointment'])->name('patient.bookAppointment');
    Route::post('/patient/book-appointment/{doctorId}', [PatientController::class, 'storeAppointment'])->name('patient.storeAppointment');
    Route::get('/patient/doctors', [PatientController::class, 'showDoctors'])->name('patient.doctors');
    Route::get('/appointments', [PatientController::class, 'showAppointments'])->name('patient.showAppointments');
    Route::get('/patient/profile', [PatientProfileController::class, 'index'])->name('patient.profile');
    Route::post('/patient/profile/update', [PatientProfileController::class, 'update'])->name('patient.profile.update');

    Route::get('patient/notification',[PatientController::class,'notification'])->name('patient.notifications');
    Route::get('/patient/notifications/{notification}', [PatientController::class, 'markAsRead'])->name('patient.notifications.read');
    Route::get('/patient/invoices', [PatientController::class, 'showInvoice'])->name('patient.invoice.show');

});

Route::get('/patient/view-document/{fileName}', [PatientController::class, 'viewDocument'])->name('patient.viewDocument');



Route::middleware('auth')->group(function () {
    Route::get('/doctor/appointments', [AppointmentController::class, 'index'])->name('doctor.appointments.index');
    Route::get('/doctor/appointments/{id}/confirm', [AppointmentController::class, 'confirm'])->name('doctor.appointments.confirm');
    Route::get('/doctor/appointments/{id}/cancel', [AppointmentController::class, 'cancel'])->name('doctor.appointments.cancel');
   
    Route::get('/doctor/patients', [DoctorController::class, 'patient'])->name('doctor.patients.index');
    Route::get('/doctor/patients/{id}', [DoctorController::class, 'show'])->name('doctor.patients.show');
    Route::get('/doctor/diagnoses/create/{patient_id}', [DiagnosisController::class, 'create'])->name('doctor.diagnoses.create');
    Route::get('/doctor/diagnosis', [DiagnosisController::class, 'index'])->name('doctor.diagnosis.index'); // عرض قائمة التشخيصات
    Route::post('/doctor/diagnosis/store', [DiagnosisController::class, 'store'])->name('doctor.diagnosis.store'); // حفظ تشخيص جديد
    Route::get('/doctor/diagnosis/{id}', [DiagnosisController::class, 'show'])->name('doctor.diagnosis.show');

    Route::get('doctor/notification',[DoctorController::class,'notification'])->name('doctor.notifications');
    Route::get('/doctor/notifications/{notification}', [DoctorController::class, 'markAsRead'])->name('doctor.notifications.read');
    Route::get('doctor/notificationsRequest/{id}',[DoctorController::class,'requestProfileUpdate'])->name('doctor.notificationsRequest');
    Route::get('doctor/profile',[DoctorController::class,'profile'])->name('doctor.profile');


});


Route::middleware(['auth'])->group(function () {
    Route::get('/backup', [BackupController::class, 'index'])->name('admin.backup.index');
    Route::post('/backup/patient-data', [BackupController::class, 'backupPatientData'])->name('admin.backup.patientData');
    Route::post('/backup/patient-data-enc', [BackupController::class, 'backupPatientDataEncryption'])->name('admin.backup.patientDataEncrypt');

    Route::get('invoices', [InvoiceController::class, 'index'])->name('admin.invoices.index');
    Route::put('invoices/{id}/toggle-status', [InvoiceController::class, 'toggleStatus'])->name('admin.invoices.toggleStatus');
    Route::delete('invoices/{invoice}', [InvoiceController::class, 'destroy'])->name('admin.invoices.destroy');
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/notifications', [InvoiceController::class, 'showNotifications'])->name('notifications.index');
    Route::get('/notifications/read/{id}', [InvoiceController::class, 'markAsRead'])->name('notifications.read');


    Route::get('/patients', [AdminController::class, 'indexAdminPatient'])->name('admin.patients.index');
    Route::get('/patients/{patient}/edit', [AdminController::class, 'editPatient'])->name('admin.patients.edit');
    Route::put('/patients/{patient}', [AdminController::class, 'updatePatient'])->name('admin.patients.update');
    Route::delete('/patients/{patient}', [AdminController::class, 'destroyPatient'])->name('admin.patients.destroy');
    Route::get('admin/patients/create', [AdminController::class, 'createPatient'])->name('admin.patients.create');
    Route::post('admin/patients', [AdminController::class, 'storePatient'])->name('admin.patients.store');
    Route::put('/admin/patients/{patientId}/toggle-status', [AdminController::class, 'toggleStatusPatient'])->name('admin.patients.toggleStatus');

    Route::get('/doctors', [AdminController::class, 'indexAdminDoctor'])->name('admin.doctors.index');
    Route::get('/doctors/{doctor}/edit', [AdminController::class, 'editDoctor'])->name('admin.doctors.edit');
    Route::put('/doctors/{doctor}', [AdminController::class, 'updateDoctor'])->name('admin.doctors.update');
    Route::delete('/doctors/{doctor}', [AdminController::class, 'destroyDoctor'])->name('admin.doctors.destroy');
    Route::get('admin/doctors/create', [AdminController::class, 'createDoctor'])->name('admin.doctors.create');
    Route::post('admin/doctors', [AdminController::class, 'storeDoctor'])->name('admin.doctors.store');
    Route::put('/admin/doctors/{doctorId}/toggle-status', [AdminController::class, 'toggleStatusDoctor'])->name('admin.doctors.toggleStatus');

    Route::get('admin/inactive-users', [UserController::class, 'showInactiveAccounts'])->name('admin.inactive-users');
    Route::delete('admin/users/{user}', [UserController::class, 'destroyInactiveAccount'])->name('admin.users.destroy');

    Route::get('admin/notification',[AdminController::class,'notification'])->name('admin.notifications');
    Route::get('/admin/notifications/{notification}', [AdminController::class, 'markAsRead'])->name('admin.notifications.read');
});


































//Route::get('patients', [PatientController::class, 'index']);
//Route::post('patients', [PatientController::class, 'store']);
//
//Route::get('doctors', [DoctorController::class, 'index']);
//Route::post('doctors', [DoctorController::class, 'store']);
//
//Route::get('appointments', [AppointmentController::class, 'index']);
//Route::post('appointments', [AppointmentController::class, 'store']);
//
//Route::get('notifications', [NotificationController::class, 'index']);
//Route::post('notifications', [NotificationController::class, 'store']);
//
//Route::get('invoices', [InvoiceController::class, 'index']);
//Route::post('invoices', [InvoiceController::class, 'store']);
//
//Route::get('analytics', [AnalyticsController::class, 'index']);
//Route::post('analytics', [AnalyticsController::class, 'store']);
//
//Route::get('medical-records', [MedicalRecordsController::class, 'index']);
//Route::post('medical-records', [MedicalRecordsController::class, 'store']);


