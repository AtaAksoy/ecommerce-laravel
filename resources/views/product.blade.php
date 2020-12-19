@extends('master')
@php
    $title = $product->name.config('app.title');
@endphp
@section('title', $title)
@section('header')

@endsection
@section('content')
    <!-- section start -->
    <section>
        <div class="collection-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        @php
                            $images = explode('|', $product->images);
                        @endphp
                        <div class="product-slick">
                            @for ($i = 0; $i < count($images); $i++)
                                <div><img src="/assets/images/products/{{ $images[$i] }}" alt=""
                                    class="img-fluid blur-up lazyload image_zoom_cls-{{$i}}"></div>
                            @endfor
                        </div>
                        <div class="row">
                            <div class="col-12 p-0">
                                <div class="slider-nav">
                                    @for ($i = 0; $i < count($images); $i++)
                                        <div><img src="/assets/images/products/{{ $images[$i] }}" alt=""
                                        class="img-fluid blur-up lazyload"></div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="product-right product-description-box">
                            <h2>{{ $product->name }}</h2>
                            <div class="border-product">
                                <h6 class="product-title">Ürün Detayı</h6>
                                {!!html_entity_decode($product->description)!!}
                            </div>
                            <div class="border-product">
                                <h6 class="product-title">100% GÜVENLİ ÖDEME</h6>
                                <div class="payment-card-bottom">
                                    <ul>
                                        <li>
                                            <a href="#"><img src="../assets/images/icon/visa.png" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="../assets/images/icon/mastercard.png" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="../assets/images/icon/paypal.png" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="../assets/images/icon/american-express.png"
                                                    alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="../assets/images/icon/discover.png" alt=""></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="product-right product-form-box">
                            @php
                                $categoryDiscount = \App\Models\Discount::where('category_id', $category->id)->where('state', 1)->first();
                                $productDiscount = \App\Models\Discount::where('product_id', $product->id)->where('state', 1)->first();
                            @endphp
                            @if (isset($productDiscount))
                                @switch($productDiscount->type)
                                    @case('percent')
                                        <h4><del>{{ $product->price }}</del><span>{{ $productDiscount->value }}%</span></h4>
                                        <h3>{{ ($product->price - ( ($productDiscount->value / 100) * $product->price )) }}</h3>
                                        @break
                                    @case('quantity')
                                        <h4><del>{{ $product->price }}</del><span>{{ $productDiscount->value }}₺</span></h4>
                                        <h3>{{ ( $product->price - $productDiscount->value ) }}</h3>
                                        @break
                                    @default
                                        <h4><del>{{ $product->price }}</del><span>{{ $productDiscount->value }}%</span></h4>
                                        <h3>{{ ($product->price - ( ($productDiscount->value / 100) * $product->price )) }}</h3>
                                @endswitch
                            @else
                                @if (isset($categoryDiscount))
                                    @switch($categoryDiscount->type)
                                        @case('percent')
                                            <h4><del>{{ $product->price }}₺</del><span>{{ $categoryDiscount->value }}%</span></h4>
                                            <h3>{{ ($product->price - ( ($categoryDiscount->value / 100) * $product->price )) }}₺</h3>
                                            @break
                                        @case('quantity')
                                            <h4><del>{{ $product->price }}₺</del><span>-{{ $categoryDiscount->value }}₺</span></h4>
                                            <h3>{{ ( $product->price - $categoryDiscount->value ) }}₺</h3>
                                            @break
                                        @default
                                            <h4><del>{{ $product->price }}₺</del><span>{{ $categoryDiscount->value }}%</span></h4>
                                            <h3>{{ ($product->price - ( ($productDiscount->value / 100) * $product->price )) }}₺</h3>
                                    @endswitch
                                @else
                                    <h3>{{ $product->price }}₺</h3>
                                @endif
                            @endif
                            <div class="product-description border-product">
                                <form action="" method="POST">
                                    @csrf
                                    <ul class="color-variant">
                                        @php
                                            $features = json_decode($product->features);
                                            $colors = json_decode($features->colors);
                                            $sizes = json_decode($features->size);
                                        @endphp
                                        <h6 class="product-title">Renk Seçimi</h6>
                                        <select name="color" class="form-control">
                                            @for ($i = 0; $i < count($colors); $i++)
                                                <option name = "{{ $colors[$i] }}">{{ $colors[$i] }}</option>
                                            @endfor
                                        </select>
                                    </ul>
                                    <h6 class="product-title">Beden Seçimi</h6>
                                    <div class="size-box">
                                        <input type="hidden" name="code" value="{{ $product->code }}" style="display: none">
                                        <select name="size" class="form-control">
                                            @for ($i = 0; $i < count($sizes); $i++)
                                                <option name = "{{ $sizes[$i] }}">{{ $sizes[$i] }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <h6 class="product-title">Adet</h6>
                                    <div class="qty-box">
                                        <div class="input-group"><span class="input-group-prepend"><button type="button"
                                                    class="btn quantity-left-minus" data-type="minus" data-field=""><i
                                                        class="ti-angle-left"></i></button> </span>
                                            <input type="text" name="quantity" class="form-control input-number" value="1">
                                            <span class="input-group-prepend"><button type="button"
                                                    class="btn quantity-right-plus" data-type="plus" data-field=""><i
                                                        class="ti-angle-right"></i></button></span></div>
                                    </div>
                                    <div class="product-buttons">
                                        @if ($product->stock > 0)
                                        <button type="submit" name="add_to_cart"
                                        class="btn btn-solid">sepete ekle</button>
                                        @else
                                        <button type="reset"
                                        class="btn btn-danger">stokta yok</button>
                                        @endif
                                        <button style="margin-top: 15px" type="submit" name="add_to_wishlist"
                                        class="btn btn-solid">istek listesine ekle</button>
                                    </div>
                                </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section ends -->

    <!-- product-tab starts -->
    <section class="tab-product m-0">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-toggle="tab"
                                href="#top-home" role="tab" aria-selected="true">Açıklama</a>
                            <div class="material-border"></div>
                        </li>
                        <li class="nav-item"><a class="nav-link" id="profile-top-tab" data-toggle="tab"
                                href="#top-profile" role="tab" aria-selected="false">Yorumlar</a>
                            <div class="material-border"></div>
                        </li>
                        <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-toggle="tab"
                                href="#top-contact" role="tab" aria-selected="false">Video</a>
                            <div class="material-border"></div>
                        </li>
                        <li class="nav-item"><a class="nav-link" id="review-top-tab" data-toggle="tab"
                                href="#top-review" role="tab" aria-selected="false">Yorum Yap</a>
                            <div class="material-border"></div>
                        </li>
                    </ul>
                    <div class="tab-content nav-material" id="top-tabContent">
                        <div class="tab-pane fade show active" id="top-home" role="tabpanel"
                            aria-labelledby="top-home-tab">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                has been the industry's standard dummy text ever since the 1500s, when an unknown
                                printer took a galley of type and scrambled it to make a type specimen book. It has
                                survived not only five centuries, but also the leap into electronic typesetting,
                                remaining essentially unchanged. It was popularised in the 1960s with the release of
                                Letraset sheets containing Lorem Ipsum passages, and more recently with desktop
                                publishing software like Aldus PageMaker including versions of Lorem Ipsum. Lorem Ipsum
                                is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                                industry's standard dummy text ever since the 1500s, when an unknown printer took a
                                galley of type and scrambled it to make a type specimen book. It has survived not only
                                five centuries, but also the leap into electronic typesetting, remaining essentially
                                unchanged. It was popularised in the 1960s with the release of Letraset sheets
                                containing Lorem Ipsum passages, and more recently with desktop publishing software like
                                Aldus PageMaker including versions of Lorem Ipsum.</p>
                        </div>
                        <div class="tab-pane fade" id="top-profile" role="tabpanel" aria-labelledby="profile-top-tab">
                            <section class="section-b-space blog-detail-page review-page">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <ul class="comment-section">
                                                @if ($reviews != null)
                                                    @foreach ($reviews as $review)
                                                    <li>
                                                        <div class="media">
                                                            <div class="media-body">
                                                                <h6>{{ Str::substr($review->name, 0, 2) }}**** ****** <span>( {{ date('d-m-Y', strtotime($review->date)) }} )</span></h6>
                                                                <p>{!! $review->comment !!}</p>
                                                                <ul class="comnt-sec">
                                                                    <li><a href="#"><i class="fa fa-thumbs-o-up"
                                                                                aria-hidden="true"></i><span>(14)</span></a></li>
                                                                    <li><a href="#">
                                                                            <div class="unlike"><i class="fa fa-thumbs-o-down"
                                                                                    aria-hidden="true"></i>(2)</div>
                                                                        </a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="tab-pane fade" id="top-contact" role="tabpanel" aria-labelledby="contact-top-tab">
                            <div class="mt-4 text-center">
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/BUWzX78Ye_8"
                                    allow="autoplay; encrypted-media" allowfullscreen></iframe>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="top-review" role="tabpanel" aria-labelledby="review-top-tab">
                            <form class="theme-form" method="POST" action="/{{ Request::path() }}/degerlendirme">
                                @csrf
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="media">
                                            <label>Oylama</label>
                                            <div class="media-body ml-3">
                                                <select name="rate" class="form-control" id="">
                                                    <option value="5" selected>5 Yıldız</option>
                                                    <option value="4">4 Yıldız</option>
                                                    <option value="3">3 Yıldız</option>
                                                    <option value="2">2 Yıldız</option>
                                                    <option value="1">1 Yıldız</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="name">İsim</label>
                                        <input type="text" name="name" class="form-control" id="name" placeholder="*Gizlenmiş bir şekilde gözükecektir."
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email">E-Posta</label>
                                        <input type="text" name="email" class="form-control" id="email" placeholder="Gözükmez" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="review">Değerlendirme Başlığı</label>
                                        <input type="text" class="form-control" name="rev_title" id="review"
                                            placeholder="" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="review">Değerlendirme İçerik</label>
                                        <textarea class="form-control" name="rev_comment" placeholder="Ürün hakkındaki görüşlerinizi yazabilirsiniz."
                                            id="exampleFormControlTextarea1" rows="6"></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <button name="make_review" class="btn btn-solid" type="submit">Değerlendirmeyi Gönder</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product-tab ends -->


    <!-- product section start -->
    <section class="section-b-space ratio_asos">
        <div class="container">
            <div class="row">
                <div class="col-12 product-related">
                    <h2>related products</h2>
                </div>
            </div>
            <div class="row search-product">
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="product-box">
                        <div class="img-wrapper">
                            <div class="front">
                                <a href="#"><img src="../assets/images/pro3/33.jpg"
                                        class="img-fluid blur-up lazyload bg-img" alt=""></a>
                            </div>
                            <div class="back">
                                <a href="#"><img src="../assets/images/pro3/34.jpg"
                                        class="img-fluid blur-up lazyload bg-img" alt=""></a>
                            </div>
                            <div class="cart-info cart-wrap">
                                <button data-toggle="modal" data-target="#addtocart" title="Add to cart"><i
                                        class="ti-shopping-cart"></i></button> <a href="javascript:void(0)"
                                    title="Add to Wishlist"><i class="ti-heart" aria-hidden="true"></i></a> <a href="#"
                                    data-toggle="modal" data-target="#quick-view" title="Quick View"><i
                                        class="ti-search" aria-hidden="true"></i></a> <a href="compare.html"
                                    title="Compare"><i class="ti-reload" aria-hidden="true"></i></a></div>
                        </div>
                        <div class="product-detail">
                            <div class="rating"><i class="fa fa-star"></i> <i class="fa fa-star"></i> <i
                                    class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i></div>
                            <a href="product-page(no-sidebar).html">
                                <h6>Slim Fit Cotton Shirt</h6>
                            </a>
                            <h4>$500.00</h4>
                            <ul class="color-variant">
                                <li class="bg-light0"></li>
                                <li class="bg-light1"></li>
                                <li class="bg-light2"></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="product-box">
                        <div class="img-wrapper">
                            <div class="front">
                                <a href="#"><img src="../assets/images/pro3/1.jpg"
                                        class="img-fluid blur-up lazyload bg-img" alt=""></a>
                            </div>
                            <div class="back">
                                <a href="#"><img src="../assets/images/pro3/2.jpg"
                                        class="img-fluid blur-up lazyload bg-img" alt=""></a>
                            </div>
                            <div class="cart-info cart-wrap">
                                <button data-toggle="modal" data-target="#addtocart" title="Add to cart"><i
                                        class="ti-shopping-cart"></i></button> <a href="javascript:void(0)"
                                    title="Add to Wishlist"><i class="ti-heart" aria-hidden="true"></i></a> <a href="#"
                                    data-toggle="modal" data-target="#quick-view" title="Quick View"><i
                                        class="ti-search" aria-hidden="true"></i></a> <a href="compare.html"
                                    title="Compare"><i class="ti-reload" aria-hidden="true"></i></a></div>
                        </div>
                        <div class="product-detail">
                            <div class="rating"><i class="fa fa-star"></i> <i class="fa fa-star"></i> <i
                                    class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i></div>
                            <a href="product-page(no-sidebar).html">
                                <h6>Slim Fit Cotton Shirt</h6>
                            </a>
                            <h4>$500.00</h4>
                            <ul class="color-variant">
                                <li class="bg-light0"></li>
                                <li class="bg-light1"></li>
                                <li class="bg-light2"></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="product-box">
                        <div class="img-wrapper">
                            <div class="front">
                                <a href="#"><img src="../assets/images/pro3/27.jpg"
                                        class="img-fluid blur-up lazyload bg-img" alt=""></a>
                            </div>
                            <div class="back">
                                <a href="#"><img src="../assets/images/pro3/28.jpg"
                                        class="img-fluid blur-up lazyload bg-img" alt=""></a>
                            </div>
                            <div class="cart-info cart-wrap">
                                <button data-toggle="modal" data-target="#addtocart" title="Add to cart"><i
                                        class="ti-shopping-cart"></i></button> <a href="javascript:void(0)"
                                    title="Add to Wishlist"><i class="ti-heart" aria-hidden="true"></i></a> <a href="#"
                                    data-toggle="modal" data-target="#quick-view" title="Quick View"><i
                                        class="ti-search" aria-hidden="true"></i></a> <a href="compare.html"
                                    title="Compare"><i class="ti-reload" aria-hidden="true"></i></a></div>
                        </div>
                        <div class="product-detail">
                            <div class="rating"><i class="fa fa-star"></i> <i class="fa fa-star"></i> <i
                                    class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i></div>
                            <a href="product-page(no-sidebar).html">
                                <h6>Slim Fit Cotton Shirt</h6>
                            </a>
                            <h4>$500.00</h4>
                            <ul class="color-variant">
                                <li class="bg-light0"></li>
                                <li class="bg-light1"></li>
                                <li class="bg-light2"></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="product-box">
                        <div class="img-wrapper">
                            <div class="front">
                                <a href="#"><img src="../assets/images/pro3/35.jpg"
                                        class="img-fluid blur-up lazyload bg-img" alt=""></a>
                            </div>
                            <div class="back">
                                <a href="#"><img src="../assets/images/pro3/36.jpg"
                                        class="img-fluid blur-up lazyload bg-img" alt=""></a>
                            </div>
                            <div class="cart-info cart-wrap">
                                <button data-toggle="modal" data-target="#addtocart" title="Add to cart"><i
                                        class="ti-shopping-cart"></i></button> <a href="javascript:void(0)"
                                    title="Add to Wishlist"><i class="ti-heart" aria-hidden="true"></i></a> <a href="#"
                                    data-toggle="modal" data-target="#quick-view" title="Quick View"><i
                                        class="ti-search" aria-hidden="true"></i></a> <a href="compare.html"
                                    title="Compare"><i class="ti-reload" aria-hidden="true"></i></a></div>
                        </div>
                        <div class="product-detail">
                            <div class="rating"><i class="fa fa-star"></i> <i class="fa fa-star"></i> <i
                                    class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i></div>
                            <a href="product-page(no-sidebar).html">
                                <h6>Slim Fit Cotton Shirt</h6>
                            </a>
                            <h4>$500.00</h4>
                            <ul class="color-variant">
                                <li class="bg-light0"></li>
                                <li class="bg-light1"></li>
                                <li class="bg-light2"></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="product-box">
                        <div class="img-wrapper">
                            <div class="front">
                                <a href="#"><img src="../assets/images/pro3/2.jpg"
                                        class="img-fluid blur-up lazyload bg-img" alt=""></a>
                            </div>
                            <div class="back">
                                <a href="#"><img src="../assets/images/pro3/1.jpg"
                                        class="img-fluid blur-up lazyload bg-img" alt=""></a>
                            </div>
                            <div class="cart-info cart-wrap">
                                <button data-toggle="modal" data-target="#addtocart" title="Add to cart"><i
                                        class="ti-shopping-cart"></i></button> <a href="javascript:void(0)"
                                    title="Add to Wishlist"><i class="ti-heart" aria-hidden="true"></i></a> <a href="#"
                                    data-toggle="modal" data-target="#quick-view" title="Quick View"><i
                                        class="ti-search" aria-hidden="true"></i></a> <a href="compare.html"
                                    title="Compare"><i class="ti-reload" aria-hidden="true"></i></a></div>
                        </div>
                        <div class="product-detail">
                            <div class="rating"><i class="fa fa-star"></i> <i class="fa fa-star"></i> <i
                                    class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i></div>
                            <a href="product-page(no-sidebar).html">
                                <h6>Slim Fit Cotton Shirt</h6>
                            </a>
                            <h4>$500.00</h4>
                            <ul class="color-variant">
                                <li class="bg-light0"></li>
                                <li class="bg-light1"></li>
                                <li class="bg-light2"></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="product-box">
                        <div class="img-wrapper">
                            <div class="front">
                                <a href="#"><img src="../assets/images/pro3/28.jpg"
                                        class="img-fluid blur-up lazyload bg-img" alt=""></a>
                            </div>
                            <div class="back">
                                <a href="#"><img src="../assets/images/pro3/27.jpg"
                                        class="img-fluid blur-up lazyload bg-img" alt=""></a>
                            </div>
                            <div class="cart-info cart-wrap">
                                <button data-toggle="modal" data-target="#addtocart" title="Add to cart"><i
                                        class="ti-shopping-cart"></i></button> <a href="javascript:void(0)"
                                    title="Add to Wishlist"><i class="ti-heart" aria-hidden="true"></i></a> <a href="#"
                                    data-toggle="modal" data-target="#quick-view" title="Quick View"><i
                                        class="ti-search" aria-hidden="true"></i></a> <a href="compare.html"
                                    title="Compare"><i class="ti-reload" aria-hidden="true"></i></a></div>
                        </div>
                        <div class="product-detail">
                            <div class="rating"><i class="fa fa-star"></i> <i class="fa fa-star"></i> <i
                                    class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i></div>
                            <a href="product-page(no-sidebar).html">
                                <h6>Slim Fit Cotton Shirt</h6>
                            </a>
                            <h4>$500.00</h4>
                            <ul class="color-variant">
                                <li class="bg-light0"></li>
                                <li class="bg-light1"></li>
                                <li class="bg-light2"></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product section end -->
@endsection
@section('footer')
@endsection
