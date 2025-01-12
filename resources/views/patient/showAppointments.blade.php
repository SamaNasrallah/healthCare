@extends('patient.app')

@section('mainContent')
    <style>
        .status-label {
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            color: #fff;
            text-transform: capitalize;
        }

        /* الحالات المختلفة */
        .status-label.pending {
            background-color: #ffc107; /* لون أصفر */
        }

        .status-label.confirmed {
            background-color: #4dd0fa;
        }
        .status-label.cancelled {
            background-color: #dc3545; /* لون أحمر */
        }
        .status-label.completed {
            background-color: #3ec055;
        }


    </style>
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{\Illuminate\Support\Facades\Auth::user()->first_name}} {{\Illuminate\Support\Facades\Auth::user()->last_name}}</span>
                    <img class="img-profile rounded-circle"
                         src="{{asset('img/undraw_profile.svg')}}">
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                     aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="{{ route('patient.profile') }}">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{route('logout')}}" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </div>
            </li>
        </ul>
    </nav>
<div class="container">

    <h1>Your Appointments</h1>
    <table class="table">
        <thead>
        <tr>
            <th>Doctor</th>
            <th>Specialization</th>
            <th>Appointment Time</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach($appointments as $appointment)
            <tr>
                <td>{{ $appointment->doctor->first_name }} {{ $appointment->doctor->last_name }}</td>
                <td>{{ $appointment->doctor->specialization }}</td>
                <td>{{ $appointment->appointment_date }}</td>
                <td>
                    <span class="status-label {{ strtolower($appointment->status) }}">
                    {{ ucfirst($appointment->status) }}
                    </span>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
