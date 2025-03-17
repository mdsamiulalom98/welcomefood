<div class="items">{{ Cart::instance('shopping')->count() }} {{ Cart::instance('shopping')->count() > 1 ? 'Items' : 'Item' }}</div>
<div class="price">
    {{ Cart::instance('shopping')->subtotal() }} TK
</div>
