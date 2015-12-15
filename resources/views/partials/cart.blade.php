<ul>
@foreach (Cart::content() as $item)
    <li>
        {{ $item->name }} x{{ $item->qty }} - &pound;{{ $item->product->getPrice() * $item->qty }}
    </li>
@endforeach
</ul>
<p>Total &pound;{{ Cart::total() }}</p>
<p>{{ Cart::count() }} items</p>