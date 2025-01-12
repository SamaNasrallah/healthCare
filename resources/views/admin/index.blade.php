@extends('admin.app')

@section('mainContent')
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
        <ul class="navbar-nav ml-auto">
            <!-- Notifications Dropdown -->
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="notificationsDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell fa-fw"></i>
                    <!-- دائرة ملونة تشير إلى وجود إشعارات جديدة -->
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
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.notifications') }}">
                            <div class="mr-3">
                                <div class="icon-circle {{ $notification->read_at ? 'bg-secondary' : 'bg-primary' }}">
                                    <i class="fas fa-file-alt text-white"></i>
                                </div>
                            </div>
                            <div>
                                <span class="{{ $notification->read_at ? '' : 'font-weight-bold' }}">{{ $notification->data['message'] }}</span>
                            </div>
                            @if(is_null($notification->read_at))
                                <form method="GET" action="{{ route('admin.notifications.read', $notification->id) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-link text-primary">Make as read</button>
                                </form>
                            @endif
                        </a>
                    @endforeach
                    <a class="dropdown-item text-center small text-gray-500" href="{{ route('admin.notifications') }}">Show All Notifications</a>
                </div>
            </li>


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
    <div class="container-fluid">
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Welcome to the Admin Dashboard</h1>

        <!-- Content Row -->
        <div class="row">

            <!-- Total Patients Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Patients</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalPatients}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Invoices Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Invoices</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalInvoices}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-credit-card fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Appointments Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Doctors</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalDoctors}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Notifications Summary Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Unread Notifications</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $unreadNotifications }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-bell fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <!-- Content Row (Recent Activity) -->
            <div class="row">
                <!-- Recent Activities Card -->
                <div class="col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Recent Activities</h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <!-- Notifications -->
                                @foreach($notifications as $notification)
                                    <li class="list-group-item">
                                        <strong>Notification:</strong> {{ $notification->data['message'] }}
                                        <span class="text-muted">({{ $notification->created_at->format('d-m-Y H:i') }})</span>
                                    </li>
                                @endforeach

                                <!-- Recent Patients -->
                                @foreach($recentPatients as $patient)
                                    <li class="list-group-item">
                                        <strong>New Patient:</strong> {{ $patient->first_name }} {{ $patient->last_name }}
                                        <span class="text-muted">({{ $patient->created_at->format('d-m-Y') }})</span>
                                    </li>
                                @endforeach

                                <!-- Recent Invoices -->
                                @foreach($recentInvoices as $invoice)
                                    <li class="list-group-item">
                                        <strong>Invoice:</strong> Invoice #{{ $invoice->id }} - ${{ $invoice->total }}
                                        <span class="text-muted">({{ $invoice->created_at->format('d-m-Y') }})</span>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
            </div>


    </div>
@endsection
