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
        <h1 class="text-center mb-4">Invoices Management</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Patient Name</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Issued At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->id }}</td>
                    <td>{{ $invoice->patient->first_name }} {{ $invoice->patient->last_name }}</td>
                    <td>${{ $invoice->amount }}</td>
                    <td>
                        <span class="badge badge-{{ $invoice->status === 'paid' ? 'success' : 'warning' }}">
                            {{ $invoice->status }}
                        </span>
                    </td>
                    <td>{{ $invoice->issued_at ? $invoice->issued_at : 'N/A' }}</td>
                    <td>
                        <!-- Toggle Status -->
                        @if($invoice->status === 'paid')

                        @else
                            <form action="{{ route('admin.invoices.toggleStatus', $invoice->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="fas fa-toggle-on"></i> Mark Paid
                                </button>
                            </form>
                        @endif


                        <!-- Delete -->
                        <form action="{{ route('admin.invoices.destroy', $invoice) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
