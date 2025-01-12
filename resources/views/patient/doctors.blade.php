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
    <div class="container">
        <h1>Doctors</h1>

        <!-- فلتر التخصصات -->
        <form method="GET" action="{{ route('patient.doctors') }}">
            <div class="form-group">
                <label for="specialization">Select Specialization:</label>
                <select name="specialization" id="specialization" class="form-control">
                    <option value="">All Specializations</option>
                    <option value="cardiology" {{ request('specialization') == 'cardiology' ? 'selected' : '' }}>Cardiology</option>
                    <option value="orthopedics" {{ request('specialization') == 'orthopedics' ? 'selected' : '' }}>Orthopedics</option>
                    <option value="pediatrics" {{ request('specialization') == 'pediatrics' ? 'selected' : '' }}>Pediatrics</option>
                    <option value="neurology" {{ request('specialization') == 'neurology' ? 'selected' : '' }}>Neurology</option>
                    <!-- أضف المزيد من التخصصات هنا حسب الحاجة -->
                </select>
            </div>
            <button type="submit" class="btn btn-secondary">Filter</button>
        </form>

        <!-- جدول الأطباء -->
        <table class="table table-bordered mt-4">
            <thead>
            <tr>
                <th>Name</th>
                <th>Specialization</th>
                <th>Email</th>
                <th>Experience</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($doctors as $doctor)
                <tr>
                    <td>{{ $doctor->first_name }} {{ $doctor->last_name }}</td>
                    <td>{{ $doctor->specialization }}</td>
                    <td>{{ $doctor->email }}</td>
                    <td>{{ $doctor->experience_years }} years</td>
                    <td>
                        <!-- زر لحجز موعد -->
                        <a href="{{ route('patient.bookAppointment', $doctor->id) }}" class="btn btn-primary">Book Appointment</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
