@extends('master')
@section('header')

@endsection
@section('title', 'Giriş - '.config('app.title'))

@section('content')

    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>müşteri giriş</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Anasayfa</a></li>
                            <li class="breadcrumb-item active">giriş</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->


    <!--section start-->
    <section class="login-page section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h3>Giriş</h3>
                    @if (session()->has('message'))
                        <div class="alert alert-{{ session('messageType') }}" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif
                    <div class="theme-card">
                        <form class="theme-form" action="/login/customer" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="email">E-Posta</label>
                                <input type="text" name="login_email" class="form-control" id="email" placeholder="" required="">
                            </div>
                            <div class="form-group">
                                <label for="review">Şifre</label>
                                <input type="password" name="login_password" class="form-control" id="review"
                                    placeholder="" required="">
                            </div>
                            <button href="#" class="btn btn-solid">Giriş</button>
                            <a style="margin-left: 30px; color: #242424;" href="{{ route('customer.forgetpassword') }}">Şifremi Unuttum</a>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 right-login">
                    <h3>Yeni Müşteri</h3>
                    <div class="theme-card authentication-right">
                        <h6 class="title-font">Hesap Oluştur</h6>
                        <p>Mağazamızda ücretsiz hesabınızı oluşturun. Kayıt işlemi hızlı ve kolaydır. Alışverişe başlamak için lütfen kayıt olun.</p><a href="{{ route('authenticate.register') }}"
                            class="btn btn-solid">Hesap Oluştur</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Section ends-->

@endsection

@section('footer')

@endsection
