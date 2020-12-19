@extends('master')
@section('header')

@endsection
@section('title', 'Reset Password - Laravel'.config('app.title'))

@section('content')
    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>reset password</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('authenticate.login') }}">login</a></li>
                            <li class="breadcrumb-item active" aria-current="page">reset password</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->


    <!--section start-->
    <section class="pwd-page section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <h2>Reset Your Password</h2>
                    @if (session()->has('message'))
                        <div class="alert alert-{{ session('messageType') }}" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif
                    <form class="theme-form" action="/customer/resetpassword/reset" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-6">
                                <input type="hidden" name = "token" value="{{ $customer->token }}">
                                <input type="password" autocomplete="off" autofocus name="reset_pwd" class="form-control" id="email" placeholder="Enter New Password"
                                    required="">
                            </div>
                            <div class="col-md-6">
                                <input type="password" autocomplete="off" name="reset_pwd_repeat" class="form-control" id="email" placeholder="Enter New Password Repeat"
                                    required="">
                            </div>
                            <button type="submit" href="#" class="btn btn-solid">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!--Section ends-->
@endsection

@section('footer')

@endsection
