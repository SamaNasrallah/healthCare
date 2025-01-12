<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use MongoClient;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:3',
            'role' => 'required|in:doctor,patient,admin',
        ]);
    
        // إنشاء المستخدم
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
    
        // إضافة معلومات إضافية بناءً على الدور
        if ($request->role == 'doctor') {
            Doctor::create([
                'user_id' => $user->id,
                'specialization' => $request->specialization,
                'license_number' => $request->license_number,
                'phone_number' => $request->doctor_phone_number,
                'experience_years' => $request->experience_years,
            ]);
        } elseif ($request->role == 'patient') {
            Patient::create([
                'user_id' => $user->id,
                'address' => $request->address,
                'dob' => $request->dob,
                'phone_number' => $request->patient_phone_number,
                'gender' => $request->gender,
            ]);
        }
    
        Auth::login($user);
    
        // توجيه بناءً على الدور
        if ($user->role == 'doctor') {
            return redirect()->route('doctor.dashboard');
        } elseif ($user->role == 'patient') {
            return redirect()->route('patient.dashboard');
        } elseif ($user->role == 'admin') {
            return redirect()->route('admin.dashboard');
        }
    
        return redirect('/'); // توجيه افتراضي في حال وجود دور غير معروف
    }
    


}
