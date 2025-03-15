@if($foods)
<div class="search_product">
		<ul>
		@foreach($foods as $value)
      @foreach($value->variables as $variable)
      <li>
        <a data-id="{{$value->id}}" data-size="{{$variable->size}}" class="cart_add">
          <p class="name">{{$value->name}} @if($variable->size)- {{$variable->size}} @endif</p> 
          <p  class="price">৳{{$variable->new_price}} @if($variable->old_price)<del>৳{{$variable->old_price}}</del>@endif</p>
        </a>
      </li>
      @endforeach
		@endforeach
	</ul>
</div>
@endif 

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
 function cart_content() {
  $.ajax({
   type: "GET",
   url: "{{route('admin.order.cart_content')}}",
   dataType: "html",
   success: function (cartinfo) {
    $("#cartTable").html(cartinfo);
   },
  });
 }
 function cart_details() {
  $.ajax({
   type: "GET",
   url: "{{route('admin.order.cart_details')}}",
   dataType: "html",
   success: function (cartinfo) {
    $("#cart_details").html(cartinfo);
   },
  });
 }
 function search_clear(){
    var keyword = '';
      $.ajax({
          type: "GET",
          data: { keyword: keyword },
          url: "{{route('admin.livesearch')}}",
          success: function (products) {
              if (products) {
                  $(".search_result").html(products);
                  $('.search_click').val('');
              } else {
                  $(".search_result").empty();
                  $('.search_click').val('');
              }
          },
      });
 }
 $(".cart_add").on("click", function (e) {
  var id = $(this).data('id');
  console.log('id',id);
  var size = $(this).data('size');
  if (id) {
   $.ajax({
    cache: "false",
    type: "GET",
    data: { id: id,size:size },
    url: "{{route('admin.order.cart_add')}}",
    dataType: "json",
    success: function (cartinfo) {
     return cart_content() + cart_details() + search_clear();
    },
   });
  }
 });
</script>