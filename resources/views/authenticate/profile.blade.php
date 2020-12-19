@extends('master')
@section('title', 'Profil'.config('app.title'))

@section('content')
    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>profile</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Anasayfa</a></li>
                            <li class="breadcrumb-item active" aria-current="page">profil</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->


    <!-- personal deatail section start -->
    <section class="contact-page register-page">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h3>Kişisel Bilgiler</h3>
                    <form class="theme-form">
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="name">İsim</label>
                                <input type="text" class="form-control" id="name" placeholder="İsminizi Girin"
                                    required="" value="{{ Auth::user()->name }}">
                            </div>
                            <div class="col-md-6">
                                <label for="review">Telefon Numarası</label>
                                <input type="text" class="form-control" id="review" placeholder="Telefon Numaranızı Girin"
                                    required="">
                            </div>
                            <div class="col-md-6">
                                <label for="email">E-Posta</label>
                                <input type="text" class="form-control" id="email" placeholder="E-Postanızı Girin" value="{{ Auth::user()->email }}" required="">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Section ends -->


    <!-- address section start -->
    <section class="contact-page register-page section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h3>Kargo Adresi</h3>
                    <form class="theme-form">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="name">flat / plot</label>
                                <input type="text" class="form-control" id="home-ploat" placeholder="company name"
                                    required="">
                            </div>
                            <div class="col-md-6">
                                <label for="name">Address *</label>
                                <input type="text" class="form-control" id="address-two" placeholder="Address"
                                    required="">
                            </div>
                            <div class="col-md-6">
                                <label for="email">Zip Code *</label>
                                <input type="text" class="form-control" id="zip-code" placeholder="zip-code"
                                    required="">
                            </div>
                            <div class="col-md-6 select_input">
                                <label for="review">Country *</label>
                                <select class="form-control" size="1">
                                    <option value="India">India</option>
                                    <option value="UAE">UAE</option>
                                    <option value="U.K">U.K</option>
                                    <option value="US">US</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="review">City *</label>
                                <input type="text" class="form-control" id="city" placeholder="City" required="">
                            </div>
                            <div class="col-md-6">
                                <label for="review">Region/State *</label>
                                <input type="text" class="form-control" id="region-state" placeholder="Region/state"
                                    required="">
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-sm btn-solid" type="submit">Save setting</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Section ends -->

@endsection
