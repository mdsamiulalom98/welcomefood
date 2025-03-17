@extends('frontEnd.layouts.master')
@section('title', $generalsetting->meta_title)
@push('seo')
    <meta name="app-url" content="" />
    <meta name="robots" content="index, follow" />
    <meta name="description" content="{{ $generalsetting->meta_description }}" />
    <meta name="keywords" content="{{ $generalsetting->meta_keyword }}" />
    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $generalsetting->meta_title }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="{{ asset($generalsetting->white_logo) }}" />
    <meta property="og:description" content="{{ $generalsetting->meta_description }}" />
@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('public/frontEnd/css/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/frontEnd/css/owl.theme.default.min.css') }}" />
@endpush
@section('content')
    <section class="slider-section">
        <div class="home-slider-container">
            <div class="main_slider owl-carousel">
                @foreach ($sliders as $key => $value)
                    <div class="slider-item">
                        <a href="{{ $value->link }}">
                            <img src="{{ asset($value->image) }}" alt="" />
                        </a>
                    </div>
                    <!-- slider item -->
                @endforeach
            </div>
        </div>
    </section>

    <section class="home-foods-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-9">
                    <div class="best-food-section section-padding">
                        <div class="">
                            <div class="">
                                <div class="">
                                    <div class="section-title">
                                        <h3><img src="{{ asset('public/frontEnd/') }}/images/titleIcon.svg" alt="user-img"
                                                class="rounded-circle avatar-md" />
                                            <a>Best Foods</a>
                                            <img src="{{ asset('public/frontEnd/') }}/images/titleIcon.svg" alt="user-img"
                                                class="rounded-circle avatar-md" />
                                        </h3>
                                        <span class="category-subtitle">Popular Food Items</span>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="product_sliders owl-carousel">
                                        @foreach ($hotdeal_top as $key => $value)
                                            <div class="product_item wist_item">
                                                @include('frontEnd.layouts.partials.product')
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="menu-tab-section section-padding">
                        <div class="">
                            <div class="">
                                <div class="">
                                    <div class="section-title">
                                        <h3><img src="{{ asset('public/frontEnd/') }}/images/titleIcon.svg" alt="user-img"
                                                class="rounded-circle avatar-md" />
                                            <a>Menu</a>
                                            <img src="{{ asset('public/frontEnd/') }}/images/titleIcon.svg" alt="user-img"
                                                class="rounded-circle avatar-md" />
                                        </h3>
                                        <span class="category-subtitle">Our Food Menu</span>
                                    </div>
                                    <div class="menu-tab-inner">
                                        <div class="menu-nav">
                                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                                @foreach ($categories as $key => $category)
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link {{ $key == 0 ? 'active' : '' }}"
                                                            id="pills-{{ $category->slug }}-tab" data-bs-toggle="pill"
                                                            data-bs-target="#pills-{{ $category->id }}" type="button"
                                                            role="tab" aria-controls="pills-{{ $category->slug }}"
                                                            aria-selected="true">{{ $category->name }}</button>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="menu-content">
                                            <div class="tab-content" id="pills-tabContent">
                                                @foreach ($categories as $key => $category)
                                                    @php
                                                        $foods = App\Models\Food::where([
                                                            'status' => 1,
                                                            'category_id' => $category->id,
                                                        ])
                                                            ->orderBy('id', 'asc')
                                                            ->select(
                                                                'id',
                                                                'name',
                                                                'slug',
                                                                'new_price',
                                                                'old_price',
                                                                'description',
                                                                'category_id',
                                                            )
                                                            ->with('variables')
                                                            ->limit(12)
                                                            ->get();
                                                    @endphp
                                                    <div class="tab-pane fade show {{ $key == 0 ? 'active' : '' }}"
                                                        id="pills-{{ $category->id }}" role="tabpanel"
                                                        aria-labelledby="pills-{{ $category->slug }}-tab" tabindex="0">
                                                        <div class="tab-food">
                                                            <div class="tab-food-inner">
                                                                @foreach ($foods as $key => $value)
                                                                    @include('frontEnd.layouts.partials.mini_product')
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <!-- cart sidebar -->
                    <div class="mini-cart-wrapper">
                        @include('frontEnd.layouts.partials.mini_cart')
                    </div>
                    <!-- cart sidebar -->
                </div>
            </div>
        </div>
    </section>
    <section class="home-about-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="home-about">
                        <h1>How to Order</h1>
                        <h2>
                            <img src="{{ asset('public/frontEnd/images/shape.png') }}">
                            <span>Watch this video to learn how to place an order.</span>
                            <img src="{{ asset('public/frontEnd/images/shape.png') }}">
                        </h2>
                        <div class="about-video">
                            <a youtubeid="FcEVbVrNIyg" class="youtube-link">
                                <span class="play_btn"><i class="fa-solid fa-play"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="home-reivew-section">
        <img src="{{ asset('public/frontEnd/images/review-sign.png') }}" class="review-left" alt="">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <div class="section-title">
                        <h3><img src="{{ asset('public/frontEnd/') }}/images/titleIcon.svg" alt="user-img"
                                class="rounded-circle avatar-md" />
                            <a>Client Review</a>
                            <img src="{{ asset('public/frontEnd/') }}/images/titleIcon.svg" alt="user-img"
                                class="rounded-circle avatar-md" />
                        </h3>
                        <span class="category-subtitle">What say our client?</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="review-slider owl-carousel">
                        @foreach ($reviews as $key => $value)
                            <div class="client-review">
                                <h6>{{ $value->review }}</h6>
                                <img src="{{ asset('public/frontEnd/images/shape2.png') }}" alt="{{ $value->name }}">
                                <p>{{ $value->name }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <img src="{{ asset('public/frontEnd/images/review-sign.png') }}" class="review-right" alt="">
    </section>
@endsection
@push('script')
    <script src="{{ asset('public/frontEnd/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('public/frontEnd/js/jquery.syotimer.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // main slider
            $(".main_slider").owlCarousel({
                items: 1,
                loop: true,
                dots: false,
                autoplay: true,
                nav: true,
                autoplayHoverPause: false,
                margin: 0,
                mouseDrag: true,
                smartSpeed: 5000,
                autoplayTimeout: 6000,
                navText: ["<i class='fa-solid fa-angle-left'></i>",
                    "<i class='fa-solid fa-angle-right'></i>"
                ],
            });
            $(".review-slider").owlCarousel({
                items: 1,
                loop: true,
                dots: false,
                autoplay: true,
                nav: true,
                autoplayHoverPause: false,
                margin: 20,
                mouseDrag: true,
                smartSpeed: 1000,
                autoplayTimeout: 6000,
                navText: ["<i class='fa-solid fa-angle-left'></i>",
                    "<i class='fa-solid fa-angle-right'></i>"
                ],
            });

            $(".product_sliders").owlCarousel({
                margin: 10,
                items: 4,
                loop: true,
                dots: false,
                autoplay: true,
                autoplayTimeout: 6000,
                autoplayHoverPause: true,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 2,
                        nav: false,
                    },
                    600: {
                        items: 4,
                        nav: false,
                    },
                    1000: {
                        items: 4,
                        nav: false,
                    },
                },
            });
        });
    </script>
    <script>
        $("#simple_timer").syotimer({
            date: new Date(2015, 0, 1),
            layout: "hms",
            doubleNumbers: false,
            effectType: "opacity",
            periodUnit: "d",
            periodic: true,
            periodInterval: 1,
        });
    </script>
@endpush
