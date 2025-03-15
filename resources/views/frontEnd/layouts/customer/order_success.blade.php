@extends('frontEnd.layouts.master')
@section('title', 'Order Success')
@section('content')
    <section class="order-success-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-7">

                    <div class="success_inner">
                        <div class="order_notice">
                            <i class="fa-solid fa-check-circle"></i>
                            <h2>Thanks for your purchase</h2>
                            <p>We have received your order will process as soon</p>
                            <p>Your order number is {{ $order->invoice_id }}</p>
                        </div>
                        <div class="order_info">
                            <h3>Order Summary</h3>

                            <ul class="order_product">
                                @foreach ($order->orderdetails as $key => $value)
                                <li>
                                    <p><img src="{{asset($value->image?->image)}}" alt=""> {{$value->food_name}} x {{$value->qty}}</p>
                                    <p>{{$value->sale_price}} Tk</p>
                                </li>
                                @endforeach
                            </ul>
                            <ul class="order_total">
                                <li>
                                    <p>Sub Total</p>
                                    <p>{{ $order->amount - $order->shipping_charge }} Tk</p>
                                </li>
                                <li>
                                    <p>Shipping (+)</p>
                                    <p>{{ $order->shipping_charge}} Tk</p>
                                </li>
                                <li>
                                    <p>Discount (-)</p>
                                    <p>{{ $order->discount}} Tk</p>
                                </li>
                                <li>
                                    <p>Total</p>
                                    <p>{{ $order->amount}} Tk</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script src="{{ asset('public/frontEnd/') }}/js/parsley.min.js"></script>
    <script src="{{ asset('public/frontEnd/') }}/js/form-validation.init.js"></script>
    @if (Session::get('purchase_event'))
        //
        <script type="text/javascript">
            window.dataLayer = window.dataLayer || [];
            dataLayer.push({
                ecommerce: null
            });
            dataLayer.push({
                event: "purchase",
                ecommerce: {
                    transaction_id: "{{ $order->invoice_id }}",
                    value: {{ $order->amount }},
                    tax: 0,
                    shipping: {{ $order->shipping_charge }},
                    currency: "BTD",
                    coupon: "ecommerce",
                    items: [
                        @foreach ($order->orderdetails as $key => $value)
                            {
                                item_id: "{{ $value->product_id }}",
                                item_name: "{{ $value->product_name }}",
                                coupon: "ecommerce",
                                discount: {{ $value->product_discount }},
                                index: {{ $value->id }},
                                item_brand: "ecommerce",
                                item_category: "@if ($value->product) {{ $value->product->category ? $value->product->category->name : '' }} @endif",
                                item_variant: "{{ $value->product_size }}",
                                price: {{ $value->sale_price }},
                                quantity: {{ $value->qty }}
                            },
                        @endforeach
                    ]
                }
            });
            //
        </script>
        {{ Session::forget('purchase_event') }}
    @endif
@endpush
