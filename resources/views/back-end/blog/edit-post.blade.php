@extends('back-end/master')
@section('title', 'Blog Gönderi Oluştur | Yetkili - eCommerce')

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
                        <h3>Blog Gönderisi Oluştur</h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item">Blog</li>
                        <li class="breadcrumb-item active">Post Düzenle</li>
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
                <h5>Gönderi Düzenle</h5>
            </div>
            @if (session()->has('message'))
                <div class="container">
                    <div class="alert alert-{{ session('messageType') }}" role="alert">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            <div class="card-body">
                <ul class="nav nav-tabs tab-coupon" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link active show" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true" data-original-title="" title="">Genel</a></li>
                    <li class="nav-item"><a class="nav-link" id="seo-tabs" data-toggle="tab" href="#seo" role="tab" aria-controls="seo" aria-selected="false" data-original-title="" title="">SEO</a></li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <form class="needs-validation" method="POST" action="?" enctype="multipart/form-data">
                        <div class="tab-pane fade active show" id="general" role="tabpanel" aria-labelledby="general-tab">
                                @csrf
                                <h4>Genel</h4>
                                <div class="form-group row">
                                    <label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span> Başlık</label>
                                    <input name = "title" value="{{ $blog->title }}" class="form-control col-xl-8 col-md-7" id="validationCustom0" type="text">
                                    <input type="hidden" value="{{ $blog->slug }}" name="old_slug">
                                </div>
                                <div class="form-group row">
                                    <label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span> Resim</label>
                                    <input class="form-control col-xl-8 col-md-7" name="image" id="validationCustom0" type="file">
                                    <img src="/assets/images/blog/{{ $blog->image }}" width="400px" height="200px" class="rounded mx-auto d-block" alt="...">
                                </div>
                                <div class="form-group row editor-label">
                                    <label class="col-xl-3 col-md-4"><span>*</span> İçerik</label>
                                    <div class="col-xl-8 col-md-7 editor-space">
                                        <textarea id="editor1" name="editor1" cols="30" rows="10">{{ $blog->content }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-md-4">Durum</label>
                                    <div class="checkbox checkbox-primary col-xl-8 col-md-7">
                                        @if ($blog->state == 1)
                                            <input name="state" checked id="checkbox-primary-2" type="checkbox" data-original-title="" title="">
                                        @else
                                            <input name="state" id="checkbox-primary-2" type="checkbox" data-original-title="" title="">
                                        @endif
                                        <label for="checkbox-primary-2">Aktifleştir</label>
                                    </div>
                                </div>
                        </div>
                        <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tabs">
                            <h4>SEO</h4>
                            <div class="form-group row editor-label">
                                <label class="col-xl-3 col-md-4">Meta Açıklama</label>
                                <textarea name = "seo_desc" rows="4" class="col-xl-8 col-md-7">{{ $blog->meta_desc }}</textarea>
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
@endsection
