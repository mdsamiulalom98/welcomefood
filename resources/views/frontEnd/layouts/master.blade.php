<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title') - {{ $generalsetting->name }}</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset($generalsetting->favicon) }}" alt="Websolution IT" />
    <meta name="author" content="Websolution IT" />
    <link rel="canonical" href="" />
    @stack('seo') @stack('css')
    <link rel="stylesheet" href="{{ asset('public/frontEnd/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/frontEnd/css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/frontEnd/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/frontEnd/css/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/frontEnd/css/owl.theme.default.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/frontEnd/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/frontEnd/css/grt-youtube-popup.css') }}" />
    <!-- toastr css -->
    <link rel="stylesheet" href="{{ asset('public/backEnd/') }}/assets/css/toastr.min.css" />
    <link rel="stylesheet" href="{{ asset('public/frontEnd/css/style.css?v=1.0.2') }}" />
    <link rel="stylesheet" href="{{ asset('public/frontEnd/css/responsive.css?v=1.0.2') }}" />
    <script src="{{ asset('public/frontEnd/js/jquery-3.7.1.min.js') }}"></script>
    @include('frontEnd.layouts.partials.header_part')
</head>

<body class="gotop">
    @if ($coupon)
        <div class="coupon-section alert alert-dismissible fade show">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="coupon-code">
                            <p>Get {{ $coupon->amount }} {{ $coupon->type == 1 ? '%' : 'Tk' }} Discount use the
                                coupon code <span id="couponCode">{{ $coupon->coupon_code }}</span>
                                <button onclick="copyCouponCode()"> <i class="fas fa-copy"></i>
                                </button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="mobile-menu">
        <div class="mobile-menu-logo">
            <div class="logo-image">
                <img src="{{ asset($generalsetting->white_logo) }}" alt="" />
            </div>
            <div class="mobile-menu-close">
                <i class="fa fa-times"></i>
            </div>
        </div>
        <ul class="mobile-menu-auth">
            @if (Auth::guard('customer')->user())
                <li>
                    <a href="{{ route('customer.account') }}" class="account_btn">
                        <i class="fa-regular fa-user"></i> Account
                    </a>
                </li>
            @else
                <li>
                    <a href="{{ route('customer.login') }}" class="account_btn">
                        <i class="fa-regular fa-user"></i> Sign In
                    </a>
                </li>
            @endif
        </ul>
        <ul class="first-nav">
            @foreach ($categories as $scategory)
                <li class="parent-category">
                    <a href="{{ route('category', $scategory->slug) }}" class="menu-category-name">
                        <img src="{{ asset($scategory->image) }}" alt="" class="side_cat_img" />
                        {{ $scategory->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <header id="navbar_top">
        <div class="mobile-header">
            <div class="mobile-bar">
                <a class="toggle">
                    <i class="fa-solid fa-bars"></i>
                </a>
            </div>
            <div class="mobile-logo">
                <a href="{{ route('home') }}"> <img src="{{ asset($generalsetting->dark_logo) }}"
                        alt="" /></a>
            </div>
            <div class="search-mobile"><a class="search_toggle"><i class="fas fa-search"></i></a></div>
            <div class="mobile-cart">
                <a class="cart-toggle">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="cart_count">{{ Cart::instance('shopping')->count() }}</span>
                </a>
            </div>
        </div>
        <div class="mobile-search">
            <form action="{{ route('search') }}">
                <input type="text" placeholder="Search Product..." name="keyword" />
                <button><i class="fa-solid fa-search"></i></button>
            </form>
        </div>
        <!-- mobile header end -->


        <!-- main header start -->
        <div class="main-header">
            <div class="logo-area">
                <div class="header-top">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="header-left">
                                    <ul>
                                        <li><a href=""><i class="fa-solid fa-clock"></i> 09:00 am - 10:00 pm</a>
                                        </li>
                                        <li><a href=""><i class="fa-solid fa-phone"></i>
                                                {{ $contact->hotline }}</a></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- col-6 end -->
                            <div class="col-sm-6">
                                <div class="header-right">
                                    <ul>
                                        <li>Follow Us :</li>
                                        @foreach ($socialicons as $key => $sicon)
                                            <li><a href="{{ $sicon->link }}"><i
                                                        class="{{ $sicon->icon }}"></i></a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <!-- col-6 end -->
                        </div>
                    </div>
                </div>
                <!-- header top end -->
                <div class="menu-area">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="logo-header">
                                    <div class="main-logo">
                                        <a href="{{ route('home') }}"><img
                                                src="{{ asset($generalsetting->dark_logo) }}" alt="" /></a>
                                    </div>
                                    <div class="main-menu">
                                        <ul>
                                            @foreach ($categories as $category)
                                                <li>
                                                    <a href="{{ route('category', $category->slug) }}">
                                                        {{ $category->name }}
                                                        @if ($category->subcategories->count() > 0)
                                                            <i class="fa-solid fa-plus"></i>
                                                        @endif
                                                    </a>
                                                    @if ($category->subcategories->count() > 0)
                                                        <div class="mega_menu">
                                                            @foreach ($category->subcategories as $subcat)
                                                                <ul>
                                                                    <li>
                                                                        <a href="{{ route('subcategory', $subcat->slug) }}"
                                                                            class="cat-title">
                                                                            {{ Str::limit($subcat->name, 25) }}
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="header-btns">
                                        <ul>
                                            <li>
                                                <a class="cart_icon search_toggle">
                                                    <i class="fa-solid fa-search"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="cart_icon cart-toggle">
                                                    <i class="fa-solid fa-cart-shopping"></i>
                                                    <span
                                                        class="cart_count">{{ Cart::instance('shopping')->count() }}</span>

                                                </a>
                                            </li>

                                            @if (Auth::guard('customer')->user())
                                                <li>
                                                    <a href="{{ route('customer.account') }}" class="account_btn">
                                                        <i class="fa-regular fa-user"></i> Account
                                                    </a>
                                                </li>
                                            @else
                                                <li>
                                                    <a href="{{ route('customer.login') }}" class="account_btn">
                                                        <i class="fa-regular fa-user"></i> Sign In
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="main-search">
                                        <form action="{{ route('search') }}">
                                            <input type="text" placeholder="Search Product..." class="search_click search_keyword" name="keyword" />
                                            <button><i class="fa-solid fa-search"></i></button>
                                        </form>
                                        <div class="search_result"></div>
                                    </div>
                                    <!-- mobile header end -->
                                </div>
                            </div>
                            <!-- col-12 end -->
                        </div>
                    </div>
                    <!-- menu area end -->
                </div>
            </div>
            <!-- logo area end -->


        </div>
        <!-- main-header end -->
    </header>
    <div id="content">
        @yield('content')
    </div>
    <!-- content end -->
    <footer>
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="footer-about">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset($generalsetting->dark_logo) }}" alt="" />
                            </a>
                            <p>{{ $contact->address }}</p>
                        </div>
                        <div class="footer-menu">
                            <ul class="social_link">
                                @foreach ($socialicons as $value)
                                    <li>
                                        <a href="{{ $value->link }}"><i class="{{ $value->icon }}"></i></a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- col end -->
                    <div class="col-sm-4">
                        <div class="footer-menu">
                            <ul>
                                <li class="title "><a>Hot Category</a></li>
                                @foreach ($categories as $category)
                                    <li><a href="{{ route('category', $category->slug) }}"> <i
                                                class="fa-solid fa-caret-right"></i> {{ $category->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- col end -->
                    <div class="col-sm-4">
                        <div class="footer-menu">
                            <ul>
                                <li class="title "><a>Useful Link</a></li>
                                @foreach ($pages as $page)
                                    <li><a
                                            href="{{ route('page', ['slug' => $page->slug]) }}">{{ $page->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- col end -->
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="copyright">
                            <p class="border-copyright"></p>
                            <p>Copyright © {{ date('Y') }} {{ $generalsetting->name }}. All rights reserved By
                                {{ $generalsetting->name }}</p>
                            <p class="border-copyright"></p>
                        </div>
                    </div>
                </div>
            </div>
            <ul>
                <li class="fshape-left"><img src="{{ asset('public/frontEnd/images/footer_shape01.png') }}"
                        alt=""></li>
                <li class="fshape-middle"><img src="{{ asset('public/frontEnd/images/footer_shape02.png') }}"
                        alt=""></li>
                <li class="fshape-right"><img src="{{ asset('public/frontEnd/images/footer_shape03.png') }}"
                        alt=""></li>
            </ul>
        </div>
    </footer>
    <!--=====-->
    <div class="fixed_whats">
        <a href="https://api.whatsapp.com/send?phone={{ $contact->whatsapp }}" target="_blank"><i
                class="fa-brands fa-whatsapp"></i></a>
    </div>

    <div class="scrolltop" style="">
        <div class="scroll">
            <i class="fa fa-angle-up"></i>
        </div>
    </div>


    <!-- product modal -->
    <form>
        <div class="modal fade" id="quickview_modal" tabindex="-1" aria-labelledby="quickview_modal"
            aria-hidden="true">
            <div class="modal-dialog  modal-dialog-scrollable">
                <div class="modal-content" id="quick_modal_details">

                </div>
            </div>
        </div>
        <!-- task all modal end -->
    </form>

    <!-- cart sidebar -->
    {{-- <div class="mini-cart-wrapper">
        @include('frontEnd.layouts.partials.mini_cart')
    </div> --}}
    <!-- cart sidebar -->

    <script src="{{ asset('public/frontEnd/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/frontEnd/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('public/frontEnd/js/wow.min.js') }}"></script>
    <script src="{{ asset('public/frontEnd/js/grt-youtube-popup.js') }}"></script>
    <script src="{{ asset('public/frontEnd/js/script.js') }}"></script>
    <script>
        new WOW().init();
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="{{ asset('public/backEnd/') }}/assets/js/toastr.min.js"></script>
    {!! Toastr::message() !!} @stack('script')
    <script>
        $(document).on("click", ".quick_view", function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                type: "GET",
                data: {
                    id: id
                },
                url: "{{ route('product.quick_view') }}",
                success: function(data) {
                    if (data) {
                        $("#quick_modal_details").html(data);
                    }
                }
            });
        });
    </script>
    <script>
        $(".search_click").on("keyup change", function() {
            var keyword = $(".search_keyword").val();
            $.ajax({
                type: "GET",
                data: {
                    keyword: keyword
                },
                url: "{{ route('livesearch') }}",
                success: function(products) {
                    if (products) {
                        $(".search_result").html(products);
                    } else {
                        $(".search_result").empty();
                    }
                },
            });
        });
        $(".msearch_click").on("keyup change", function() {
            var keyword = $(".msearch_keyword").val();
            $.ajax({
                type: "GET",
                data: {
                    keyword: keyword
                },
                url: "{{ route('livesearch') }}",
                success: function(products) {
                    if (products) {
                        $("#loading").hide();
                        $(".search_result").html(products);
                    } else {
                        $(".search_result").empty();
                    }
                },
            });
        });
    </script>

    <!-- cart js start -->
    <script>
        $(".cart_store").on("click", function() {
            var id = $(this).data("id");
            var qty = $(this).parent().find("input").val();
            var redirect = $(this).data("redirect");
            if (id) {
                $.ajax({
                    type: "GET",
                    data: {
                        id: id,
                        qty: qty ? qty : 1,
                        redirect: redirect
                    },
                    url: "{{ route('cart.store') }}",
                    success: function(response) {
                        if (response) {
                            toastr.success("Success", "Food add to cart successfully");
                            cart_count();
                            mini_cart();
                            cart_summary();
                        }
                        if (response.redirect == 'order_now') {
                            window.location.href = "{{ route('customer.checkout') }}";
                        }
                    },
                });
            }
        });

        $(".cart_remove").on("click", function() {
            var id = $(this).data("id");
            if (id) {
                $.ajax({
                    type: "GET",
                    data: {
                        id: id
                    },
                    url: "{{ route('cart.remove') }}",
                    success: function(data) {
                        if (data) {
                            cart_count();
                            mini_cart();
                            cart_summary();
                        }
                    },
                });
            }
        });

        $(".cart_increment").on("click", function() {
            var id = $(this).data("id");
            if (id) {
                $.ajax({
                    type: "GET",
                    data: {
                        id: id
                    },
                    url: "{{ route('cart.increment') }}",
                    success: function(data) {
                        if (data) {
                            cart_count();
                            mini_cart();
                            cart_summary();
                        }
                    },
                });
            }
        });

        $(".cart_decrement").on("click", function() {
            var id = $(this).data("id");
            if (id) {
                $.ajax({
                    type: "GET",
                    data: {
                        id: id
                    },
                    url: "{{ route('cart.decrement') }}",
                    success: function(data) {
                        if (data) {
                            cart_count();
                            mini_cart();
                            cart_summary();
                        }
                    },
                });
            }
        });

        function cart_count() {
            $.ajax({
                type: "GET",
                url: "{{ route('cart.count') }}",
                success: function(data) {
                    if (data) {
                        $(".cart_count").html(data);
                    } else {
                        $(".cart_count").empty();
                    }
                },
            });
        }

        function mini_cart() {
            $.ajax({
                type: "GET",
                url: "{{ route('mini.cart') }}",
                dataType: "html",
                success: function(data) {
                    $(".mini-cart-wrapper").html(data);
                },
            });
        }

        function cart_summary() {
            $.ajax({
                type: "GET",
                url: "{{ route('cart.summary') }}",
                dataType: "html",
                success: function(data) {
                    $(".cart_list").html(data);
                },
            });
        }
        $(".wishlist_store").on("click", function() {
            var id = $(this).data("id");
            if (id) {
                $.ajax({
                    type: "GET",
                    data: {
                        id: id
                    },
                    url: "{{ route('wishlist.store') }}",
                    success: function(data) {
                        if (data) {
                            toastr.success("Success", "Food add to wishlist successfully");
                        }
                    },
                });
            }
        });
    </script>
    <!-- cart js end -->
    <script>
        $(".youtube-link").grtyoutube({
            autoPlay: true,
            theme: "dark",
        });
    </script>
    <script>
        $(".toggle").on("click", function() {
            $("#page-overlay").show();
            $(".mobile-menu").addClass("active");
        });

        $(".mobile-menu-close").on("click", function() {
            $("#page-overlay").hide();
            $(".mobile-menu").removeClass("active");
        });

        $(".cart-toggle").on("click", function() {
            $(".mini-cart-wrapper").addClass("active");
        });

        $(".quick_view").on("click", function() {
            $(".mini-cart-wrapper").removeClass("active");
        });

        $(document).on('click', '.mini-close-button', function(e) {
            $(".mini-cart-wrapper").removeClass("active");
        });

        $(".search_toggle").on("click", function() {
            if ($(".mobile-search").hasClass("active")) {
                $(".mobile-search").removeClass("active");
            } else {
                $(".mobile-search").addClass("active");
            }

            if ($(".main-search").hasClass("active")) {
                $(".main-search").removeClass("active");
            } else {
                $(".main-search").addClass("active");
            }
        });


        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 100) {
                $('.menu-area').addClass('fixed-top');
                $('.mobile-menu').addClass('fixed-top');
                $('.mobile-header').addClass('fixed-top');
            } else {
                $('.menu-area').removeClass('fixed-top');
                $('.mobile-menu').removeClass('fixed-top');
                $('.mobile-header').removeClass('fixed-top');
            }
        });
    </script>

</body>

</html>
