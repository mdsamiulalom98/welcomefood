@extends('frontEnd.layouts.master') @section('title', 'Customer Checkout') @push('css')
<link rel="stylesheet" href="{{ asset('public/frontEnd/css/select2.min.css') }}" />
@endpush @section('content')
<section class="chheckout-section">
    @php
        $subtotal = Cart::instance('shopping')->subtotal();
        $subtotal = str_replace(',', '', $subtotal);
        $subtotal = str_replace('.00', '', $subtotal);
        $shipping = Session::get('shipping') ? Session::get('shipping') : 0;
        $coupon = Session::get('coupon_amount') ? Session::get('coupon_amount') : 0;
        $discount = Session::get('discount') ? Session::get('discount') : 0;
    @endphp
    <div class="container">
        <div class="row">
            <div class="col-sm-7 cus-order-2">
                <div class="checkout-shipping">
                    <form action="{{ route('customer.ordersave') }}" method="POST" data-parsley-validate="">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="delivery-title">
                                    <h4>Delivery Address</h4>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-title">
                                    <h5>Delivery Address</h5>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <input type="text" id="name"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ Auth::guard('customer')->user() ? Auth::guard('customer')->user()->name : old('name') }}" placeholder="Full Name *" required />
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->
                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <input type="text" minlength="11" id="number" maxlength="11" id="phone"
                                        class="form-control @error('phone') is-invalid @enderror" name="phone"
                                        value="{{ Auth::guard('customer')->user() ? Auth::guard('customer')->user()->phone : old('phone') }}" placeholder="Mobile Number *" required />
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
                                    <input type="address" id="address"
                                        class="form-control @error('address') is-invalid @enderror"
                                        name="address" placeholder="Address *" value="{{ Auth::guard('customer')->user() ? Auth::guard('customer')->user()->address : old('address') }}" required />
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
                                        class="form-control @error('area') is-invalid @enderror select2" name="area"
                                        required>
                                        <option value="">Delivery Zone</option>
                                        @foreach ($deliveryzones as $key => $value)
                                            <option value="{{ $value->id }}" @if(Auth::guard('customer')->user()) {{Auth::guard('customer')->user()->zone_id == $value->id ? 'selected' : '' }} @endif >{{ $value->name }}</option>
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
                            <div class="col-sm-12">
                                <div class="radio_payment">
                                    <label id="payment_method">Payment Method</label>
                                </div>
                                <div class="payment-methods">

                                    <div class="form-check p_cash payment_method" data-id="cod">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                            id="inlineRadio1" value="Cash On Delivery" checked required />
                                        <label class="form-check-label" for="inlineRadio1">
                                            Cash On Delivery
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button class="order_place" type="submit">Confirm Order</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- col end -->
            <div class="col-sm-5 cust-order-1">
                <div class="cart_details checkout-shipping">
                    <div class="delivery-title">
                        <h4>Your Order Summary</h4>
                    </div>
                    <div class="cart_list">
                        <div class="order-summery">
                            <ul>
                                @foreach (Cart::instance('shopping')->content() as $item)
                                <li><span>{{$item->qty}} x {{$item->name}}</span><span>{{$item->price * $item->qty}} Tk</span></li>
                                @endforeach
                            </ul>
                        </div>
                       <div class="mini-cart-summary">
                            <ul>
                                <li><span>Subtotal</span><span>{{$subtotal}} Tk</span></li>
                                <li><span>Delivery Charge</span><span>{{$shipping}} Tk</span></li>
                                <li><span>Discount</span><span>{{$discount+$coupon}} Tk</span></li>
                            </ul>
                        </div>
                       <div class="summary-total">
                            <ul>
                                <li class="d-flex justify-content-between"><span>Total</span><span>{{($subtotal+$shipping) - ($discount+$coupon)}} Tk</span></li>
                            </ul>
                        </div>
                    </div>
            </div>
            <!-- col end -->
        </div>
    </div>
</section>
@endsection @push('script')
<script src="{{ asset('public/frontEnd/') }}/js/parsley.min.js"></script>
<script src="{{ asset('public/frontEnd/') }}/js/form-validation.init.js"></script>
<script src="{{ asset('public/frontEnd/') }}/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $(".select2").select2();
    });
</script>

<script>
    $("#area").on("change", function() {
        var id = $(this).val();
        $.ajax({
            type: "GET",
            data: {
                id: id
            },
            url: "{{ route('shipping.charge') }}",
            dataType: "html",
            success: function(response) {
                mini_cart();
                cart_summary();
            },
        });
    });
</script>

<script type="text/javascript">
    dataLayer.push({
        ecommerce: null
    }); // Clear the previous ecommerce object.
    dataLayer.push({
        event: "view_cart",
        ecommerce: {
            items: [
                @foreach (Cart::instance('shopping')->content() as $cartInfo)
                    {
                        item_name: "{{ $cartInfo->name }}",
                        item_id: "{{ $cartInfo->id }}",
                        price: "{{ $cartInfo->price }}",
                        item_brand: "{{ $cartInfo->options->brand }}",
                        item_category: "{{ $cartInfo->options->category }}",
                        item_size: "{{ $cartInfo->options->size }}",
                        item_color: "{{ $cartInfo->options->color }}",
                        currency: "BDT",
                        quantity: {{ $cartInfo->qty ?? 0 }}
                    },
                @endforeach
            ]
        }
    });
</script>
<script type="text/javascript">
    dataLayer.push({
        ecommerce: null
    });
    dataLayer.push({
        event: "begin_checkout",
        ecommerce: {
            items: [
                @foreach (Cart::instance('shopping')->content() as $cartInfo)
                    {
                        item_name: "{{ $cartInfo->name }}",
                        item_id: "{{ $cartInfo->id }}",
                        price: "{{ $cartInfo->price }}",
                        item_brand: "{{ $cartInfo->options->brands }}",
                        item_category: "{{ $cartInfo->options->category }}",
                        item_size: "{{ $cartInfo->options->size }}",
                        item_color: "{{ $cartInfo->options->color }}",
                        currency: "BDT",
                        quantity: {{ $cartInfo->qty ?? 0 }}
                    },
                @endforeach
            ]
        }
    });
</script>
@endpush
