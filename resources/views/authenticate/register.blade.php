@extends('master')
@section('header')

@endsection
@section('title', 'Kayıt Ol - Laravel'.config('app.title'))

@section('content')

    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>kayıt ol</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Anasayfa</a></li>
                            <li class="breadcrumb-item active" aria-current="page">hesap oluştur</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->


    <!--section start-->
    <section class="register-page section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3>kayıt ol</h3>
                    <div class="theme-card">
                        @if (session()->has('message'))
                            <div class="alert alert-{{ session('messageType') }}" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif
                        <form class="theme-form" method="POST" action="/register/create">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="email">Ad</label>
                                    <input type="text" name="register_firstname" class="form-control" id="fname" placeholder=""
                                        required="">
                                </div>
                                <div class="col-md-6">
                                    <label for="review">Soyad</label>
                                    <input type="text" name="register_lastname" class="form-control" id="lname" placeholder=""
                                        required="">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="email">E-Posta</label>
                                    <input type="text" class="form-control" name="register_email" id="email" placeholder="" required="">
                                </div>
                                <div class="col-md-6">
                                    <label for="review">Password</label>
                                    <input type="password" name="register_password" class="form-control" id="review"
                                        placeholder="" required="">
                                </div><button type="submit" href="#" class="btn btn-solid">Kayıt Ol</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Section ends-->


@endsection

@section('footer')

@endsection
