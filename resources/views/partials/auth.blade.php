<p>
@if (Auth::check())
<img src="{{ Auth::user()->present()->avatar() }}" alt="">
{{ Auth::user()->name }} <a href="/logout">Logout</a>
@else
<a href="/login">Login</a>
@endif
</p>