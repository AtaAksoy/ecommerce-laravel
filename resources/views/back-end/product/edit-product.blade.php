@extends('back-end/master')
@section('title', 'Ürün Düzenle'.config('app.title'))

@section('content')

<div class="page-body">

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>Ürün Düzenle</h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item">Fiziksel</li>
                        <li class="breadcrumb-item active">Ürün Düzenle</li>
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
                                <h5>Ürün Düzenle</h5>
                            </div>
                            <form class="needs-validation add-product-form" novalidate="" action="?" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row product-adding">
                                        <div class="col-xl-5">
                                            <div class="add-product">
                                                <div class="row">
                                                    <div class="col-xl-9 xl-50 col-sm-6 col-9">
                                                        <img src="/assets/images/products/{{ $images[0] }}" alt="" class="img-fluid image_zoom_1 blur-up lazyloaded">
                                                    </div>
                                                    <div class="col-xl-3 xl-50 col-sm-6 col-3">
                                                        <ul class="file-upload-product">
                                                            <li><div class="box-input-file"><input class="upload" name="image[]" type="file"><i class="fa fa-plus"></i></div></li>
                                                            <li><div class="box-input-file"><input class="upload" name="image[]" type="file"><i class="fa fa-plus"></i></div></li>
                                                            <li><div class="box-input-file"><input class="upload" name="image[]" type="file"><i class="fa fa-plus"></i></div></li>
                                                            <li><div class="box-input-file"><input class="upload" name="image[]" type="file"><i class="fa fa-plus"></i></div></li>
                                                            <li><div class="box-input-file"><input class="upload" name="image[]" type="file"><i class="fa fa-plus"></i></div></li>
                                                            <li><div class="box-input-file"><input class="upload" name="image[]" type="file"><i class="fa fa-plus"></i></div></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-7" style="margin-top: 20px;">
                                            <div class="form">
                                                <div class="form-group mb-3 row">
                                                    <label for="validationCustom01" class="col-xl-3 col-sm-4 mb-0">İsim :</label>
                                                    <input class="form-control col-xl-8 col-sm-7" id="validationCustom01" name="name" type="text" value="{{ $product->name }}" required="">
                                                    <div class="valid-feedback">Looks good!</div>
                                                </div>
                                                <div class="form-group mb-3 row">
                                                    <label for="validationCustom02" class="col-xl-3 col-sm-4 mb-0">Fiyat :</label>
                                                    <input class="form-control col-xl-8 col-sm-7" id="validationCustom02" name="price" value="{{ $product->price }}" type="number" required="">
                                                    <div class="valid-feedback">Looks good!</div>
                                                </div>
                                            </div>
                                            <div class="form">
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-sm-4 mb-0">Stok :</label>
                                                    <fieldset class="qty-box col-xl-9 col-xl-8 col-sm-7 pl-0">
                                                        <div class="input-group">
                                                            <input class="touchspin" name="stock" type="text" value="{{ $product->stock }}">
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-sm-4">Açıklama :</label>
                                                    <div class="col-xl-8 col-sm-7 pl-0 description-sm">
                                                        <textarea id="editor1" name="editor1" cols="10" rows="4">{{ $product->description }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-md-4">Kategori</label>
                                                <div class="checkbox checkbox-primary col-xl-8 col-md-7">
                                                    <select class="form-control" name="category" id="">
                                                        @foreach ($categories as $category)
                                                            @if ($category->id == $product->category_id)
                                                            <option value = "{{$category->id}}" selected>{{ $category->name }}</option>
                                                            @else
                                                            <option value = "{{$category->id}}">{{ $category->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-md-4">Durum</label>
                                                <div class="checkbox checkbox-primary col-xl-8 col-md-7">
                                                    @if ($product->state == 1)
                                                    <input name="state" checked id="checkbox-primary-2" type="checkbox" data-original-title="" title="">
                                                    @else
                                                    <input name="state" id="checkbox-primary-2" type="checkbox" data-original-title="" title="">
                                                    @endif
                                                    <label for="checkbox-primary-2">Aktifleştir</label>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 row">
                                                <label for="validationCustomUsername" class="col-xl-3 col-sm-4 mb-0">Renkler :</label>
                                                <div class="input-group">
                                                    <input class="form-control col-xl-8 col-sm-7" id="validationCustomUsername" type="text" name="colors" required="" value="{{ $colors }}">
                                                    <small>*Kullanım: BEYAZ,SİYAH</small>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 row">
                                                <label for="validationCustomUsername" class="col-xl-3 col-sm-4 mb-0">Beden :</label>
                                                <div class="input-group">
                                                    <input class="form-control col-xl-8 col-sm-7" id="validationCustomUsername" type="text" name="size" required="" value="{{ $sizes }}">
                                                    <small>*Kullanım: S,M,L</small>
                                                </div>
                                            </div>
                                            <div class="offset-xl-3 offset-sm-4">
                                                <button type="submit" class="btn btn-primary">Düzenle</button>
                                            </div>
                                        </div>
                                    </div>
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
<!-- touchspin js-->
<script src="/assets/js/touchspin/vendors.min.js"></script>
<script src="/assets/js/touchspin/touchspin.js"></script>
<script src="/assets/js/touchspin/input-groups.min.js"></script>
<!-- Zoom js-->
<script src="/assets/js/jquery.elevatezoom.js"></script>
<script src="/assets/js/zoom-scripts.js"></script>
<!-- ckeditor js-->
<script src="/assets/js/editor/ckeditor/ckeditor.js"></script>
<script src="/assets/js/editor/ckeditor/styles.js"></script>
<script src="/assets/js/editor/ckeditor/adapters/jquery.js"></script>
<script src="/assets/js/editor/ckeditor/ckeditor.custom.js"></script>

@endsection
