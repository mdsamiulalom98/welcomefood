<div class="menu-food " >
    <div class="menu-img">
        <img class="quick_view" data-id="{{ $value->id }}" data-bs-toggle="modal" data-bs-target="#quickview_modal" src="{{ asset($value->image ? $value->image->image : '') }}" alt="{{ $value->name }}">
        @if ($value->variables->count() > 1)
            <a class="quick_view item_plus" data-id="{{ $value->id }}" data-bs-toggle="modal"
                data-bs-target="#quickview_modal"><i class="fa-solid fa-plus"></i> </a>
        @else
            <a data-id="{{ $value->id }}" class="item_plus cart_store"><i class="fa-solid fa-plus"></i></a>
        @endif
    </div>
    <div class="menu-info">
        <a class="quick_view" data-id="{{ $value->id }}" data-bs-toggle="modal"
            data-bs-target="#quickview_modal">{{ $value->name }}</a>
        <button class="cart_store order-now-button" data-redirect="order_now" data-id="{{ $value->id }}">Order
            Now</button>
    </div>
    <div class="menu-price quick_view" data-id="{{ $value->id }}" data-bs-toggle="modal" data-bs-target="#quickview_modal">
        @if ($value->variables->count() > 1)
            @foreach ($value->variables as $variable)
                <strong>
                    @if ($variable->old_price)
                        <del>Tk {{ $variable->old_price }}</del>
                    @endif
                    Tk {{ $variable->new_price }}
                    @if (!$loop->last)
                        <span>:</span>
                    @endif
                </strong>
            @endforeach
        @else
            <strong>
                @if ($value->old_price)
                    <del>Tk {{ $value->old_price }}</del>
                @endif
                Tk {{ $value->new_price }}
            </strong>
        @endif
    </div>
</div>
