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

    <div class="container mt-4">
        <h2>Notifications</h2>
        @foreach ($notifications as $notification)
            <div class="notification mb-4 p-4 border rounded shadow-sm bg-light">
                <div class="d-flex justify-content-between">
                    <!-- محتويات الإشعار على اليسار -->
                    <div>
                        <p class="font-weight-bold">{{ $notification->data['message'] }}</p>
                        <a href="{{ $notification->data['url'] }}" class="btn btn-info btn-sm mb-2">View Appointment</a>
                        <small class="text-muted d-block mb-2">Created at: {{ $notification->created_at->format('Y-m-d H:i:s') }}</small>
                    </div>

                    <!-- حالة الإشعار وزر "Mark as Read" على اليمين -->
                    <div class="text-right">
                        @if ($notification->read_at)
                            <span class="badge badge-success mr-2">Read</span> <!-- إشعار مقروء -->
                        @else
                            <span class="badge badge-warning mr-2">Unread</span> <!-- إشعار غير مقروء -->
                        @endif

                        <!-- زر "Mark as Read" في نفس السطر -->
                        @if (is_null($notification->read_at))
                            <a href="{{ route('doctor.notifications.read', $notification->id) }}" class="btn btn-primary btn-sm">Mark as Read</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
