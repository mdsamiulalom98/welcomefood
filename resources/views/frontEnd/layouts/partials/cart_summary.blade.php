@php
    $subtotal = Cart::instance('shopping')->subtotal();
    $subtotal = str_replace(',', '', $subtotal);
    $subtotal = str_replace('.00', '', $subtotal);
    $shipping = Session::get('shipping') ? Session::get('shipping') : 0;
    $coupon = Session::get('coupon_amount') ? Session::get('coupon_amount') : 0;
    $discount = Session::get('discount') ? Session::get('discount') : 0;
@endphp


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
