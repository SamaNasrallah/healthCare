@extends('doctor.app')

@section('mainContent')
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
        <ul class="navbar-nav ml-auto">
            <!-- User Info Dropdown -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    {{ \Illuminate\Support\Facades\Auth::user()->first_name }} {{ \Illuminate\Support\Facades\Auth::user()->last_name }}
                    <br>
                    <small class="text-muted">{{ \Illuminate\Support\Facades\Auth::user()->doctor->specialization }}</small> <!-- التخصص -->
                </span>
                    <img class="img-profile rounded-circle" src="{{ asset('img/undraw_profile.svg') }}">
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="{{route('doctor.profile')}}">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
                    </a>
                </div>
            </li>
        </ul>
    </nav>

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <h2>Appointments</h2>
        <style>
            .status-label {
                padding: 5px 10px;
                border-radius: 5px;
                font-weight: bold;
                color: #fff;
                text-transform: capitalize;
            }

            /* الحالات المختلفة */
            .pending {
                background-color: #ffc107;
            }

            .confirmed {
                background-color: #4dd0fa;
            }

            .cancelled {
                background-color: #dc3545;
            }
            .completed{
                background-color: #3ec055;
            }
        </style>
        <!-- عرض المواعيد في جدول -->
        <table class="table">
            <thead>
            <tr>
                <th>Patient</th>
                <th>Appointment Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</td>
                    <td>{{ $appointment->appointment_date }}</td>

                    <!-- عرض حالة الموعد -->
                    <td>
                        @if($appointment->status == 'pending')
                            <span class="status-label pending">Pending</span>
                        @elseif($appointment->status == 'confirmed')
                            <span class="status-label confirmed">Confirmed</span>
                        @elseif($appointment->status == 'cancelled')
                            <span class="status-label cancelled">Cancelled</span>
                        @elseif($appointment->status == 'completed')
                            <span class="status-label completed">Completed</span>
                        @endif
                    </td>

                    <!-- عرض الأزرار بناءً على حالة الموعد -->
                    <td>
                        @if($appointment->status == 'pending')
                            <a href="{{ route('doctor.appointments.confirm', $appointment->id) }}" class="btn btn-success">Confirm</a>
                            <a href="{{ route('doctor.appointments.cancel', $appointment->id) }}" class="btn btn-danger">Cancel</a>
                        @elseif($appointment->status == 'confirmed')
                            <a href="{{ route('doctor.patients.show', $appointment->patient_id) }}" class="btn btn-info">View Patient Profile</a>
                            <a href="{{ route('doctor.diagnoses.create', $appointment->patient_id) }}" class="btn btn-primary">Create Diagnosis & Prescription</a>
                        @elseif($appointment->status == 'cancelled')
                            <span class="text-muted">Cancelled</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
