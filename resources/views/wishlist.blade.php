@extends('master')
@section('title', 'İstek Listesi'.config('app.title'))

@section('content')
        <!-- breadcrumb start -->
        <div class="breadcrumb-section">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="page-title">
                            <h2>İstek Listesi</h2>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <nav aria-label="breadcrumb" class="theme-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('index') }}">Anasayfa</a></li>
                                <li class="breadcrumb-item active">İstek Listesi</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb End -->


        <!--section start-->
        <section class="wishlist-section section-b-space">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table cart-table table-responsive-xs">
                            <thead>
                                <tr class="table-head">
                                    <th scope="col">Resim</th>
                                    <th scope="col">İsim</th>
                                    <th scope="col">Fiyat</th>
                                    <th scope="col">Stok</th>
                                    <th scope="col">İşlem</th>
                                </tr>
                            </thead>
                            @foreach ($contents as $product)
                            @php
                                $images = explode('|', $product->images);
                                $discount = false;
                                if ($product->discount_type != null){
                                    $discount = true;
                                    if ($product->discount_type == 'percent'){
                                        $price = ($product->price - ( ($product->discount_value / 100) * $product->price ));
                                    }else{
                                        $price = ($product->price - $product->discount_value);
                                    }
                                }else{
                                    $price = $product->price;
                                }
                                $totalprice+=($price * $product->quantity);
                            @endphp
                                <tbody>
                                    <tr>
                                        <td>
                                            <a href="{{ route('product.show', ['category_slug' => $product->category_slug, 'product_slug' => $product->slug]) }}"><img src="/assets/images/products/{{$images[0]}}" alt="{{ $product->name }}"></a>
                                        </td>
                                        <td><a href="{{ route('product.show', ['category_slug' => $product->category_slug, 'product_slug' => $product->slug]) }}">{{ $product->name.' ('.$product->size.')' }}</a>
                                            <div class="mobile-cart-content row">
                                                <div class="col-xs-3">
                                                    <div class="qty-box">
                                                        <div class="input-group">
                                                            @if ($product->stock > 0)
                                                                STOKTA VAR
                                                            @else
                                                                STOKTA YOK
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-3">
                                                    @if ($discount)
                                                        <del>{{ $product->price }}₺</del>
                                                    @endif
                                                    <h2 class="td-color">{{ $price }}₺</h2>
                                                </div>
                                                <div class="col-xs-3">
                                                    <h2 class="td-color"><a href="#" class="icon"><i class="ti-close"></i></a>
                                                    </h2>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($discount)
                                                <del>{{ $product->price }}₺</del>
                                            @endif
                                            <h2>{{ $price }}₺</h2>
                                        </td>
                                        <td>
                                            <div class="qty-box">
                                                <div class="input-group">
                                                    @if ($product->stock > 0)
                                                        STOKTA VAR
                                                    @else
                                                        STOKTA YOK
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('wishlist.removefromlist', $product->code) }}" class="icon mr-3"><i class="ti-close"></i></a>
                                            <a href="{{ route('wishlist.addtocart', $product->code) }}" class="cart"><i class="ti-shopping-cart"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="row wishlist-buttons">
                    <div class="col-12">
                        <a href="{{ route('index') }}" class="btn btn-solid">Alışverişe Devam Et</a>
                        <a href="{{ route('checkout') }}" class="btn btn-solid">Ödeme</a></div>
                </div>
            </div>
        </section>
        <!--section end-->
@endsection
