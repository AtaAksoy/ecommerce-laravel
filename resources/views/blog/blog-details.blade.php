@extends('master')
@php
    $title = $blog->title." | Blog".config('app.title');
@endphp
@section('title', $title)

@section('content')
    <!-- breadcrumb start-->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>blog detayları</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Anasayfa</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('blog.list') }}">blog</a></li>
                            <li class="breadcrumb-item active" aria-current="page">blog detayları</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb end-->


    <!--section start-->
    <section class="blog-detail-page section-b-space ratio2_3">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 blog-detail "><img class="mx-auto d-block" src="/assets/images/blog/{{ $blog->image }}"
                        class="img-fluid blur-up lazyload" alt="">
                    <h3>{{ $blog->title }}</h3>
                    <ul class="post-social">
                        <li>{{ date('d/m/Y', strtotime($blog->date)) }}</li>
                        <li>Tarafından: {{ $blog->posted_by }}</li>
                        <li><i class="fa fa-heart"></i> {{ count(json_decode($blog->hits, true)) }} Tıklama</li>
                        @php
                            $comments = $blog->comments;
                            if ($comments != ""){
                                $comments = json_decode($comments, true);
                                $comment_count = count($comments);
                            }
                            else { $comment_count = 0; }
                        @endphp
                        <li><i class="fa fa-comments"></i> {{ $comment_count }} Yorum</li>
                    </ul>
                    {!!html_entity_decode($blog->content)!!}
                </div>
            </div>
            <div style="margin-top: 25px;" class="row blog-contact">
                <div class="col-sm-12">
                    <h2>Yorum Bırak</h2>
                    <form class="theme-form" action="?" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="name">İsim</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder=""
                                    required="">
                            </div>
                            <div class="col-md-12">
                                <label for="email">E-Posta</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="E-Posta" required="">
                                <small>*E-Posta adresiniz gözükmeyecek.</small>
                            </div>
                            <div class="col-md-12">
                                <label for="exampleFormControlTextarea1">Yorum</label>
                                <textarea class="form-control" placeholder="" name="comment"
                                    id="exampleFormControlTextarea1" rows="6"></textarea>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-solid" type="submit">Yorum Yap</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!--Section ends-->
@endsection
