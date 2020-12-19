@extends('back-end/master')
@section('title', 'İndirim Liste | e-Commerce')

@section('header')
    <!-- jsgrid css-->
    <link rel="stylesheet" type="text/css" href="/assets/css/jsgrid.css">
@endsection

@section('content')
<div class="page-body">

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>İndirim</h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item active">İndirim Listesi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>İndirimler</h5>
                    </div>
                    @if (session()->has('message'))
                        <div class="container">
                            <div class="alert alert-{{ session('messageType') }}" role="alert">
                                {{ session('message') }}
                            </div>
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="btn-popup pull-right">
                            <a type="button" class="btn btn-primary" href="{{ route('admin.newDiscount') }}">İndirim Ekle</a>
                        </div>
                        <div class="table-responsive">
                            <div id="basicScenario" class="product-physical jsgrid" style="position: relative; height: auto; width: 100%;">
                                <div class="jsgrid-grid-header jsgrid-header-scrollbar">
                                    <table class="jsgrid-table">
                                        <tr class="jsgrid-header-row">
                                            <th class="jsgrid-header-cell jsgrid-align-center jsgrid-header-sortable" style="width: 50px;">Resim</th>
                                            <th class="jsgrid-header-cell jsgrid-header-sortable" style="width: 100px;">İsim</th>
                                            <th class="jsgrid-header-cell jsgrid-header-sortable" style="width: 50px;">Durum</th>
                                            <th class="jsgrid-header-cell jsgrid-header-sortable" style="width: 50px;">Tip / Miktar</th>
                                            <th class="jsgrid-header-cell jsgrid-control-field jsgrid-align-center" style="width: 50px;"><input class="jsgrid-button jsgrid-mode-button jsgrid-insert-mode-button" type="button" title="Switch to inserting" /></th>
                                        </tr>
                                        <tr class="jsgrid-filter-row" style="display: table-row;">
                                            <td class="jsgrid-cell jsgrid-align-center" style="width: 50px;"></td>
                                            <td class="jsgrid-cell" style="width: 100px;"><input type="text" /></td>
                                            <td class="jsgrid-cell jsgrid-align-right" style="width: 50px;"><input type="number" /></td>
                                            <td class="jsgrid-cell" style="width: 50px;"><input type="text" /></td>
                                            <td class="jsgrid-cell" style="width: 50px;"><input type="text" /></td>
                                            <td class="jsgrid-cell jsgrid-control-field jsgrid-align-center" style="width: 50px;">
                                                <input class="jsgrid-button jsgrid-search-button" type="button" title="Search" /><input class="jsgrid-button jsgrid-clear-filter-button" type="button" title="Clear filter" />
                                            </td>
                                        </tr>
                                        <tr class="jsgrid-insert-row" style="display: none;">
                                            <td class="jsgrid-cell jsgrid-align-center" style="width: 50px;"><input type="file" /></td>
                                            <td class="jsgrid-cell" style="width: 100px;"><input type="text" /></td>
                                            <td class="jsgrid-cell jsgrid-align-right" style="width: 50px;"><input type="number" /></td>
                                            <td class="jsgrid-cell" style="width: 50px;"><input type="text" /></td>
                                            <td class="jsgrid-cell" style="width: 50px;"><input type="text" /></td>
                                            <td class="jsgrid-cell jsgrid-control-field jsgrid-align-center" style="width: 50px;"><input class="jsgrid-button jsgrid-insert-button" type="button" title="Insert" /></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="jsgrid-grid-body">
                                    <table class="jsgrid-table">
                                        <tbody>
                                            @php
                                                $count = 0;
                                            @endphp
                                            @if ($discounts->count() > 0)
                                                @foreach ($discounts as $discount)
                                                    @if ($count == 0)
                                                        @php
                                                            $count = 1;
                                                        @endphp
                                                        @if ($discount->category_id != "")
                                                            @php
                                                                $category = \App\Models\Category::where('id', $discount->category_id)->first();
                                                            @endphp
                                                            <tr class="jsgrid-row">
                                                                <td class="jsgrid-cell jsgrid-align-center" style="width: 50px;"><img src="/assets/images/category/{{ $category->image }}" class="blur-up lazyloaded" style="height: 50px; width: 50px;" /></td>
                                                                <td class="jsgrid-cell" style="width: 100px;">{{ $category->name }}</td>
                                                                @if ($discount->state == 1)
                                                                    <td class="jsgrid-cell" style="width: 50px;"><i class="fa fa-circle font-success f-12"></i></td>
                                                                @else
                                                                    <td class="jsgrid-cell" style="width: 50px;"><i class="fa fa-circle font-error f-12"></i></td>
                                                                @endif
                                                                <td class="jsgrid-cell" style="width: 100px;">{{ $discount->type }} / {{ $discount->value }}</td>
                                                                <td class="jsgrid-cell jsgrid-control-field jsgrid-align-center" style="width: 50px;">
                                                                    <a href="{{ route('admin.deleteDiscount', $discount->id) }}" >Sil</a>
                                                                </td>
                                                            </tr>
                                                        @else
                                                            @php
                                                                $product = \App\Models\Products::where('id', $discount->product_id)->first();
                                                                $images = explode('|', $product->images);
                                                            @endphp
                                                            <tr class="jsgrid-row">
                                                                <td class="jsgrid-cell jsgrid-align-center" style="width: 50px;"><img src="/assets/images/products/{{ $images[0] }}" class="blur-up lazyloaded" style="height: 50px; width: 50px;" /></td>
                                                                <td class="jsgrid-cell" style="width: 100px;">{{ $product->name }}</td>
                                                                @if ($discount->state == 1)
                                                                    <td class="jsgrid-cell" style="width: 50px;"><i class="fa fa-circle font-success f-12"></i></td>
                                                                @else
                                                                    <td class="jsgrid-cell" style="width: 50px;"><i class="fa fa-circle font-error f-12"></i></td>
                                                                @endif
                                                                <td class="jsgrid-cell" style="width: 100px;">{{ $discount->type }} / {{ $discount->value }}</td>
                                                                <td class="jsgrid-cell jsgrid-control-field jsgrid-align-center" style="width: 50px;">
                                                                    <a href="{{ route('admin.deleteDiscount', $discount->id) }}" >Sil</a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @else
                                                        @php
                                                            $count = 0;
                                                        @endphp
                                                        @if ($discount->category_id != "")
                                                        @php
                                                            $category = \App\Models\Category::where('id', $discount->category_id)->first();
                                                        @endphp
                                                        <tr class="jsgrid-row">
                                                            <td class="jsgrid-cell jsgrid-align-center" style="width: 50px;"><img src="/assets/images/category/{{ $category->image }}" class="blur-up lazyloaded" style="height: 50px; width: 50px;" /></td>
                                                            <td class="jsgrid-cell" style="width: 100px;">{{ $category->name }}</td>
                                                            @if ($discount->state == 1)
                                                                <td class="jsgrid-cell" style="width: 50px;"><i class="fa fa-circle font-success f-12"></i></td>
                                                            @else
                                                                <td class="jsgrid-cell" style="width: 50px;"><i class="fa fa-circle font-error f-12"></i></td>
                                                            @endif
                                                            <td class="jsgrid-cell" style="width: 100px;">{{ $discount->type }} / {{ $discount->value }}</td>
                                                            <td class="jsgrid-cell jsgrid-control-field jsgrid-align-center" style="width: 50px;">
                                                                <a href="{{ route('admin.deleteDiscount', $discount->id) }}" >Sil</a>
                                                            </td>
                                                        </tr>
                                                    @else
                                                        @php
                                                            $product = \App\Models\Products::where('id', $discount->product_id)->first();
                                                            $images = explode('|', $product->images);
                                                        @endphp
                                                        <tr class="jsgrid-row">
                                                            <td class="jsgrid-cell jsgrid-align-center" style="width: 50px;"><img src="/assets/images/products/{{ $images[0] }}" class="blur-up lazyloaded" style="height: 50px; width: 50px;" /></td>
                                                            <td class="jsgrid-cell" style="width: 100px;">{{ $product->name }}</td>
                                                            @if ($discount->state == 1)
                                                                <td class="jsgrid-cell" style="width: 50px;"><i class="fa fa-circle font-success f-12"></i></td>
                                                            @else
                                                                <td class="jsgrid-cell" style="width: 50px;"><i class="fa fa-circle font-error f-12"></i></td>
                                                            @endif
                                                            <td class="jsgrid-cell" style="width: 100px;">{{ $discount->type }} / {{ $discount->value }}</td>
                                                            <td class="jsgrid-cell jsgrid-control-field jsgrid-align-center" style="width: 50px;">
                                                                <a href="{{ route('admin.deleteDiscount', $discount->id) }}" >Sil</a>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    @endif
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                {!!  $discounts->links('back-end.category.parts.pagination') !!}
                                <div class="jsgrid-load-shader" style="display: none; position: absolute; top: 0px; right: 0px; bottom: 0px; left: 0px; z-index: 1000;"></div>
                                <div class="jsgrid-load-panel" style="display: none; position: absolute; top: 50%; left: 50%; z-index: 1000;">Lütfen Bekleyin...</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

</div>
@endsection
