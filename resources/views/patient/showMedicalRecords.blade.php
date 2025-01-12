@extends('patient.app')

@section('mainContent')
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
    <div class="container mt-5">

        <div class="card">
            <div class="card-header">
                <h3>Medical Records</h3>
            </div>
            <div class="card-body">
                @if(empty($medicalRecords))
                    <p class="text-center">No medical records available.</p>
                @else
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>File Name</th>
                            <th>Uploaded At</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($medicalRecords as $record)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $record->file_name }}</td>
                                <td>{{ $record->created_at->format('d M, Y') }}</td>
                                <td>
                                    <a href="{{ route('patient.viewDocument', ['fileName' => $record->file_name]) }}" class="btn btn-sm btn-info" target="_blank">View</a>
                                    <form action="{{ route('patient.deleteDocument', ['id' => $record->id]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this document?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
