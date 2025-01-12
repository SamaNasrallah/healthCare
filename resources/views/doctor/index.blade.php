@extends('doctor.app')
@section('mainContent')
    <style>
        /* تصميم النافذة المنبثقة */
        .popup {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #f8d7da;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 9999;
        }

        .popup-content {
            display: flex;
            flex-direction: column;
        }

        .popup h3 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .popup p {
            margin: 5px 0;
        }

        .popup-close {
            align-self: flex-start;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            color: #3a0101;
        }

        .popup-close:hover {
            color: #c9302c;
        }
    </style>
    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
        <ul class="navbar-nav ml-auto">
            <!-- Notifications Dropdown -->
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="notificationsDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell fa-fw"></i>
                    @if($unreadNotifications > 0)
                        <span class="badge badge-danger badge-counter">{{ $unreadNotifications }}</span>
                    @endif
                </a>
                <!-- Dropdown - Notifications -->
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="notificationsDropdown">
                    <h6 class="dropdown-header">
                        Notifications Center
                    </h6>
                    @foreach($notifications as $notification)
                        <a class="dropdown-item d-flex align-items-center" href="{{$notification->data['url']}}">
                            <div class="mr-3">
                                <div class="icon-circle {{ $notification->read_at ? 'bg-secondary' : 'bg-primary' }}">
                                    <i class="fas fa-file-alt text-white"></i>
                                </div>
                            </div>
                            <div>
                                <span class="{{ $notification->read_at ? '' : 'font-weight-bold' }}">{{ $notification->data['message'] }}</span>
                            </div>
                            @if(is_null($notification->read_at))
                                <form method="GET" action="{{ route('doctor.notifications.read', $notification->id) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-link text-primary">Make as read</button>
                                </form>
                            @endif
                        </a>
                    @endforeach
                    <a class="dropdown-item text-center small text-gray-500" href="{{ route('doctor.notifications') }}">Show All Notifications</a>
                </div>
            </li>

            <!-- User Info Dropdown -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                        {{ \Illuminate\Support\Facades\Auth::user()->first_name }} {{ \Illuminate\Support\Facades\Auth::user()->last_name }}
                        <br>
                        <small class="text-muted">{{ \Illuminate\Support\Facades\Auth::user()->doctor->specialization }}</small>
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

    <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-xl-12 col-md-12 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <h1 class="h3 mb-4 text-gray-800">Welcome, Doctor {{ \Illuminate\Support\Facades\Auth::user()->first_name }}!</h1>
                        <p class="lead">You are logged in as a doctor. Here are some important statistics for you:</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Doctor's Statistics Section -->
        <div class="row">
            <!-- Total Patients -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title">Total Patients</h5>
                        <p class="card-text">{{ $totalPatients }} patients</p>
                    </div>
                </div>
            </div>

            <!-- Upcoming Appointments -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title">Upcoming Appointments</h5>
                        <p class="card-text">{{ $upcomingAppointments }} appointments</p>
                    </div>
                </div>
            </div>

                <!-- Followed Patients -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card shadow h-100 py-2">
                        <div class="card-body">
                            <h5 class="card-title">Followed Patients</h5>
                            <p class="card-text">{{ $followedPatients }} patients</p>
                        </div>
                    </div>
                </div>

        </div>

        <!-- New Statistics Section -->





        <!-- Row for Doctor's Actions -->
        <div class="row">
            <!-- Appointments Button -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title">Manage Appointments</h5>
                        <p class="card-text">View and manage patient appointments.</p>
                        <a href="{{ route('doctor.appointments.index') }}" class="btn btn-success">Manage Appointments</a>
                    </div>
                </div>
            </div>

            <!-- Prescriptions Button -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title">View Prescriptions & Diagnosis</h5>
                        <p class="card-text">View patient prescriptions and diagnoses.</p>
                        <a href="{{ route('doctor.diagnosis.index') }}" class="btn btn-info">View Prescriptions</a>
                    </div>
                </div>
            </div>

            <!-- Patients List Button -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title">View Patients</h5>
                        <p class="card-text">View a list of your patients and their details.</p>
                        <a href="{{ route('doctor.patients.index') }}" class="btn btn-primary">View Patients</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- نافذة منبثقة للإعلان (في الجانب الأيمن السفلي) -->
        <div id="popup" class="popup" style="display:none;">
            <div class="popup-content">
                <span class="close-btn" onclick="closePopup()">×</span>
                <h4 id="popup-title"></h4>
                <p id="popup-content"></p>
            </div>
        </div>

    </div>

    <script>
        // إرسال الإعلان إلى JavaScript من خلال Blade
        var advertisement = @json($advertisement);
    </script>

    <!-- HTML لجعل الـ popup يظهر -->
    <script>
        window.onload = function() {
            setInterval(function() {
                if (advertisement) {
                    var title = advertisement.title;
                    var content = advertisement.content;
                    showPopup(title, content);
                }
            }, 5000); // عرض الإعلان كل 5 ثوانٍ (يمكنك تغيير هذه الفترة)
        };

        function showPopup(title, content) {
            const popup = document.createElement('div');
            popup.classList.add('popup');
            popup.innerHTML = `
            <div class="popup-content">
                <h3>${title}</h3>
                <p>${content}</p>
                <span class="popup-close" onclick="closePopup(this)">x</span>
            </div>
        `;
            document.body.appendChild(popup);
        }

        function closePopup(button) {
            const popup = button.closest('.popup');
            popup.remove();
        }
    </script>
@endsection
