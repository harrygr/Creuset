@if (Auth::check())
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <img src="{{ Auth::user()->present()->avatar(20) }}" alt="">
        <strong>{{ Auth::user()->name }}</strong>
         <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <div class="navbar-login">
                <div class="row">
                    <div class="col-lg-4">
                        <p class="text-center">
                            <img src="{{ Auth::user()->present()->avatar(87) }}" alt="">
                        </p>
                    </div>
                    <div class="col-lg-8">
                        <p class="text-left"><strong>{{ Auth::user()->name }}</strong></p>
                        <p class="text-left">
                            <a href="/account" class="btn btn-primary btn-block btn-sm">My Account</a>
                            @if (Auth::user()->hasRole('admin'))
                                <a href="/admin" class="btn btn-default btn-block btn-sm"><i class="fa fa-lock"></i> Admin</a>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </li>
        <li class="divider"></li>
        <li>
            <div class="navbar-login navbar-login-session">
                <div class="row">
                    <div class="col-lg-12">
                        <p>
                            <a href="/logout" class="btn btn-danger btn-block">Logout</a>
                        </p>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</li>
@else
<li>
    <a href="/login" class="">Login</a>
</li>
@endif