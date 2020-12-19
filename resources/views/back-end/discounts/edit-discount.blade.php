@extends('back-end/master')
@section('title', 'Yeni İndirim | Yetkili - eCommerce')

@section('header')

@endsection

@section('content')
<div class="page-body">

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>İndirim Uygula</h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item active">İndirim Düzenle</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="card tab2-card">
            <div class="card-header">
                <h5>İndirim Düzenle</h5>
            </div>
            @if (session()->has('message'))
                <div class="container">
                    <div class="alert alert-{{ session('messageType') }}" role="alert">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            <div class="card-body">
                <div class="tab-content" id="myTabContent">
                    <button class="btn productCodeFinder" style="margin-bottom: 50px">Ürün Kodu Bulucu</button>
                    <div class="form-group row productCodeFinderDiv" style="display: none">
                        <label for="validationCustom21" class="col-xl-3 col-md-4"><span>*</span> Ürün Kodu</label>
                        <select class="form-control col-xl-9 col-md-8 productFinderCode" name="" id="validateCustom0">
                            <option value="" selected>Seçiniz...</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->code }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                        <small>*Kodunu eklemek istediğiniz ürünü seçiniz. Seçim yaptıkça otomatik olarak aşağıya eklenecektir.</small>
                    </div>
                    <form class="needs-validation" method="POST" action="">
                        <div class="tab-pane fade active show" id="general" role="tabpanel" aria-labelledby="general-tab">
                                @csrf
                                <h4>İndirim Bilgileri</h4>
                                <div class="form-group row">
                                    <label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span> İndirim Kategorisi</label>
                                    <select class="form-control col-xl-9 col-md-8 discountCategory" name="discountCategory" id="validateCustom0">
                                        <option value="" selected >Seçiniz...</option>
                                        <option value="category">Kategori</option>
                                        <option value="product">Ürün</option>
                                    </select>
                                </div>
                                <div class="form-group row discountProductDiv discountDiv" style="display: none">
                                    <label for="validationCustom1" class="col-xl-3 col-md-4"><span>*</span> Ürün Kodu</label>
                                    <input name = "discountProductCodes" class="form-control col-xl-8 col-md-7 discountProductCodes" id="validationCustom1" type="text" placeholder="İndirim Uygulanacak Ürün/Ürünlerin Kodu (ÖRN: XXXXXXXXXX,XXXXXXX)">
                                </div>
                                <div class="form-group row discountCategoryDiv discountDiv" style="display: none">
                                    <label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span> Kategoriler</label>
                                    <select class="form-control col-xl-9 col-md-8" name="discountCategoryName" id="validateCustom0">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <label for="validationCustom1" class="col-xl-3 col-md-4"><span>*</span> İndirim Tipi</label>
                                    <select class="form-control col-xl-9 col-md-8" name="discountType" id="validateCustom0">
                                        <option value="percent" selected>Yüzde (%)</option>
                                        <option value="quantity">Miktar</option>
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <label for="validationCustom1" class="col-xl-3 col-md-4"><span>*</span> İndirim Miktarı</label>
                                    <input name = "quantity" class="form-control col-xl-8 col-md-7" id="validationCustom1" value="0" type="number" required min="0">
                                </div>
                        </div>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary">Kaydet</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

</div>

@endsection

@section('footer')
<!--ck editor-->
<script src="/assets/js/editor/ckeditor/ckeditor.js"></script>
<script src="/assets/js/editor/ckeditor/styles.js"></script>
<script src="/assets/js/editor/ckeditor/adapters/jquery.js"></script>
<script src="/assets/js/editor/ckeditor/ckeditor.custom.js"></script>
<script>
    $(document).ready(function() {
        var state = false;
        $('button.productCodeFinder').click(function() {
            if (!state){
                $(".productCodeFinderDiv").slideDown();
                state = true;
            }else {
                $(".productCodeFinderDiv").slideUp();
                state = false;
            }
        });
        $('select.discountCategory').on('change', function (e) {
            var optionSelected = $("option:selected", this).val();
            switch (optionSelected) {
                case 'product':
                    $("div.discountDiv").slideUp();
                    $(".discountProductDiv").slideDown();
                    break;
                case 'category':
                    $("div.discountDiv").slideUp();
                    $(".discountCategoryDiv").slideDown();
                    break;
                default:
                    $("div.discountDiv").slideUp();
                    break;
            }
        });
        $('select.productFinderCode').on('change', function() {
            var optionSelected = $("option:selected", this).val();
            if (optionSelected != ""){
                var codes = $("input.discountProductCodes").val().split(',');
                var add = true;
                for (let index = 0; index < codes.length; index++) {
                    if (codes[index] == optionSelected){ add = false; }

                }
                if (add) {
                    if ($('input.discountProductCodes').val() != ""){
                        $("input.discountProductCodes").val($("input.discountProductCodes").val()+","+ optionSelected);
                    }else {
                        $("input.discountProductCodes").val($("input.discountProductCodes").val()+ optionSelected);
                    }
                }
            }
        });
    });
</script>
@endsection
