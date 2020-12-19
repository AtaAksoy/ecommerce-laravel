@extends('back-end/master')
@section('title', 'Ürün Listesi | eCommerce')

@section('content')

<div class="page-body">

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>Ürün Listesi
                            <small>AKSY yönetici paneli</small>
                        </h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item">Fiziksel</li>
                        <li class="breadcrumb-item active">Ürün Listesi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    <!-- Container-fluid starts-->
    <div class="container-fluid" style="padding-bottom: 20px">
        @if (session()->has('message'))
            <div class="container">
                <div class="alert alert-{{ session('messageType') }}" role="alert">
                    {{ session('message') }}
                </div>
            </div>
        @endif
        <div class="row products-admin ratio_asos">
            @foreach ($products as $product)
            @php
                $images = explode('|', $product->images);
                $category = \App\Models\Category::where('id', $product->category_id);
            @endphp
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body product-box">
                        <div class="img-wrapper">
                            <div class="front">
                                <a href="{{ route('admin.products.edit', $product->code) }}"><img src="/assets/images/products/{{ $images[0] }}" class="img-fluid blur-up lazyload bg-img" alt=""></a>
                                <div class="product-hover">
                                    <ul>
                                        <li>
                                            <button class="btn" type="button" data-original-title="" title=""><i class="ti-pencil-alt"></i></button>
                                        </li>
                                        <li>
                                            <button class="btn" type="button" data-toggle="modal" data-target="#exampleModalCenter" data-original-title="" title=""><i class="ti-trash"></i></button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="product-detail">
                            <div class="rating"><i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i></div>
                            <a href="{{ route('admin.products.edit', $product->code) }}">
                                <h6>{{ $product->name }}</h6>
                            </a>
                            <h4>{{ $product->price }}₺</h4>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
        {!!  $products->links('back-end.parts.pagination') !!}
    </div>
    <!-- Container-fluid Ends-->

</div>
@endsection
