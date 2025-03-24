@extends('backEnd.layouts.master')
@section('title', 'Order Create')
@section('css')
    <style>
        .increment_btn,
        .remove_btn {
            margin-top: -17px;
            margin-bottom: 10px;
        }
    </style>
    <link href="{{ asset('public/backEnd') }}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backEnd') }}/assets/libs/summernote/summernote-lite.min.css" rel="stylesheet"
        type="text/css" />
    @endsection @section('content')

    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <form method="post" action="{{ route('admin.order.cart_clear') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger rounded-pill delete-confirm" title="Delete"><i
                                    class="fas fa-trash-alt"></i> Cart Clear</button>
                        </form>
                    </div>
                    <h4 class="page-title">Order Create</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-sm-12">
                            <div class="form-group mb-3">
                                <label for="product_id" class="form-label">Food *</label>
                                <div class="pos_search">
                                    <input type="text" placeholder="Search Product Name ..." value=""
                                        class="search_click" name="keyword" autofocus />
                                    <button><i data-feather="search"></i></button>
                                </div>
                                <div class="search_result"></div>
                                @error('product_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col end -->
                        <form action="{{ route('admin.order.store') }}" method="POST" class="row pos_form"
                            data-parsley-validate="" enctype="multipart/form-data">
                            @csrf
                            <div class="col-sm-12">
                                <table class="table table-bordered table-responsive-sm">
                                    <thead>
                                        <tr></tr>
                                        <tr>
                                            <th style="width: 10%;">Image</th>
                                            <th style="width: 25%;">Name</th>
                                            <th style="width: 15%;">Quantity</th>
                                            <th style="width: 15%;">Sell Price</th>
                                            <th style="width: 15%;">Discount</th>
                                            <th style="width: 15%;">Sub Total</th>
                                            <th style="width: 15%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="cartTable">
                                        @php $product_discount = 0; @endphp
                                        @foreach ($cartinfo as $key => $value)
                                            <tr>
                                                <td><img src="{{ asset($value->options->image) }}">
                                                    <p class="mt-1">{{ $value->options->size }} </p>
                                                </td>
                                                <td>{{ $value->name }} </td>
                                                <td>
                                                    <div class="qty-cart vcart-qty">
                                                        <div class="quantity">
                                                            <button class="minus cart_decrement" value="{{ $value->qty }}"
                                                                data-id="{{ $value->rowId }}">-</button>
                                                            <input type="text" value="{{ $value->qty }}" readonly />
                                                            <button class="plus cart_increment" value="{{ $value->qty }}"
                                                                data-id="{{ $value->rowId }}">+</button>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $value->price }}</td>
                                                <td class="discount"><input type="number" class="product_discount"
                                                        value="{{ $value->options->product_discount }}" placeholder="0.00"
                                                        data-id="{{ $value->rowId }}" /></td>
                                                <td>{{ ($value->price - $value->options->product_discount) * $value->qty }}
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-xs cart_remove"
                                                        data-id="{{ $value->rowId }}"><i class="fa fa-times"></i></button>
                                                </td>
                                            </tr>
                                            @php
                                                $product_discount += $value->options->product_discount * $value->qty;
                                                Session::put('product_discount', $product_discount);
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- custome address -->
                            <div class="col-sm-6">
                                <div class="form-check mb-2">
                                    <label class="form-check-label" for="guest_customer">
                                        Guest Customer
                                    </label>
                                    <input class="form-check-input" type="checkbox" name="guest_customer" value="1"
                                        id="guest_customer">
                                </div>
                                <div class="row new_customer">
                                    <div class="col-sm-12">
                                        <div class="form-group mb-2">
                                            <input type="text" id="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                placeholder="Customer Name" name="name" value="" />
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- col-end -->
                                    <div class="col-sm-12">
                                        <div class="form-group mb-2">
                                            <input type="number" id="phone"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                placeholder="Customer Number" name="phone" value="" />
                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- col-end -->
                                    <div class="col-sm-12">
                                        <div class="form-group mb-3">
                                            <input type="address" placeholder="Address" id="address"
                                                class="form-control @error('address') is-invalid @enderror" name="address"
                                                value="" />
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group mb-3">
                                            <select type="area" id="area"
                                                class="select2 form-control @error('area') is-invalid @enderror"
                                                name="area">
                                                <option value="">Select....</option>
                                                @foreach ($deliveryzones as $key => $value)
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                @endforeach

                                            </select>
                                            @error('area')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- col-end -->
                                </div>
                                @if (Auth::user()->hasAnyRole(['Waiter', 'Admin']))
                                    <div class="row mb-2">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="chef_id" class="form-label">Assign Chef</label>
                                                <select
                                                    class="form-control form-select @error('chef_id') is-invalid @enderror"
                                                    name="chef_id" value="{{ old('chef_id') }}"
                                                    data-placeholder="Choose ..." required>
                                                    <optgroup>
                                                        <option value="">Select..</option>
                                                        @foreach ($chefs as $value)
                                                            <option value="{{ $value->id }}">{{ $value->name }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <!-- end customer address -->
                            <!-- cart total -->
                            <div class="col-sm-6">
                                <table class="table table-bordered">
                                    <tbody id="cart_details">
                                        @php
                                            $subtotal = Gloudemans\Shoppingcart\Facades\Cart::instance('sale')->subtotal();
                                            $subtotal = str_replace(',', '', $subtotal);
                                            $subtotal = str_replace('.00', '', $subtotal);
                                            $shipping = Session::get('pos_shipping') ?: 0;
                                            $pos_discount = Session::get('pos_discount') ?: 0;
                                            $product_discount = Session::get('product_discount') ?: 0;
                                            $total_discount = $pos_discount + $product_discount;
                                        @endphp
                                        <tr>
                                            <td>Sub Total</td>
                                            <td>{{ $subtotal }}</td>
                                        </tr>
                                        <tr>
                                            <td>Shipping Fee</td>
                                            <td>{{ $shipping }}</td>
                                        </tr>
                                        <tr>
                                            <td>Discount</td>
                                            <td>{{ $total_discount }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total</td>
                                            <td>{{ $subtotal + $shipping - $total_discount }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <input type="submit" class="btn btn-success" value="Order Submit" />
                            </div>
                        </form>
                    </div>
                    <!-- end card-body-->
                </div>
                <!-- end card-->
            </div>
            <!-- end col-->
        </div>
    </div>
    @endsection @section('script')
    <script src="{{ asset('public/backEnd/') }}/assets/libs/parsleyjs/parsley.min.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/js/pages/form-validation.init.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/libs/select2/js/select2.min.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/js/pages/form-advanced.init.js"></script>
    <!-- Plugins js -->
    <script src="{{ asset('public/backEnd/') }}/assets/libs//summernote/summernote-lite.min.js"></script>
    <script>
        $(".summernote").summernote({
            placeholder: "Enter Your Text Here",
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(".select2").select2();
        });
    </script>
    <script>
        // pshippingfee from total
        $("#area").on("change", function() {
            var id = $(this).val();
            $.ajax({
                type: "GET",
                data: {
                    id: id
                },
                url: "{{ route('admin.order.cart_shipping') }}",
                dataType: "html",
                success: function(cartinfo) {
                    return cart_content() + cart_details();
                },
            });
        });

        function cart_content() {
            $.ajax({
                type: "GET",
                url: "{{ route('admin.order.cart_content') }}",
                dataType: "html",
                success: function(cartinfo) {
                    $("#cartTable").html(cartinfo);
                },
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
        $(".cart_add").on("click", function(e) {
            var id = $(this).data('id');
            if (id) {
                $.ajax({
                    cache: "false",
                    type: "GET",
                    data: {
                        id: id
                    },
                    url: "{{ route('admin.order.cart_add') }}",
                    dataType: "json",
                    success: function(cartinfo) {
                        return cart_content() + cart_details() + search_clear();
                    },
                });
            }
        });
        $(".cart_increment").click(function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            var qty = $(this).val();
            if (id) {
                $.ajax({
                    cache: false,
                    data: {
                        id: id,
                        qty: qty
                    },
                    type: "GET",
                    url: "{{ route('admin.order.cart_increment') }}",
                    dataType: "json",
                    success: function(cartinfo) {
                        return cart_content() + cart_details();
                    },
                });
            }
        });
        $(".cart_decrement").click(function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            var qty = $(this).val();
            if (id) {
                $.ajax({
                    cache: false,
                    type: "GET",
                    data: {
                        id: id,
                        qty: qty
                    },
                    url: "{{ route('admin.order.cart_decrement') }}",
                    dataType: "json",
                    success: function(cartinfo) {
                        return cart_content() + cart_details();
                    },
                });
            }
        });
        $(".cart_remove").click(function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            if (id) {
                $.ajax({
                    cache: false,
                    type: "GET",
                    data: {
                        id: id
                    },
                    url: "{{ route('admin.order.cart_remove') }}",
                    dataType: "json",
                    success: function(cartinfo) {
                        return cart_content() + cart_details();
                    },
                });
            }
        });
        $(".product_discount").change(function() {
            var id = $(this).data("id");
            var discount = $(this).val();
            $.ajax({
                cache: false,
                type: "GET",
                data: {
                    id: id,
                    discount: discount
                },
                url: "{{ route('admin.order.product_discount') }}",
                dataType: "json",
                success: function(cartinfo) {
                    return cart_content() + cart_details();
                },
            });
        });
        $(".cartclear").click(function(e) {
            $.ajax({
                cache: false,
                type: "GET",
                url: "{{ route('admin.order.cart_clear') }}",
                dataType: "json",
                success: function(cartinfo) {
                    return cart_content() + cart_details();
                },
            });
        });

        $(document).ready(function() {
            $('.search_click').focus();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#guest_customer').change(function() {
                if ($(this).is(':checked')) {
                    $('.new_customer').hide();
                } else {
                    $('.new_customer').show();
                }
            });
        });
    </script>
@endsection
