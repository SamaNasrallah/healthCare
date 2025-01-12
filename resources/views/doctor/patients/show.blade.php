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
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Patient Details</h2>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('doctor.notificationsRequest', $patient->id) }}" class="btn btn-primary">Send Request update its profile</a>
                </div>


                <p><strong>Name:</strong> {{ $patient->first_name }} {{ $patient->last_name }}</p>
                <p><strong>Email:</strong> {{ $patient->email }}</p>
                <p><strong>Phone:</strong> {{ $patient->phone_number }}</p>
                <p><strong>Address:</strong> {{ $patient->address }}</p>
                <p><strong>Date of Birth:</strong> {{ $patient->dob }}</p>
                <p><strong>Gender:</strong> {{ ucfirst($patient->gender) }}</p>
                <p><strong>Medical Records:</strong>
                @foreach($medicalRecords as $record)
                    <p>File Name: {{ $record->file_name }}
                    <a href="{{ route('patient.viewDocument', ['fileName' => $record->file_name]) }}" class="btn btn-sm btn-info" target="_blank">View</a>
                    </p>
                @endforeach
                </p>
            </div>
        </div>
    </div>
@endsection
