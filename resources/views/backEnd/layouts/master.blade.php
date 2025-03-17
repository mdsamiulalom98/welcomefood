<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />

    <title>@yield('title') - {{ $generalsetting->name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset($generalsetting->favicon) }}" />

    <!-- Bootstrap css -->
    <link href="{{ asset('public/backEnd/') }}/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href="{{ asset('public/backEnd/') }}/assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- icons -->
    <link href="{{ asset('public/backEnd/') }}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- toastr css -->
    <link rel="stylesheet" href="{{ asset('public/backEnd/') }}/assets/css/toastr.min.css" />
    <!-- custom css -->
    <link href="{{ asset('public/backEnd/') }}/assets/css/custom.css" rel="stylesheet" type="text/css" />
    <!-- Head js -->
    @yield('css')
    <script src="{{ asset('public/backEnd/') }}/assets/js/head.js"></script>
</head>

<!-- body start -->

<body data-layout-mode="default" data-theme="light" data-layout-width="fluid" data-topbar-color="dark"
    data-menu-position="fixed" data-leftbar-color="light" data-leftbar-size="default" data-sidebar-user="false">
    <!-- Begin page -->
    <div id="wrapper">
        <!-- Topbar Start -->
        <div class="navbar-custom">
            <div class="container-fluid">
                <ul class="list-unstyled topnav-menu float-end mb-0">
                    <li class="dropdown d-inline-block d-lg-none">
                        <a  href="{{route('admin.order.create')}}" class="nav-link dropdown-toggle arrow-none waves-effect waves-light">
                            <i class="fe-shopping-cart noti-icon"></i>
                        </a>
                    </li>

                    <li class="dropdown d-none d-lg-inline-block">
                        <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="fullscreen"
                            href="#">
                            <i class="fe-maximize noti-icon"></i>
                        </a>
                    </li>

                    <li class="dropdown notification-list topbar-dropdown">
                        <a class="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown"
                            href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="fe-bell noti-icon"></i>
                            <span class="badge bg-danger rounded-circle noti-icon-badge">{{ $neworder }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-lg">
                            <!-- item-->
                            <div class="dropdown-item noti-title">
                                <h5 class="m-0">
                                    <span class="float-end">
                                        <a href="{{ route('admin.orders', ['slug' => 'pending']) }}" class="text-dark">
                                            <small>View All</small>
                                        </a>
                                    </span>
                                    Orders
                                </h5>
                            </div>

                            <div class="noti-scroll" data-simplebar>
                                @foreach ($pendingorder as $porder)
                                    <!-- item-->
                                    <a href="{{ route('admin.orders', ['slug' => 'pending']) }}"
                                        class="dropdown-item notify-item active">
                                        <div class="notify-icon">
                                            <img src="{{ asset($porder->customer ? $porder->customer->image : '') }}"
                                                class="img-fluid rounded-circle" alt="" />
                                        </div>
                                        <p class="notify-details">
                                            {{ $porder->customer ? $porder->customer->name : '' }}
                                        </p>
                                        <p class="text-muted mb-0 user-msg">
                                            <small>Invoice : {{ $porder->invoice_id }}</small>
                                        </p>
                                    </a>
                                @endforeach

                                <!-- item-->
                            </div>

                            <!-- All-->
                            <a href="{{ route('admin.orders', ['slug' => 'pending']) }}"
                                class="dropdown-item text-center text-primary notify-item notify-all">
                                View all
                                <i class="fe-arrow-right"></i>
                            </a>
                        </div>
                    </li>

                    <li class="dropdown notification-list topbar-dropdown">
                        <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light"
                            data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                            aria-expanded="false">
                            <img src="{{ asset(Auth::user()->image) }}" alt="user-image" class="rounded-circle" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-end profile-dropdown">
                            <!-- item-->
                            <div class="dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Welcome !</h6>
                            </div>

                            <!-- item-->
                            <a href="{{ route('dashboard') }}" class="dropdown-item notify-item">
                                <i class="fe-user"></i>
                                <span>Dashboard</span>
                            </a>

                            <!-- item-->
                            <a href="{{ route('change_password') }}" class="dropdown-item notify-item">
                                <i class="fe-settings"></i>
                                <span>Change Password</span>
                            </a>

                            <!-- item-->
                            <a href="{{ route('locked') }}" class="dropdown-item notify-item">
                                <i class="fe-lock"></i>
                                <span>Lock Screen</span>
                            </a>

                            <div class="dropdown-divider"></div>

                            <!-- item-->
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();"
                                class="dropdown-item notify-item">
                                <i class="fe-log-out me-1"></i>
                                <span>Logout</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>

                <!-- LOGO -->
                <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                    <li>
                        <button class="button-menu-mobile waves-effect waves-light">
                            <i class="fe-menu"></i>
                        </button>
                    </li>

                    <li>
                        <!-- Mobile menu toggle (Horizontal Layout)-->
                        <a class="navbar-toggle nav-link" data-bs-toggle="collapse"
                            data-bs-target="#topnav-menu-content">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </li>

                    <li class="dropdown d-none d-xl-block">
                        <a class="nav-link dropdown-toggle waves-effect waves-light " href="{{ route('home') }}"
                            target="_blank"> <span class="btn btn-success waves-effect waves-light  rounded-pill"> <i data-feather="airplay"></i> Visit Site</span> </a>
                    </li>
                    <li class="dropdown d-none d-xl-block">
                        <a class="nav-link dropdown-toggle waves-effect waves-light " href="{{ route('admin.order.create') }}"> <span class="btn btn-primary waves-effect waves-light  rounded-pill"> <i data-feather="shopping-cart"></i> POS</span> </a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
        </div>
        <!-- end Topbar -->

        <!-- ========== Left Sidebar Start ========== -->
        <div class="left-side-menu">
            <div class="h-100" data-simplebar>
                <!-- User box -->
                <div class="user-box text-center">
                    <img src="{{ asset('public/backEnd/') }}/assets/images/users/user-1.jpg" alt="user-img" class="rounded-circle avatar-md" />
                    <div class="dropdown">
                        <a href="javascript: void(0);" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block"
                            data-bs-toggle="dropdown">{{ Auth::user()->name }}</a>
                        <div class="dropdown-menu user-pro-dropdown">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-user me-1"></i>
                                <span>My Account</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-settings me-1"></i>
                                <span>Settings</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-lock me-1"></i>
                                <span>Lock Screen</span>
                            </a>

                            <!-- item-->
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                                class="dropdown-item notify-item">
                                <i class="fe-log-out me-1"></i>
                                <span>Logout</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                    <p class="text-muted">Admin Head</p>
                </div>

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <div class="main-logo">
                        <a href="{{ url('admin/dashboard') }}">
                            <img src="{{asset($generalsetting->white_logo)}}" alt="">
                        </a>
                    </div>
                    <ul id="side-menu">
                        <li>
                            <a href="{{ url('admin/dashboard') }}">
                                <i data-feather="home"></i>
                                <span> Dashboard </span>
                            </a>
                        </li>

                        <li>
                            <a href="#sidebar-orders" data-bs-toggle="collapse">
                                <i data-feather="shopping-cart"></i>
                                <span> Orders </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebar-orders">
                                <ul class="nav-second-level">
                                    <li>
                                        <a href="{{ route('admin.orders', ['slug' => 'pos']) }}">
                                            <i data-feather="minus"></i> POS Order
                                        </a>
                                    </li>
                                    @foreach ($orderstatus as $value)

                                        <li>
                                            <a href="{{ route('admin.orders', ['slug' => $value->slug]) }}">
                                                <i data-feather="minus"></i>{{ $value->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        <!-- nav items -->
                        @role('Admin')
                        <li>
                            <a href="#siebar-food" data-bs-toggle="collapse">
                                <i data-feather="database"></i>
                                <span> Food Manage </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="siebar-food">
                                <ul class="nav-second-level">
                                    <li>
                                        <a href="{{ route('foods.index') }}"><i data-feather="minus"></i>
                                            Food Manage</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('categories.index') }}"><i data-feather="minus"></i>
                                            Categories</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('subcategories.index') }}"><i data-feather="minus"></i>
                                            Subcategories</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('sizes.index') }}"><i data-feather="minus"></i>
                                            Sizes</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('foods.barcode') }}"><i data-feather="minus"></i>
                                            Barcode</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('reviews.index') }}"><i data-feather="minus"></i>Reviews</a>
                                    </li>

                                </ul>
                            </div>
                        </li>
                        @endrole
                        <!-- nav items end -->
                        @role('Admin')
                        <li>
                            <a href="#sidebar-users" data-bs-toggle="collapse">
                                <i data-feather="user"></i>
                                <span> Admin & Permission </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebar-users">
                                <ul class="nav-second-level">
                                    <li>
                                        <a href="{{ route('users.index') }}"><i data-feather="minus"></i>
                                            User</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('roles.index') }}"><i data-feather="minus"></i>
                                            Roles</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('permissions.index') }}"><i data-feather="minus"></i>
                                            Permissions</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        @endrole
                        <!-- nav items -->
                        @role('Admin')
                        <li>
                            <a href="#sidebar-customers" data-bs-toggle="collapse">
                                <i data-feather="users"></i>
                                <span> Customers </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebar-customers">
                                <ul class="nav-second-level">
                                    <li>
                                        <a href="{{ route('customers.index') }}"><i data-feather="minus"></i>
                                            Customer List</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        @endrole
                        <!-- nav items -->
                        @role('Admin')
                        <li>
                            <a href="#siebar-sitesetting" data-bs-toggle="collapse">
                                <i data-feather="settings"></i>
                                <span> Website Setting </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="siebar-sitesetting">
                                <ul class="nav-second-level">
                                    <li>
                                        <a href="{{ route('settings.index') }}"><i data-feather="minus"></i>
                                            General Setting</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('socialmedias.index') }}"><i data-feather="minus"></i>
                                            Social Media</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('contact.index') }}"><i data-feather="minus"></i>
                                            Contact</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('deliveryzones.index') }}"><i
                                                data-feather="minus"></i> Delivery Zone</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('orderstatus.index') }}"><i data-feather="minus"></i>
                                            Order Status</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('pages.index') }}"><i data-feather="minus"></i> Create Page</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        @endrole
                        <!-- nav items end -->
                        @role('Admin')
                        <li>
                            <a href="#sidebar-api-integration" data-bs-toggle="collapse">
                                <i data-feather="paperclip"></i>
                                <span> API Integration </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebar-api-integration">
                                <ul class="nav-second-level">
                                    <li>
                                        <a href="{{ route('courierapi.manage') }}"><i data-feather="minus"></i>
                                            Courier API</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('smsgeteway.manage') }}"><i data-feather="minus"></i>
                                            SMS Gateway</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        @endrole
                        <!-- nav items end -->
                        @role('Admin')
                        <li>
                            <a href="#sidebar-pixel-gtm" data-bs-toggle="collapse">
                                <i data-feather="share-2"></i>
                                <span> Marketing Tools </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebar-pixel-gtm">
                                <ul class="nav-second-level">
                                    <li>
                                        <a href="{{ route('tagmanagers.index') }}"><i data-feather="minus"></i>
                                            Tag Manager</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('pixels.index') }}"><i data-feather="minus"></i>Facebook Pixels</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('couponcodes.index') }}"><i data-feather="minus"></i>
                                            Coupon Code</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.send_sms') }}"><i data-feather="minus"></i>
                                           SMS Marketing</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        @endrole
                        <!-- nav items end -->
                        @role('Admin')
                        <li>
                            <a href="#siebar-banner" data-bs-toggle="collapse">
                                <i data-feather="image"></i>
                                <span> Banner & Ads </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="siebar-banner">
                                <ul class="nav-second-level">
                                    <li>
                                        <a href="{{ route('banner_category.index') }}"><i
                                                data-feather="minus"></i> Banner Category</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('banners.index') }}"><i data-feather="minus"></i>
                                            Banner & Ads</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        @endrole
                        <!-- nav items end -->
                        <!-- expense-start -->
                        @role('Admin')
                        <li>
                            <a href="#siebar-expense" data-bs-toggle="collapse">
                                <i data-feather="database"></i>
                                <span> Expense </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="siebar-expense">
                                <ul class="nav-second-level">
                                    <li>
                                        <a href="{{ route('expensecategories.index') }}"><i
                                                data-feather="minus"></i> Expense Categories</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('expense.index') }}"><i data-feather="minus"></i>
                                            Expense</a>
                                    </li>

                                </ul>
                            </div>
                        </li>
                        @endrole
                        <!-- expense-end -->
                        @role('Admin')
                        <li>
                            <a href="#sitebar-report" data-bs-toggle="collapse">
                                <i data-feather="pie-chart"></i>
                                <span> Reports </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sitebar-report">
                                <ul class="nav-second-level">
                                    <li>
                                        <a href="{{ route('admin.order_report') }}"><i data-feather="minus"></i>
                                            Sales Reports</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.expense_report') }}"><i
                                                data-feather="minus"></i> Expense Reports</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.loss_profit') }}"><i data-feather="minus"></i>
                                            Loss/Profit</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('customers.ip_block') }}"><i data-feather="minus"></i>
                                            IP Block</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        @endrole
                        <!-- nav items end -->
                        @role('Admin')
                        <li>
                            <a href="{{ url('cc') }}">
                                <i data-feather="tool"></i>
                                <span> Cache Clear </span>
                            </a>
                        </li>
                        @endrole
                    </ul>
                </div>
                <!-- End Sidebar -->

                <div class="clearfix"></div>
            </div>
            <!-- Sidebar -left -->
        </div>
        <!-- Left Sidebar End -->

        <div class="content-page">
            <div class="content">
                @yield('content')
            </div>
            <!-- content -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 text-end">&copy; {{ $generalsetting->name }} <a
                                href="https://websolutionit.com" target="_blank">Websolution IT</a></div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->
        </div>
    </div>
    <!-- END wrapper -->

    <!-- Right Sidebar -->
    <div class="right-bar">
        <div data-simplebar class="h-100">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-bordered nav-justified" role="tablist">
                <li class="nav-item">
                    <a class="nav-link py-2" data-bs-toggle="tab" href="#chat-tab" role="tab">
                        <i class="mdi mdi-message-text d-block font-22 my-1"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-2" data-bs-toggle="tab" href="#tasks-tab" role="tab">
                        <i class="mdi mdi-format-list-checkbox d-block font-22 my-1"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-2 active" data-bs-toggle="tab" href="#settings-tab" role="tab">
                        <i class="mdi mdi-cog-outline d-block font-22 my-1"></i>
                    </a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content pt-0">
                <div class="tab-pane" id="chat-tab" role="tabpanel">
                    <form class="search-bar p-3">
                        <div class="position-relative">
                            <input type="text" class="form-control" placeholder="Search..." />
                            <span class="mdi mdi-magnify"></span>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <!-- end slimscroll-menu-->
    </div>
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    @if(session('success'))
    <audio id="successSound" src="{{asset('public/frontEnd/')}}/success.mp3" autoplay></audio>
    @endif
    <!-- Vendor js -->
    <script src="{{ asset('public/backEnd/') }}/assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="{{ asset('public/backEnd/') }}/assets/js/app.min.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/js/toastr.min.js"></script>
    {!! Toastr::message() !!}
    <script src="{{ asset('public/backEnd/') }}/assets/js/sweetalert.min.js"></script>
    <script type="text/javascript">
        $(".delete-confirm").click(function(event) {
            var form = $(this).closest("form");
            event.preventDefault();
            swal({
                title: `Are you sure you want to delete this record?`,
                text: "If you delete this, it will be gone forever.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
        });
        $(".change-confirm").click(function(event) {
            var form = $(this).closest("form");
            event.preventDefault();
            swal({
                title: `Are you sure you want to change this record?`,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
        });
    </script>
    <!--patho courier-->
    <script type="text/javascript">
        $(document).ready(function() {
            $('.pathaocity').change(function() {
                var id = $(this).val();
                if (id) {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('admin/pathao-city') }}?city_id=" + id,
                        success: function(res) {
                            if (res && res.data && res.data.data) {
                                $(".pathaozone").empty();
                                $(".pathaozone").append('<option value="">Select..</option>');
                                $.each(res.data.data, function(index, zone) {
                                    $(".pathaozone").append('<option value="' + zone
                                        .zone_id + '">' + zone.zone_name +
                                        '</option>');
                                    $('.pathaozone').trigger("chosen:updated");
                                });
                            } else {
                                $(".pathaoarea").empty();
                                $(".pathaozone").empty();
                            }
                        }
                    });
                } else {
                    $(".pathaoarea").empty();
                    $(".pathaozone").empty();
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.pathaozone').change(function() {
                var id = $(this).val();
                if (id) {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('admin/pathao-zone') }}?zone_id=" + id,
                        success: function(res) {
                            if (res && res.data && res.data.data) {
                                $(".pathaoarea").empty();
                                $(".pathaoarea").append('<option value="">Select..</option>');
                                $.each(res.data.data, function(index, area) {
                                    $(".pathaoarea").append('<option value="' + area
                                        .area_id + '">' + area.area_name +
                                        '</option>');
                                    $('.pathaoarea').trigger("chosen:updated");
                                });
                            } else {
                                $(".pathaoarea").empty();
                            }
                        }
                    });
                } else {
                    $(".pathaoarea").empty();
                }
            });
        });
    </script>
    <script>
        function cart_content() {
            $.ajax({
                type: "GET",
                url: "{{ route('admin.order.cart_content') }}",
                dataType: "html",
                success: function(cartinfo) {
                    $('#cartTable').html(cartinfo)
                }
            });
        }

        function cart_details() {
            $.ajax({
                type: "GET",
                url: "{{ route('admin.order.cart_details') }}",
                dataType: "html",
                success: function(cartinfo) {
                    $("#cart_details").html(cartinfo);
                },
            });
        }

        function search_clear() {
            var keyword = '';
            $(".search_click").val(''); // Clears the input field
            $.ajax({
                type: "GET",
                data: {
                    keyword: keyword
                },
                url: "{{ route('admin.livesearch') }}",
                success: function(products) {
                    if (products) {
                        $(".search_result").html(products);
                    } else {
                        $(".search_result").empty();
                    }
                },
            });
        }
        $(".search_click").on("input", function() {
            var keyword = $(this).val();
            $.ajax({
                type: "GET",
                data: {
                    keyword: keyword
                },
                url: "{{ route('admin.livesearch') }}",
                success: function(response) {
                    if (response.status === 'success') {
                        cart_content() + cart_details() + search_clear();
                    } else if (response) {
                        $(".search_result").html(response);
                    } else {
                        $(".search_result").empty();
                    }
                },
            });
        });
    </script>
    @yield('script')
</body>

</html>
