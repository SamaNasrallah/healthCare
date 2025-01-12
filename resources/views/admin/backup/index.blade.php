@extends('admin.app')

@section('mainContent')

    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
        <ul class="navbar-nav ml-auto">
            <!-- User Info Dropdown -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{\Illuminate\Support\Facades\Auth::user()->first_name}} {{\Illuminate\Support\Facades\Auth::user()->last_name}}</span>
                    <img class="img-profile rounded-circle"
                         src="{{asset('img/undraw_profile.svg')}}">
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                     aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="{{route('logout')}}" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </div>
            </li>
        </ul>
    </nav>
    <div class="container my-4">
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <h1>Backup Options</h1>

        <p>Choose the type of backup you want to create:</p>

        <!-- Form to backup patient data -->
        <form action="{{ route('admin.backup.patientData') }}" method="POST" class="mb-4">
            @csrf
            <button type="submit" class="btn btn-warning">Backup Patient Data</button>
        </form>
            <!-- Form to backup patient data -->
            <form action="{{ route('admin.backup.patientDataEncrypt') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-info">Backup Patient Data (Encrypted)</button>
            </form>
    </div>
@endsection
