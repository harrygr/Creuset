
<ul class="nav nav-pills top-buffer">
  @foreach ($nav_routes as $nav_route)
  <li role="presentation" class="{{ $nav_route['active'] ? 'active' : '' }}"><a href="{{ $nav_route['url'] }}">{{ $nav_route['text'] }}</a></li>
  @endforeach
</ul>