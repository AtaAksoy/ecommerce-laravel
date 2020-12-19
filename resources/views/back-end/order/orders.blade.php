@extends('back-end/master')
@section('title', 'Satın Alımları Görüntüle | Yetkili Paneli')

@section('content')
<div class="page-body">

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>Siparişler
                            <small>AKSY yönetici paneli</small>
                        </h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item">Satışlar</li>
                        <li class="breadcrumb-item active">Siparişler</li>
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
                        <h5>Siparişleri Yönet</h5>
                    </div>
                    <div class="card-body order-datatable">
                        <table class="display" style="text-align: center;" id="basic-1">
                            <thead>
                            <tr>
                                <th>Sipariş Id</th>
                                <th>Ürün(ler)</th>
                                <th>Sipariş Durumu</th>
                                <th>Tarih</th>
                                <th>Toplam</th>
                                <th>İşlem</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchases as $order)
                                @php
                                    $content = json_decode($order->content);
                                    $images = [];
                                    $totalprice = 0;
                                    foreach ($content as $item) {
                                        $totalprice += ($item->price * $item->quantity);
                                        $product = \App\Models\Products::where('code', $item->code)->first();
                                        $image = explode('|', $product->images);
                                        array_push($images, $image[0]);
                                    }
                                @endphp
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>
                                        <div class="d-flex">
                                            @for ($i = 0; $i < count($images); $i++)
                                            <img src="/assets/images/products/{{$images[$i]}}" alt="" class="img-fluid img-30 mr-2 blur-up lazyloaded">
                                            @endfor
                                        </div>
                                    </td>
                                    <td>
                                        @switch($order->state)
                                            @case(1)
                                            <span class="badge badge-warning">Yeni Sipariş</span>
                                                @break
                                            @case(2)
                                                <span class="badge badge-secondary">Hazırlanıyor</span>
                                                @break
                                            @case(3)
                                                <span class="badge badge-primary">Kargoya Verildi</span>
                                                @break
                                            @case(4)
                                                <span class="badge badge-success">Teslim Edildi</span>
                                                @break
                                            @case(5)
                                                <span class="badge badge-danger">İptal Edildi</span>
                                                @break
                                            @default
                                            <span class="badge badge-success">HATA</span>
                                        @endswitch
                                    </td>
                                    <td>{{ $order->date }}</td>
                                    <td>{{ $totalprice }}₺</td>
                                    <td><a href="{{ route('admin.order.show', $order->code) }}">Görüntüle</a></td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    {!!  $purchases->links('back-end.parts.pagination') !!}
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

</div>
@endsection
