@extends('master')
@section('title', 'Sepet '. config('app.title'))

@section('content')
    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>sepet</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">anasayfa</a></li>
                            <li class="breadcrumb-item active">sepet</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->


    <!--section start-->
    <section class="cart-section section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <table class="table cart-table table-responsive-xs">
                        <thead>
                            <tr class="table-head">
                                <th scope="col">resim</th>
                                <th scope="col">ürün ismi</th>
                                <th scope="col">fiyat</th>
                                <th scope="col">adet</th>
                                <th scope="col">işlem</th>
                                <th scope="col">toplam</th>
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
                                                        <input type="text" name="quantity" class="form-control input-number"
                                                            value="{{ $product->quantity }}">
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
                                                <h2 class="td-color"><a href="{{ route('cart.removefrom', $product->code.'|'.$product->size) }}" class="icon"><i class="ti-close"></i></a>
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
                                                <input type="number" name="quantity" class="form-control input-number"
                                                    value="{{ $product->quantity }}">
                                            </div>
                                        </div>
                                    </td>
                                    <td><a href="{{ route('cart.removefrom', $product->code.'|'.$product->size) }}" class="icon"><i class="ti-close"></i></a></td>
                                    <td>
                                        <h2 class="td-color">{{ ($price * $product->quantity) }}₺</h2>
                                    </td>
                                </tr>
                            </tbody>
                        @endforeach
                    </table>
                    <table class="table cart-table table-responsive-md">
                        <tfoot>
                            <tr>
                                <td>toplam fiyat :</td>
                                <td>
                                    <h2>{{ $totalprice }}₺</h2>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="row cart-buttons">
                <div class="col-6"><a href="{{ route('index') }}" class="btn btn-solid">alışverişe devam et</a></div>
                <div class="col-6"><a href="{{ route('checkout') }}" class="btn btn-solid">satın al</a></div>
            </div>
        </div>
    </section>
    <!--section end-->
@endsection
@section('footer')

@endsection
