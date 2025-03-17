<div class="order-summery">
    <div class="order-summery-cart">
        @foreach (Cart::instance('shopping')->content() as $item)
            <div class="product-card-attributes">
                <div class="product-card-image">
                    <img src="{{ asset($item->options->image ?? '') }}" alt="">
                </div>
                <div class="product-card-content">
                    <div class="product-card-title">
                        <a href="">{{ $item->name }}</a>
                    </div>
                    <div class="product-card-price-quantity">
                        <div class="product-card-price">
                            <strong>{{ $item->price * $item->qty }} Tk</strong>
                            @if ($item->options->size)
                                <small>Size: {{ $item->options->size }}</small>
                            @endif
                        </div>
                        <div class="product-card-quantity">
                            <div class="cart-quantity-content">
                                @if ($item->qty == 1)
                                    <button class="mini-cart-change cart_remove" data-id="{{ $item->rowId }}"
                                        type="button">
                                        <i class="fa fa-trash-alt"></i>
                                    </button>
                                @else
                                    <button class="mini-cart-change cart_decrement" data-id="{{ $item->rowId }}"
                                        type="button">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                @endif
                                <span>{{ $item->qty }}</span>
                                <button class="mini-cart-change cart_increment" data-id="{{ $item->rowId }}"
                                    type="button">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
        @endforeach
    </div>
</div>
<div class="mini-cart-summary">
    <ul>
        <li><span>Subtotal</span><span>{{ $subtotal }} Tk</span></li>
        <li><span>Delivery Charge</span><span>{{ $shipping }} Tk</span></li>
        <li><span>Discount</span><span>{{ $discount + $coupon }} Tk</span></li>
    </ul>
</div>
<div class="summary-total">
    <ul>
        <li class="d-flex justify-content-between">
            <span>Total</span><span>{{ $subtotal + $shipping - ($discount + $coupon) }} Tk</span>
        </li>
    </ul>
</div>
