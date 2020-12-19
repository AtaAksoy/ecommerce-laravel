@extends('back-end/master')
@section('title', 'Anasayfa Ayarları | e-Commerce')

@section('content')

<div class="page-body">

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>Anasayfa Ayarları</h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item">Ayarlar </li>
                        <li class="breadcrumb-item active">Anasayfa </li>
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
                <div class="card tab2-card">
                    <div class="card-header">
                        <h5> Anasayfa Ayarları</h5>
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
                            <li class="nav-item"><a class="nav-link active show" id="account-tab" data-toggle="tab" href="#account" role="tab" aria-controls="account" aria-selected="true" data-original-title="" title="">Home Banner</a></li>
                            <li class="nav-item"><a class="nav-link" id="smallbanner-tab" data-toggle="tab" href="#smallbanner" role="tab" aria-controls="banner" aria-selected="true" data-original-title="" title="">Small Banner</a></li>
                            <li class="nav-item"><a class="nav-link" id="permission-tabs" data-toggle="tab" href="#permission" role="tab" aria-controls="permission" aria-selected="false" data-original-title="" title="">Pop-up</a></li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade active show" id="account" role="tabpanel" aria-labelledby="account-tab">
                                <form class="needs-validation user-add" novalidate="" action="?" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <h4>Banner Ayarları</h4>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span> 1. Banner</label>
                                        <input class="form-control col-xl-8 col-md-7" id="validationCustom0" type="file" name="banner[]" required="">
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span> Ana Metin</label>
                                        <input class="form-control col-xl-8 col-md-7" id="validationCustom0" type="text" name="mainText1" required="">
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span> Alt Metin</label>
                                        <input class="form-control col-xl-8 col-md-7" id="validationCustom0" type="text" name="subText1" required="">
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span> Yönlendirme Linki</label>
                                        <input class="form-control col-xl-8 col-md-7" id="validationCustom0" type="text" name="subUrl1" required="" value="https://">
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom1" class="col-xl-3 col-md-4"><span>*</span> 2. Banner</label>
                                        <input class="form-control col-xl-8 col-md-7" id="validationCustom1" type="file" name="banner[]" required="">
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span> Ana Metin</label>
                                        <input class="form-control col-xl-8 col-md-7" id="validationCustom0" type="text" name="mainText2" required="">
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span> Alt Metin</label>
                                        <input class="form-control col-xl-8 col-md-7" id="validationCustom0" type="text" name="subText2" required="">
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span> Yönlendirme Linki</label>
                                        <input class="form-control col-xl-8 col-md-7" id="validationCustom0" type="text" name="subUrl2" required="" value="https://">
                                    </div>
                                    <div class="pull-right">
                                        <button type="submit" name="bannerPost" class="btn btn-primary">Kaydet</button>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade" id="smallbanner" role="tabpanel" aria-labelledby="smallbanner-tab">
                                <form class="needs-validation user-add" novalidate="" action="?" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <h4>Small Banner Ayarları</h4>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span> 1. Banner</label>
                                        <input class="form-control col-xl-8 col-md-7" id="validationCustom0" type="file" name="banner[]" required="">
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span> Ana Metin</label>
                                        <input class="form-control col-xl-8 col-md-7" id="validationCustom0" type="text" name="mainText1" required="">
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span> Alt Metin</label>
                                        <input class="form-control col-xl-8 col-md-7" id="validationCustom0" type="text" name="subText1" required="">
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom1" class="col-xl-3 col-md-4"><span>*</span> 2. Banner</label>
                                        <input class="form-control col-xl-8 col-md-7" id="validationCustom1" type="file" name="banner[]" required="">
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span> Ana Metin</label>
                                        <input class="form-control col-xl-8 col-md-7" id="validationCustom0" type="text" name="mainText2" required="">
                                    </div>
                                    <div class="form-group row">
                                        <label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span> Alt Metin</label>
                                        <input class="form-control col-xl-8 col-md-7" id="validationCustom0" type="text" name="subText2" required="">
                                    </div>
                                    <div class="pull-right">
                                        <button type="submit" name="smallbannerPost" class="btn btn-primary">Kaydet</button>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade" id="permission" role="tabpanel" aria-labelledby="permission-tabs">
                                <form class="needs-validation user-add" novalidate="" method="POST" action="?">
                                    @csrf
                                    <div class="permission-block">
                                        <div class="attribute-blocks">
                                            <h5 class="f-w-600 mb-3">Sistemde Gözüken Pop-uplar</h5>
                                            <div class="row">
                                                <div class="col-xl-3 col-sm-4">
                                                    <label for="checkbox-primary-2">Bltene Abone Ol</label>
                                                </div>
                                                <div class="col-xl-9 col-sm-8">
                                                    <div class="form-group row">
                                                        <div class="checkbox checkbox-primary col-xl-8 col-md-7">
                                                            @if ($newsletterSetting['value'] == 1)
                                                                <input name="state" checked id="checkbox-primary-2" type="checkbox" data-original-title="" title="">
                                                            @else
                                                                <input name="state" id="checkbox-primary-2" type="checkbox" data-original-title="" title="">
                                                            @endif
                                                            <label for="checkbox-primary-2"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pull-right">
                                        <button type="submit" name="settingPost" class="btn btn-primary">Kaydet</button>
                                    </div>
                                </form>
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
