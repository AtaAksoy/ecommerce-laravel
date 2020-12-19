@extends('master')
@section('title', 'Blog Gönderileri'.config('app.title'))

@section('content')
    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>blog</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Anasayfa</a></li>
                            <li class="breadcrumb-item active">blog</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->


    <!-- section start -->
    <section class="section-b-space blog-page ratio2_3">
        <div class="container">
            <div class="row">
                <!--Blog sidebar start-->
                <div class="col-xl-3 col-lg-4 col-md-5">
                    <div class="blog-sidebar">
                        <div class="theme-card">
                            <h4>Popüler Gönderiler</h4>
                            <ul class="recent-blog">
                                @if ($popularPosts->count() > 0)
                                    @foreach ($popularPosts as $post)
                                    <li>
                                        <div class="media"><img class="img-fluid blur-up lazyload"
                                                src="/assets/images/blog/{{ $post->image }}" alt="{{ Str::substr($post->title, 0, 20) }}">
                                            <div class="media-body align-self-center">
                                                <h6><a style="color:#333333" href="{{ route('blog.showblog', $post->slug) }}">{{ Str::substr($post->title, 0, 15) }}</a></h6>
                                                <p>
                                                @if (count(json_decode($post->hits, true)))
                                                    {{ count(json_decode($post->hits, true)) }}
                                                @else
                                                0
                                                @endif
                                                tıklama</p>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <!--Blog sidebar start-->
                <!--Blog List start-->
                <div class="col-xl-9 col-lg-8 col-md-7 order-sec">
                    @if ($blogs->count() > 0)
                        @foreach ($blogs as $blog)
                        <div class="row blog-media">
                            <div class="col-xl-6">
                                <div class="blog-left">
                                    <a href="#"><img src="/assets/images/blog/{{ $blog->image }}"
                                            class="img-fluid blur-up lazyload bg-img" alt=""></a>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="blog-right">
                                    <div>
                                        <h6>{{ date('d-m-Y', strtotime($blog->date)) }}</h6><a href="{{ route('blog.showblog', $blog->slug) }}">
                                            <h4>{{ Str::substr($blog->title, 0, 50) }}</h4>
                                        </a>
                                        <ul class="post-social">
                                            <li>Tarafından : {{ $blog->posted_by }}</li>
                                            <li><i class="fa fa-heart"></i>
                                            @if (count(json_decode($blog->hits, true)))
                                                {{ count(json_decode($blog->hits, true)) }}
                                            @else
                                            0
                                            @endif
                                            Tıklama</li>
                                            <li><i class="fa fa-comments"></i>
                                                @if ($blog->comments != null && count(json_decode($blog->comments, true)))
                                                    {{ count(json_decode($blog->comments, true)) }}
                                                @else
                                                0
                                                @endif
                                                Yorum</li>
                                        </ul>
                                        <p>{{ Str::substr(strip_tags($blog->content), 0, 150) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif

                    {!!  $blogs->links('parts/pagination') !!}
                </div>
                <!--Blog List start-->
            </div>
        </div>
    </section>
    <!-- Section ends -->
@endsection
