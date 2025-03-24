<div class="product_item_inner">
    <div class="wishlist-fixed-bt">
        <button data-id="{{ $value->id }}" class="hover-zoom wishlist_store"
            title="Wishlist"><i class="fa-regular fa-heart"></i></button>
    </div>
    @if ($value->old_price)
        <div class="discount">
            <p>@php $discount=(((($value->old_price)-($value->new_price))*100) / ($value->old_price)) @endphp {{ number_format($discount, 0) }}% Discount</p>
        </div>
    @endif
    <div class="pro_img">
        <a class="quick_view" data-id="{{ $value->id }}" data-bs-toggle="modal" data-bs-target="#quickview_modal">
            <img src="{{ asset($value->image ? $value->image->image : '') }}"
                alt="{{ $value->name }}" />
        </a>
    </div>
    <div class="pro_des">
        <div class="pro_name">
            <a class="quick_view" data-id="{{ $value->id }}" data-bs-toggle="modal" data-bs-target="#quickview_modal">{{ Str::limit($value->name, 80) }}</a>
        </div>
        <div class="pro_price">
            @if ($value->variable_count > 1)
                <p>
                    @if ($value->variable->old_price)
                        <del>{{ $value->variable->old_price }} Tk</del>
                    @endif
                    {{ $value->variable->new_price }} Tk
                </p>
            @else
                <p>
                    @if ($value->old_price)
                        <del>{{ $value->old_price }} Tk</del>
                    @endif
                    {{ $value->new_price }} Tk
                </p>
                @endif
        </div>
        <div class="pro_btn">
            @if ($value->variable_count > 1)
            <div class="cart_btn">
               <a class="quick_view" data-id="{{ $value->id }}" data-bs-toggle="modal" data-bs-target="#quickview_modal"><i class="fa-solid fa-shopping-cart"></i> Order Now</a>
            </div>
            @else
            <div class="cart_btn">
                <button  data-id="{{ $value->id }}" class="cart_store"><i class="fa-solid fa-shopping-cart"></i>  Order Now</button>
            </div>
            @endif
        </div>
    </div>
</div>
