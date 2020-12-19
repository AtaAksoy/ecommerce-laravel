@extends('back-end/master')
@section('title', 'Sipariş Görüntüleme | Yönetim Paneli')

@section('content')
<div class="page-body">

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <div class="page-header-left">
                        <h3>Sipariş Yönetimi
                            <small>AKSY yönetici paneli</small>
                        </h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item">Sipariş</li>
                        <li class="breadcrumb-item active">Görüntüle</li>
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
                        <h5>Sipariş Görüntüle</h5>
                    </div>
                    <div class="card-body">
                        <table class="display" style="text-align: center;" id="basic-1">
                            <thead>
                                <tr>
                                    <th>Ürün(ler)</th>
                                    <th>Beden</th>
                                    <th>Renk</th>
                                    <th>Adet</th>
                                    <th>Toplam</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $content = json_decode($order->content);
                                    $images = [];
                                    $totalprice = 0;
                                @endphp
                                @foreach ($content as $item)
                                    @php
                                        $totalprice += $item->price;
                                        $product = \App\Models\Products::where('code', $item->code)->first();
                                        $category = \App\Models\Category::where('id', $product->category_id)->first();
                                        $image = explode('|', $product->images);
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                <img src="/assets/images/products/{{$image[0]}}" alt="" class="img-fluid img-30 mr-2 blur-up lazyloaded"><a href="{{ route('product.show', ['category_slug' => $category->slug, 'product_slug' => $product->slug]) }}">{{ $product->name }}</a>
                                            </div>
                                        </td>
                                        <td>{{ $item->size }}</td>
                                        <td>{{ $item->color }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->price * $item->quantity }}₺</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <form style="margin-top: 20px;" class="needs-validation" method="POST" action="">
                            @csrf
                            <div class="form-group row">
                                <label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span>Sipariş Durumu</label>
                                <select name="orderState" class="form-control col-xl-9 col-md-8" id="validationCustom0">
                                    @switch($order->state)
                                        @case(1)
                                        <option value="1" selected>Yeni Sipariş</option>
                                        <option value="2">Hazırlanıyor</option>
                                        <option value="3">Kargoya Verildi</option>
                                        <option value="4">Teslim Edildi</option>
                                        <option value="5">İptal Edildi</option>
                                            @break
                                        @case(2)
                                        <option value="1">Yeni Sipariş</option>
                                        <option value="2" selected>Hazırlanıyor</option>
                                        <option value="3">Kargoya Verildi</option>
                                        <option value="4">Teslim Edildi</option>
                                        <option value="5">İptal Edildi</option>
                                            @break
                                        @case(3)
                                        <option value="1">Yeni Sipariş</option>
                                        <option value="2">Hazırlanıyor</option>
                                        <option value="3" selected>Kargoya Verildi</option>
                                        <option value="4">Teslim Edildi</option>
                                        <option value="5">İptal Edildi</option>
                                            @break
                                        @case(4)
                                        <option value="1">Yeni Sipariş</option>
                                        <option value="2">Hazırlanıyor</option>
                                        <option value="3">Kargoya Verildi</option>
                                        <option value="4" selected>Teslim Edildi</option>
                                        <option value="5">İptal Edildi</option>
                                            @break
                                        @case(5)
                                        <option value="1">Yeni Sipariş</option>
                                        <option value="2">Hazırlanıyor</option>
                                        <option value="3">Kargoya Verildi</option>
                                        <option value="4">Teslim Edildi</option>
                                        <option value="5" selected>İptal Edildi</option>
                                            @break
                                        @default

                                    @endswitch
                                </select>
                            </div>
                            <div class="form-group row">
                                <label class="col-xl-3 col-md-4">Adres</label>
                                <textarea name="address" class="form-control col-xl-9 col-md-8" readonly id="" cols="30" rows="10">{{ $order->address }}</textarea>
                            </div>
                            <div class="form-group row">
                                <label class="col-xl-3 col-md-4">İsim Soyisim</label>
                                <input name="name" class="form-control col-xl-9 col-md-8" id="" readonly value="{{ $user->name }}"/>
                            </div>
                            <div class="form-group row">
                                <label class="col-xl-3 col-md-4">E-Mail</label>
                                <input name="name" class="form-control col-xl-9 col-md-8" id="" readonly value="{{ $user->email }}"/>
                            </div>
                            <div class="form-group row">
                                <label class="col-xl-3 col-md-4">Telefon</label>
                                <input name="name" class="form-control col-xl-9 col-md-8" id="" readonly value="{{ $user->phone }}"/>
                            </div>
                            <button type="submit" class="btn btn-primary d-block">Kaydet</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

</div>
@endsection
