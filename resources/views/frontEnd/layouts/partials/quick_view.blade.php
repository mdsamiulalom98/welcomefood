<div class="modal-header">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="quick_view_inner">
        <input type="hidden" value="{{$data->id}}" name="hidden_id">
        <div class="quick_view_img">
            <img src="{{asset($data->image?->image)}}" alt="">
            <div class="wishlist-fixed-bt">
                <button type="button" data-id="{{ $data->id }}" class="hover-zoom wishlist_store"
                    title="Wishlist"><i class="fa-regular fa-heart"></i></button>
            </div>
        </div>
        <div class="quick_view_content">
            <h2>{{$data->name}}</h2>
            <h4>@if($data->old_price)<del id="old_price">{{$data->old_price}}</del>@endif <span id="new_price"> {{$data->new_price}}</span> Tk</h4>
            <p>{!! $data->description !!}</p>
        </div>
        @if($data->variables->count() > 1)
        <div class="variation-card">
           <div class="variation-inner">
                <div class="variation-header">
                    <h3>Variation</h3>
                </div>
                <p class="valid_note"></p>
                @foreach($data->variables as $key=>$value)
                <div class="variation-option">
                    <div class="form-check" data-price="{{$value->new_price}}" data-old-price="{{$value->old_price}}">
                          <label class="form-check-label" for="size{{$key}}">
                          <div class="form-group">
                            <input class="form-check-input" value="{{$value->size}}" type="radio" name="size" id="size{{$key}}">
                            <p>{{$value->size}}</p>
                          </div>
                           <p>{{$value->new_price}} Tk</p>
                    </div>
                </div>
                @endforeach
           </div>
        </div>
        @endif
    </div>
</div>
<div class="modal-footer">
    <div class="quick_view_cart">
        <div class="qty-cart">
            <div class="quantity">
                <span class="minus"><i class="fa-solid fa-minus"></i></span>
                <input type="text" name="qty" value="1" />
                <span class="plus"><i class="fa-solid fa-plus"></i></span>
            </div>
        </div>
        <button class="add_cart_btn">Add To Cart</button>
    </div>
</div>
 <script>
    $(document).ready(function() {
        $(".minus").click(function() {
            var $input = $(this).parent().find("input");
            var count = parseInt($input.val()) - 1;
            count = count < 1 ? 1 : count;
            $input.val(count);
            $input.change();
            return false;
        });
        $(".plus").click(function() {
            var $input = $(this).parent().find("input");
            $input.val(parseInt($input.val()) + 1);
            $input.change();
            return false;
        });
    });
    $(".variation-option .form-check").on("click", function(e) {
        let new_price = $(this).data('price');
        let old_price = $(this).data('old-price');
        if(old_price > 0){
            $('#old_price').text(old_price);
        }
        $('#new_price').text(new_price);
    });


    $(".add_cart_btn").on("click", function (e) {
        e.preventDefault();
        let id = $("input[name='hidden_id']").val();
        let qty = $("input[name='qty']").val();
        let size = $("input[name='size']:checked").val();
        @if($data->variables->count() > 1)
            if (!size) {
                $('.valid_note').show();
                $(".valid_note").html('<p  style="color:red;">Please select a variation</p>');
                return false;
            }
            $('.valid_note').hide();
        @endif

        $.ajax({
        type: "GET",
        data: { id, qty,size },
        url: "{{route('cart.store')}}",
        success: function (response) {
                if (response) {
                    cart_count();
                    mini_cart();
                    $('.modal').modal('hide');
                    toastr.success("Success", "Food add to cart succfully");
                }
            },
        });
    });

    $(".wishlist_store").on("click", function () {
        var id = $(this).data("id");
        if (id) {
            $.ajax({
                type: "GET",
                data: { id: id },
                url: "{{route('wishlist.store')}}",
                success: function (data) {
                    if (data) {
                        $('.modal').modal('hide');
                        toastr.success("Success", "Food add to wishlist successfully");
                    }
                },
            });
        }
    });
</script>
