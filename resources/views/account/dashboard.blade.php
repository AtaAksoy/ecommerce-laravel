@extends('master')
@section('title', 'Hesap Paneli'.config('app.title'))

@section('content')
    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>Hesap Paneli</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Anasayfa</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Hesap</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->


    <!-- section start -->
    <section class="section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="account-sidebar"><a class="popup-btn">hesabım</a></div>
                    <div class="dashboard-left">
                        <div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left"
                                    aria-hidden="true"></i> geri</span></div>
                        <div class="block-content">
                            <ul>
                                <li class="active"><a href="{{ route('account.dashboard') }}">Hesap Bilgisi</a></li>
                                <li><a href="#">Siparişlerim</a></li>
                                <li><a href="{{ route('wishlist') }}">İstek Listem</a></li>
                                <li><a href="#">Hesabım</a></li>
                                <li class="last"><a href="{{ route('authenticate.logout') }}">Çıkış</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="dashboard-right">
                        <div class="dashboard">
                            <div class="page-title">
                                <h2>Hesap Panelim</h2>
                            </div>
                            <div class="welcome-msg">
                                <p>Merhaba, {{ Auth::user()->name }}!</p>
                                <p>Bu sayfadan hesabınızla ilgili bilgileri, satın alımlarınızı ve istek listenizi düzenleyebilirsiniz.</p>
                            </div>
                            <div class="box-account box-info">
                                <div class="box-head">
                                    <h2>Hesap Bilgileri</h2>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="box">
                                            <div class="box-title">
                                                <h3>İletişim Bilgileri</h3><a href="javascript:void(0);" id = 'editContactInfo'>Düzenle</a>
                                            </div>
                                            <div class="box-content">
                                                <form class="contactInfoForm" action="" method="POST" style="display: none;">
                                                    @csrf
                                                    <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" />
                                                    <button class="btn" type="submit" name="updateContact">Kaydet</button>
                                                </form>
                                                <div class="contactInfo">
                                                    <h6 id="name">{{ Auth::user()->name }}</h6>
                                                </div>
                                                <h6>{{ Auth::user()->email }}</h6>
                                                <h6><a href="{{ route('account.changepassword') }}">Şifremi Değiştir</a></h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="box">
                                            <div class="box-title">
                                                <h3>Bülten</h3><a href="#">Düzenle</a>
                                            </div>
                                            <div class="box-content">
                                                <form action="" method="POST">
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        @csrf
                                                        @if ($newsletter)
                                                        <input type="checkbox" name="newsletter" id="newsletter" checked>
                                                        @else
                                                        <input class="form-control" type="checkbox" id="newsletter" name="newsletter">
                                                        @endif
                                                            <label for="newsletter">Bülten</label>
                                                    </div>
                                                <button name="updateNewsletter" class="btn btn-secondary" type="submit">Güncelle</button>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="box">
                                            <div class="box-title">
                                                <h3>Adres Bilgisi</h3><a href="javascript:void(0);">Düzenle</a>
                                            </div>
                                            <div class="box-content">
                                                <form class="" action="" method="POST">
                                                    @csrf
                                                    <textarea class="form-control" name="address" id="" cols="30" rows="10">{{ Auth::user()->address }}</textarea>
                                                    <button class="btn" type="submit" name="updateAddress">Kaydet</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- section end -->
@endsection

@section('footer')
    <script>
        var contactInfoInput = '<input class="form-control" value="'+$('h6#name').html()+'"/><input class="form-control" value="'+$('h6#email').html()+'"/>';
        $('#editContactInfo').click(function() {
            $('.contactInfo').hide();
            $('.contactInfoForm').show();
        });
    </script>
@endsection
