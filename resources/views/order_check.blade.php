@extends('master')
@section('title', 'Ödeme Sonuç'.config('app.title'))

@section('content')
        <!-- thank-you section start -->
        <section class="section-b-space light-layout">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="success-text"><i class="fa fa-check-circle" aria-hidden="true"></i>
                            <h2>teşekkürler</h2>
                            <p>Ödeme başarıyla alındı ve siparişiniz bize ulaştı!</p>
                            <p>Sipariş ID: #{{ $purchase->code }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Section ends -->

        <!-- order-detail section start -->
        <section class="section-b-space">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="product-order">
                            <h3>SİPARİŞ DETAYINIZ</h3>
                            @php
                                $items = json_decode($purchase->content);
                                $totalprice = 0;
                            @endphp
                            @foreach ($items as $item)
                            <div class="row product-order-detail">
                                <div class="col-3 order_detail">
                                    <div>
                                        <h4>ÜRÜN İSMİ</h4>
                                        <h5>{{ $item->name. '( '.$item->size.' )' }}</h5>
                                    </div>
                                </div>
                                <div class="col-3 order_detail">
                                    <div>
                                        <h4>adet</h4>
                                        <h5>{{ $item->quantity }}</h5>
                                    </div>
                                </div>
                                <div class="col-3 order_detail">
                                    <div>
                                        <h4>fiyat</h4>
                                        <h5>{{ $item->price }}₺</h5>
                                    </div>
                                </div>
                            </div>
                            @php
                                $totalprice += $item->price * $item->quantity;
                            @endphp
                            @endforeach
                            <div class="final-total">
                                <h3>toplam <span>{{ $totalprice }}₺</span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row order-success-sec">
                            <div class="col-sm-6">
                                <h4>özet</h4>
                                <ul class="order-detail">
                                    <li>Sipariş ID: {{ $purchase->code }}</li>
                                    <li>Sipariş Tarihi: {{ date('d-m-Y', strtotime($purchase->date)) }}</li>
                                    <li>Sipariş Toplam: {{ $totalprice }}₺</li>
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <h4>Kargo Adresi</h4>
                                <ul class="order-detail">
                                    <li>{{ $purchase->address }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Section ends -->
@endsection
