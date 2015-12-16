<ul class="list-group">
@foreach (Cart::content() as $item)
    <li class="list-group-item">
        <form action="{{ route('cart.remove', $item->rowid) }}" method="POST" style="display:inline-block;">
            {{ csrf_field() }}
            {{ method_field('delete') }}
            <input type="submit" value="X" class="btn btn-link text-danger">
        </form>
        <a href="{{ $item->product->url }}">{{ $item->name }}</a> x{{ $item->qty }} - &pound;{{ $item->product->getPrice() * $item->qty }}
    </li>
@endforeach
</ul>
<div class="row">
    <p class="col-xs-6">Total &pound;{{ Cart::total() }}</p>
    <p class="col-xs-6 text-right">{{ Cart::count() }} items</p>
</div>