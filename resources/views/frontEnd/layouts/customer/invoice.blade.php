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
                            <h2>Thanks for your order</h2>
                            <p>Your order has been {{$order->status?->name}}</p>
                            <p>Your order number is : {{ $order->invoice_id }}</p>
                        </div>
                        <div class="order_info">
                            <h3>Order Summary</h3>

                            <ul class="order_product">
                                @foreach ($order->orderdetails as $key => $value)
                                <li>
                                    <p><img src="{{asset($value->image?->image)}}" alt=""> {{$value->product_name}} x {{$value->qty}}</p>
                                    <p>{{$value->sale_price}} Tk</p>
                                </li>
                                @endforeach
                            </ul>
                            <ul class="order_total">
                                <li>
                                    <p>Sub Total</p>
                                    <p>{{ $order->amount - $order->shipping_charge }}</p>
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
