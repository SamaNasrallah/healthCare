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
    <div class="container py-4">
        <h1>Diagnoses & Prescriptions</h1>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Patient</th>
                <th>Diagnosis</th>
                <th>Prescription</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($diagnoses as $diagnosis)
                <tr>
                    <td>{{ $diagnosis->patient->first_name }} {{ $diagnosis->patient->last_name }}</td>
                    <td>{{ Str::limit($diagnosis->diagnosis, 50) }}</td>
                    <td>{{ Str::limit($diagnosis->prescription, 50) }}</td>
                    <td>
                        <a href="{{ route('doctor.diagnosis.show', $diagnosis->id) }}" class="btn btn-primary btn-sm">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No diagnoses found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{ $diagnoses->links() }}
    </div>
@endsection
