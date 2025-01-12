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

    <div class="container py-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Patient Details</h2>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $doctor->first_name }} {{ $doctor->last_name }}</p>
                <p><strong>Email:</strong> {{ $doctor->email }}</p>
                <p><strong>Phone:</strong> {{ $doctor->phone_number }}</p>
                <p><strong>Specialization:</strong> {{ $doctor->specialization }}</p>
                <p><strong>License_number:</strong> {{ $doctor->license_number }}</p>
                <p><strong>Experience_years:</strong> {{ $doctor->experience_years }}</p>
            </div>
        </div>
    </div>
@endsection
