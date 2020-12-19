@extends('master')
@section('header')

@endsection
@section('title', 'Şifremi Unuttum - Laravel'.config('app.title'))

@section('content')
    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>Şifremi Unuttum</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Anasayfa</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('authenticate.login') }}">GİRİŞ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">ŞİFREMİ unuttum</li>
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
                    <h2>ŞİFREMİ Unuttum</h2>
                    @if (session()->has('message'))
                        <div class="alert alert-{{ session('messageType') }}" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif
                    <form class="theme-form" action="/customer/forgetpassword/send" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-12">
                                <input type="text" autocomplete="off" autofocus name="forgot_email" class="form-control" id="email" placeholder="E-Posta adresinizi girin."
                                    required="">
                            </div><button type="submit" href="#" class="btn btn-solid">Gönder</button>
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
