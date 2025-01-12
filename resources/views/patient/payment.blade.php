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
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h3 class="card-title text-primary">Make a Payment</h3>
                        <p class="card-text text-muted">
                            Pay your medical fees securely using PayPal or Stripe.
                        </p>
                        <p class="card-text">
                            <strong>Amount: </strong> ${{ $amount }} <!-- تأكد من إرسال قيمة الدفع من الـ Controller -->
                        </p>

                        <form action="{{ route('payment.paypal') }}" method="POST" class="d-inline-block">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-block mb-2">Pay with PayPal</button>
                        </form>

{{--                        <form action="{{ route('payment.stripe') }}" method="POST" class="d-inline-block">--}}
{{--                            @csrf--}}
{{--                            <button type="submit" class="btn btn-info btn-block">Pay with Stripe</button>--}}
{{--                        </form>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
