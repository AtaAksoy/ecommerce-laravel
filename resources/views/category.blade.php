@extends('master')
@php
    $title = $category->name.config('app.title')." Kategori Sayfası";
@endphp
@section('title', $title)

@section('header')

@endsection

@section('content')
    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>{{ $category->name }}</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">anasayfa</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb end -->


    <!-- section start -->
    <section class="section-b-space ratio_asos">
        <div class="collection-wrapper">
            <div class="container">
                <div class="row">
                    <div class="collection-content col">
                        <div class="page-main-content">
                            <div class="top-banner-wrapper">
                                <a href="#"><img src="/assets/images/category/{{ $category->image }}" class="img-fluid blur-up lazyload" alt=""></a>
                                <div class="top-banner-content small-section">
                                    {!!html_entity_decode($category->description)!!}
                                </div>
                            </div>
                            <div class="collection-product-wrapper">
                                <div class="product-top-filter">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="product-filter-content">
                                                <div class="search-count">
                                                    <h5>Bu sayfada 20 ürün gösteriliyor.</h5>
                                                </div>
                                                <div class="collection-view">
                                                    <ul>
                                                        <li><i class="fa fa-th grid-layout-view"></i></li>
                                                        <li><i class="fa fa-list-ul list-layout-view"></i></li>
                                                    </ul>
                                                </div>
                                                <div class="collection-grid-view">
                                                    <ul>
                                                        <li><img src="../assets/images/icon/2.png" alt="" class="product-2-layout-view"></li>
                                                        <li><img src="../assets/images/icon/3.png" alt="" class="product-3-layout-view"></li>
                                                        <li><img src="../assets/images/icon/4.png" alt="" class="product-4-layout-view"></li>
                                                        <li><img src="../assets/images/icon/6.png" alt="" class="product-6-layout-view"></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-wrapper-grid">
                                    <div class="row margin-res">
                                        @foreach ($products as $product)
                                        @php
                                            $images = explode('|', $product->images);
                                            $productDiscount = \App\Models\Discount::where('product_id', $product->id)->where('state', 1)->first();
                                        @endphp
                                            <div class="col-lg-4 col-6 col-grid-box">
                                                <div class="product-box">
                                                    <div class="img-wrapper">
                                                        <div class="front">
                                                            <a href="{{ route('product.show', ['category_slug' => $category->slug, 'product_slug' => $product->slug]) }}"><img src="/assets/images/products/{{ $images[0] }}" class="img-fluid blur-up lazyload bg-img" alt=""></a>
                                                        </div>
                                                        <div class="back">
                                                            <a href="{{ route('product.show', ['category_slug' => $category->slug, 'product_slug' => $product->slug]) }}"><img src="/assets/images/products/{{ @$images[1] }}" class="img-fluid blur-up lazyload bg-img" alt=""></a>
                                                        </div>
                                                    </div>
                                                    <div class="product-detail">
                                                        <div>
                                                            <div class="rating"><i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i></div>
                                                            <a href="{{ route('product.show', ['category_slug' => $category->slug, 'product_slug' => $product->slug]) }}">
                                                                <h6>{{$product->name}}</h6>
                                                            </a>
                                                            <p>{{substr($product->description, 0, 100)}}</p>
                                                            @if (isset($productDiscount))
                                                                @switch($productDiscount->type)
                                                                @case('percent')
                                                                    <h4>{{ ( $product->price - ( ($productDiscount->value / 100) * $product->price ) ) }}₺<del>{{ $product->price }}₺</del></h4>
                                                                    @break
                                                                @case('quantity')
                                                                    <h4>{{ ($product->price - $productDiscount->value) }}₺<del>{{ $product->price }}₺</del></h4>
                                                                    @break
                                                                @default
                                                                    <h4>₺<del>{{ $product->price }}₺</del></h4>
                                                                @endswitch
                                                            @else
                                                                @if (isset($category_discount))
                                                                @switch($category_discount->type)
                                                                    @case('percent')
                                                                        <h4>{{ ( $product->price - ( ($category_discount->value / 100) * $product->price ) ) }}₺<del>{{ $product->price }}₺</del></h4>
                                                                        @break
                                                                    @case('quantity')
                                                                        <h4>{{ ($product->price - $category_discount->value) }}₺<del>{{ $product->price }}₺</del></h4>
                                                                        @break
                                                                    @default
                                                                        <h4>₺<del>{{ $product->price }}₺</del></h4>
                                                                @endswitch
                                                                @else
                                                                    <h4>{{ $product->price }}₺</h4>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                {!! $products->links('parts.pagination') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- section End -->
@endsection

@section('footer')

@endsection
