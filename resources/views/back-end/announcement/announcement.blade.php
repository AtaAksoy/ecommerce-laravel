@extends('back-end/master')
@section('title', 'Duyuru Yap | Yetkili - eCommerce')

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
                        <h3>Duyuru Yap</h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item active">Duyuru</li>
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
                <h5>Duyuru Yap</h5>
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
                    <form class="needs-validation" method="POST" action="">
                        <div class="tab-pane fade active show" id="general" role="tabpanel" aria-labelledby="general-tab">
                                @csrf
                                <h4>Duyuru</h4>
                                <div class="form-group row">
                                    <label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span> Başlık</label>
                                    <input name = "title" class="form-control col-xl-8 col-md-7" id="validationCustom0" type="text">
                                </div>
                                <div class="form-group row">
                                    <label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span> İçerik</label>
                                    <input name = "message" class="form-control col-xl-8 col-md-7" id="validationCustom0" type="text">
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
