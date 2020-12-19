@extends('master')

@section('title', '404 - Aradığınız Sayfa Bulunamadı'.config('app.title'))

@section('content')
    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>404</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">anasayfa</a></li>
                            <li class="breadcrumb-item active" aria-current="page">404</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->


    <!-- section start -->
    <section class="p-0">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="error-section">
                        <h1>404</h1>
                        <h2>sayfa bulunamadı</h2>
                        <a href="{{ url()->previous() }}" class="btn btn-solid">geri</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section ends -->

@endsection
