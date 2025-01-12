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
        <h1 class="mb-4">Patients</h1>

        <form method="GET" action="{{ route('doctor.patients.index') }}" class="d-flex mb-4">
            <input type="text" class="form-control me-2" name="search" placeholder="Search patients..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <!-- عرض المرضى الجدد -->
        <h3 class="mb-3">Recent Patients</h3>
        @if($recentPatients->isEmpty())
            <p>No recent patients found.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($recentPatients as $patient)
                        <tr>
                            <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                            <td>{{ $patient->email }}</td>
                            <td>{{ $patient->phone_number }}</td>
                            <td>
                                <a href="{{ route('doctor.patients.show', $patient->id) }}" class="btn btn-success btn-sm">View</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $recentPatients->links() }}
        @endif

        <!-- عرض المرضى القدامى -->
        <h3 class="mb-3">Follow up Patients</h3>
        @if($oldPatients->isEmpty())
            <p>No Follow up  patients found.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($oldPatients as $patient)
                        <tr>
                            <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                            <td>{{ $patient->email }}</td>
                            <td>{{ $patient->phone_number }}</td>
                            <td>
                                <a href="{{ route('doctor.patients.show', $patient->id) }}" class="btn btn-success btn-sm">View</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $oldPatients->links() }}
        @endif
    </div>
@endsection
