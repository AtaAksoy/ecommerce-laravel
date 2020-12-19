@extends('master')
@section('title', 'Ödeme '.config('app.title'))

@section('content')
        <!-- breadcrumb start -->
        <div class="breadcrumb-section">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="page-title">
                            <h2>Ödeme</h2>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <nav aria-label="breadcrumb" class="theme-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('index') }}">Anasayfa</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Ödeme</li>
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
                <div class="checkout-page">
                    <div class="checkout-form">
                        <form method="POST" action="">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 col-sm-12 col-xs-12">
                                    <div class="checkout-title">
                                        <h3>Kargo/Fatura Detayı</h3>
                                    </div>
                                    <div class="row check-out">
                                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                            <div class="field-label">Ad</div>
                                            <input type="text" name="firstname" value="" placeholder="" required>
                                        </div>
                                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                            <div class="field-label">Soyad</div>
                                            <input type="text" name="lastname" value="" placeholder="" required>
                                        </div>
                                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                            <div class="field-label">Telefon</div>
                                            <input type="text" name="phone" value="" placeholder="" required>
                                        </div>
                                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                            <div class="field-label">E-Posta</div>
                                            <input type="email" name="email" value="" placeholder="" required>
                                        </div>
                                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                            <div class="field-label">Şehir</div>
                                            <select name="city">
                                                <option value="0" selected>------</option>
                                                <option value="adana">Adana</option>
                                                <option value="adiyaman">Adıyaman</option>
                                                <option value="afyonkarahisar">Afyonkarahisar</option>
                                                <option value="agri">Ağrı</option>
                                                <option value="amasya">Amasya</option>
                                                <option value="ankara">Ankara</option>
                                                <option value="antalya">Antalya</option>
                                                <option value="artvin">Artvin</option>
                                                <option value="aydin">Aydın</option>
                                                <option value="balikesir">Balıkesir</option>
                                                <option value="bilecik">Bilecik</option>
                                                <option value="bingol">Bingöl</option>
                                                <option value="bitlis">Bitlis</option>
                                                <option value="bolu">Bolu</option>
                                                <option value="burdur">Burdur</option>
                                                <option value="bursa">Bursa</option>
                                                <option value="canakkale">Çanakkale</option>
                                                <option value="cankiri">Çankırı</option>
                                                <option value="corum">Çorum</option>
                                                <option value="denizli">Denizli</option>
                                                <option value="diyarbakir">Diyarbakır</option>
                                                <option value="edirne">Edirne</option>
                                                <option value="elazıg">Elazığ</option>
                                                <option value="erzincan">Erzincan</option>
                                                <option value="erzurum">Erzurum</option>
                                                <option value="eskisehir">Eskişehir</option>
                                                <option value="gaziantep">Gaziantep</option>
                                                <option value="giresun">Giresun</option>
                                                <option value="gumushane">Gümüşhane</option>
                                                <option value="hakkari">Hakkâri</option>
                                                <option value="hatay">Hatay</option>
                                                <option value="isparta">Isparta</option>
                                                <option value="mersin">Mersin</option>
                                                <option value="istanbul">İstanbul</option>
                                                <option value="izmir">İzmir</option>
                                                <option value="kars">Kars</option>
                                                <option value="kastamonu">Kastamonu</option>
                                                <option value="kayseri">Kayseri</option>
                                                <option value="kirklareli">Kırklareli</option>
                                                <option value="kirsehir">Kırşehir</option>
                                                <option value="kocaeli">Kocaeli</option>
                                                <option value="konya">Konya</option>
                                                <option value="kutahya">Kütahya</option>
                                                <option value="malatya">Malatya</option>
                                                <option value="manisa">Manisa</option>
                                                <option value="kahramanmaras">Kahramanmaraş</option>
                                                <option value="mardin">Mardin</option>
                                                <option value="mugla">Muğla</option>
                                                <option value="mus">Muş</option>
                                                <option value="nevsehir">Nevşehir</option>
                                                <option value="nigde">Niğde</option>
                                                <option value="ordu">Ordu</option>
                                                <option value="rize">Rize</option>
                                                <option value="sakarya">Sakarya</option>
                                                <option value="samsun">Samsun</option>
                                                <option value="siirt">Siirt</option>
                                                <option value="sinop">Sinop</option>
                                                <option value="sivas">Sivas</option>
                                                <option value="tekirdag">Tekirdağ</option>
                                                <option value="tokat">Tokat</option>
                                                <option value="trabzon">Trabzon</option>
                                                <option value="tunceli">Tunceli</option>
                                                <option value="sanliurfa">Şanlıurfa</option>
                                                <option value="usak">Uşak</option>
                                                <option value="van">Van</option>
                                                <option value="yozgat">Yozgat</option>
                                                <option value="zonguldak">Zonguldak</option>
                                                <option value="aksaray">Aksaray</option>
                                                <option value="bayburt">Bayburt</option>
                                                <option value="karaman">Karaman</option>
                                                <option value="kirikkale">Kırıkkale</option>
                                                <option value="batman">Batman</option>
                                                <option value="sirnak">Şırnak</option>
                                                <option value="bartin">Bartın</option>
                                                <option value="ardahan">Ardahan</option>
                                                <option value="igdir">Iğdır</option>
                                                <option value="yalova">Yalova</option>
                                                <option value="karabuk">Karabük</option>
                                                <option value="kilis">Kilis</option>
                                                <option value="osmaniye">Osmaniye</option>
                                                <option value="duzce">Düzce</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                            <div class="field-label">Adres</div>
                                            <input type="text" name="address" value="" placeholder="Açık Adres" required>
                                        </div>
                                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                            <div class="field-label">Mahalle</div>
                                            <input type="text" name="mahalle" value="" placeholder="" required>
                                        </div>
                                        <div class="form-group col-md-12 col-sm-6 col-xs-12">
                                            <div class="field-label">Posta Kodu</div>
                                            <input type="text" name="postcode" value="" placeholder="" required>
                                        </div>
                                        @if (!Auth::check())
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <input type="checkbox" name="create_an_account" id="account-option"> &ensp;
                                                <label for="account-option">Hesap Oluştur?</label>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-xs-12">
                                    <div class="checkout-details">
                                        <div class="order-box">
                                            <div class="title-box">
                                                <div>Ürün <span>Toplam</span></div>
                                            </div>
                                            <ul class="qty">
                                                @php
                                                    $totalprice = 0;
                                                @endphp
                                                @foreach ($cart as $item)
                                                @php
                                                    if ($item->discount_type != null){
                                                        $discount = true;
                                                        if ($item->discount_type == 'percent'){
                                                            $price = ($item->price - ( ($item->discount_value / 100) * $item->price ));
                                                        }else{
                                                            $price = ($item->price - $item->discount_value);
                                                        }
                                                    }else{
                                                        $price = $item->price;
                                                    }
                                                    $totalprice+=($price * $item->quantity);
                                                @endphp
                                                <li><a style="color:#333333;text-decoration:underline;" href="{{ route('product.show', ['category_slug' => $item->category_slug, 'product_slug' => $item->slug]) }}">{{ $item->name.' ('.$item->size.')' }} × {{ $item->quantity }}</a>
                                                    <span>{{ $price }}₺</span>
                                                </li>
                                                @endforeach
                                            </ul>
                                            <ul class="sub-total">
                                                <li>Ara Toplam <span class="count">{{ $totalprice }}₺</span></li>
                                                <li>Kargo
                                                    <div class="shipping">
                                                        <div class="shopping-option">
                                                            <input type="checkbox" name="free-shipping" id="free-shipping">
                                                            <label for="free-shipping">Ücretsiz Kargo</label>
                                                        </div>
                                                        <div class="shopping-option">
                                                            <input type="checkbox" name="local-pickup" id="local-pickup">
                                                            <label for="local-pickup">Mağazadan Al</label>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <ul class="total">
                                                <li>Toplam <span class="count">{{ $totalprice }}₺</span></li>
                                            </ul>
                                        </div>
                                        <div class="payment-box">
                                            <div class="upper-box">
                                                <div class="payment-options">
                                                    <ul>
                                                        <li>
                                                            <div class="radio-option">
                                                                <input type="radio" name="payment-group" id="payment-1"
                                                                    checked="checked">
                                                                <label for="payment-1">Check Payments<span
                                                                        class="small-text">Please send a check to Store
                                                                        Name, Store Street, Store Town, Store State /
                                                                        County, Store Postcode.</span></label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="radio-option">
                                                                <input type="radio" name="payment-group" id="payment-2">
                                                                <label for="payment-2">Cash On Delivery<span
                                                                        class="small-text">Please send a check to Store
                                                                        Name, Store Street, Store Town, Store State /
                                                                        County, Store Postcode.</span></label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="radio-option paypal">
                                                                <input type="radio" name="payment-group" id="payment-3">
                                                                <label for="payment-3">PayPal<span class="image"><img
                                                                            src="../assets/images/paypal.png"
                                                                            alt=""></span></label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="text-right"><button type="submit" class="btn-solid btn">Satın Al</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- section end -->
@endsection
@section('footer')
@if (isset($checkoutFormInitialize))
{!! var_dump($checkoutFormInitialize) !!}
@endif
@endsection
