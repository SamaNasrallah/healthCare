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
    <div class="container my-5">
        <h1 class="text-center mb-4">Doctors Management</h1>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Add Doctor Button -->
        <div class="text-right mb-4">
            <a href="{{ route('admin.doctors.create') }}" class="btn btn-success">
                <i class="fas fa-plus-circle"></i> Create New Doctor Account
            </a>
        </div>

        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Specialization</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">License Number</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php $i=0; ?>
            @foreach($doctors as $doctor)
                    <?php $i++;?>
                <tr>
                    <th scope="row">{{$i}}</th>
                    <td>{{ $doctor->first_name }} {{ $doctor->last_name }}</td>
                    <td>{{ $doctor->specialization }}</td>
                    <td>{{ $doctor->email }}</td>
                    <td>{{ $doctor->phone_number ?? 'N/A' }}</td>
                    <td>{{ $doctor->license_number }}</td>
                    <td>
                        @if($doctor->user->is_active)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-danger">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <!-- Show "Activate" button only if the doctor is inactive -->
                        @if(!$doctor->user->is_active)
                            <form action="{{ route('admin.doctors.toggleStatus', $doctor) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-success"
                                        onclick="return confirm('Are you sure you want to activate this account?')">
                                    <i class="fas fa-toggle-on"></i> Activate
                                </button>
                            </form>
                        @endif

                        <!-- Edit button -->
                        <a href="{{ route('admin.doctors.edit', $doctor) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <!-- Delete button -->
                        <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
