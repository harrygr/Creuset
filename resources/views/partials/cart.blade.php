<p>
<strong>Cart</strong> 
<a href="/cart">
{{ Present::money(Cart::total()) }} ({{ Cart::count() }} {{ str_plural('Item', Cart::count()) }})
</a>
</p>

