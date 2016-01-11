<p>
@if (Auth::check())
<img src="{{ Auth::user()->present()->avatar() }}" alt="">
{{ Auth::user()->name }} <a href="/logout">Logout</a> | <a href="/account">My Account</a>
@else
<a href="/login">Login</a>
@endif
</p>