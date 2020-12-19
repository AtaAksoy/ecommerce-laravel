@extends('back-end/master')
@section('title', 'Blog Gönderi Listesi | e-Commerce')

@section('header')
    <!-- jsgrid css-->
    <link rel="stylesheet" type="text/css" href="/assets/css/jsgrid.css">
@endsection

@section('content')
<div class="page-body">

    @if (session()->has('message'))
        <div style="margin-top: 25px !important;" class="container">
            <div class="alert alert-{{ session('messageType') }}" role="alert">
                {{ session('message') }}
            </div>
        </div>
    @endif
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>Gönderi Listesi</h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item">Blog</li>
                        <li class="breadcrumb-item active">Gönderi Listesi</li>
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
                        <h5>Page Details</h5>
                    </div>
                    <div class="card-body">
<div id="batchDelete" class="category-table order-table jsgrid" style="position: relative; height: auto; width: 100%;">
    <div class="jsgrid-grid-header jsgrid-header-scrollbar">
        <table class="jsgrid-table">
            <tr class="jsgrid-header-row">
                <th class="jsgrid-header-cell jsgrid-align-center" style="width: 100px;">
                    <button type="button" class="btn btn-danger btn-sm btn-delete mb-0 b-r-4">İşlem</button>
                </th>
                <th class="jsgrid-header-cell" style="width: 150px;">Başlık</th>
                <th class="jsgrid-header-cell jsgrid-align-right" style="width: 100px;">Durum</th>
                <th class="jsgrid-header-cell jsgrid-align-right" style="width: 100px;">Oluşturulma Tarihi</th>
            </tr>
            <tr class="jsgrid-filter-row" style="display: none;">
                <td class="jsgrid-cell jsgrid-align-center" style="width: 100px;"></td>
                <td class="jsgrid-cell" style="width: 150px;"><input type="text"></td>
                <td class="jsgrid-cell jsgrid-align-right" style="width: 100px;"><input type="number"></td>
                <td class="jsgrid-cell jsgrid-align-right" style="width: 100px;"><input type="number"></td>
            </tr>
            <tr class="jsgrid-insert-row" style="display: none;">
                <td class="jsgrid-cell jsgrid-align-center" style="width: 100px;"></td>
                <td class="jsgrid-cell" style="width: 150px;"><input type="text"></td>
                <td class="jsgrid-cell jsgrid-align-right" style="width: 100px;"><input type="number"></td>
                <td class="jsgrid-cell jsgrid-align-right" style="width: 100px;"><input type="number"></td>
            </tr>
        </table>
    </div>
    <div class="jsgrid-grid-body">
        <table class="jsgrid-table">
            <tbody>
                @for ($i = 0; $i < count($blogPosts); $i++)
                    <tr class="jsgrid-row">
                        <td class="jsgrid-cell jsgrid-align-center" style="width: 100px;"><a href = "{{ route('admin.blog.edit', $blogPosts[$i]->slug) }}">Düzenle</a></td>
                        <td class="jsgrid-cell" style="width: 150px;">{{ $blogPosts[$i]->title }}</td>
                        @if ($blogPosts[$i]->state == 1)
                        <td class="jsgrid-cell jsgrid-align-right" style="width: 100px;"><i class="fa fa-circle font-success f-12"></i></td>
                        @else
                        <td class="jsgrid-cell jsgrid-align-right" style="width: 100px;"><i class="fa fa-circle font-error f-12"></i></td>
                        @endif
                        <td class="jsgrid-cell jsgrid-align-right" style="width: 100px;">{{ $blogPosts[$i]->date }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
        {!!  $blogPosts->links('back-end.parts.pagination') !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

</div>
@endsection
