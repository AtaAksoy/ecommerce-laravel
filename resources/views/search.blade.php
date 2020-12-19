@extends('master')
@section('title', 'Arama'.config('app.title'))

@section('content')
    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>arama</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">anasayfa</a></li>
                            <li class="breadcrumb-item active">arama</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->


    <!--section start-->
    <section class="authentication-page">
        <div class="container">
            <section class="search-block">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-3">
                            <form class="form-header" method="GET" action="">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="q" aria-label=""
                                        placeholder="Ürün Ara">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-solid"><i class="fa fa-search"></i>Ara</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
    <!-- section end -->


    <!-- product section start -->
    @if (isset($products))
    <section class="section-b-space ratio_asos">
        <div class="container">
            <div class="row search-product">
                @foreach ($products as $product)
                @php
                    $images = explode('|', $product->images);
                    if ($product->discount_type != null){
                        if ($product->discount_type == 'percent'){
                            $price = ($product->price - ( ($product->discount_value / 100) * $product->price ));
                        }else{
                            $price = ($product->price - $product->discount_value);
                        }
                    }else{
                        $price = $product->price;
                    }
                @endphp
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="product-box">
                        <div class="img-wrapper">
                            <div class="front">
                                <a href="{{ route('product.show', ['category_slug' => $product->category_slug, 'product_slug' => $product->slug]) }}"><img src="/assets/images/products/{{ $images[0] }}"
                                        class="img-fluid blur-up lazyload bg-img" alt="{{ $product->name }}"></a>
                            </div>
                            <div class="back">
                                <a href="{{ route('product.show', ['category_slug' => $product->category_slug, 'product_slug' => $product->slug]) }}"><img src="/assets/images/products/{{ $images[1] }}"
                                        class="img-fluid blur-up lazyload bg-img" alt="{{ $product->name }}"></a>
                            </div>
                        </div>
                        <div class="product-detail">
                            <div class="rating"><i class="fa fa-star"></i> <i class="fa fa-star"></i> <i
                                    class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i></div>
                            <a href="{{ route('product.show', ['category_slug' => $product->category_slug, 'product_slug' => $product->slug]) }}">
                                <h6>{{ $product->name }}</h6>
                            </a>
                            @if ($product->discount_type != null)
                                <h4>{{ $price }}₺<del style="margin-left: 5px;">{{ $product->price }}₺</del></h4>
                            @else
                                <h4>{{ $price }}₺</h4>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            {!! $products->appends(['q' => $key])->links('parts.pagination') !!}
        </div>
    </section>
    @endif
    <!-- product section end -->
@endsection
