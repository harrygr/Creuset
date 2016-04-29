<div class="box box-primary ">
    <div class="box-body box-profile">
        <img class="profile-user-img img-responsive img-circle" src="{{ $user->present()->avatar(128) }}" alt="User profile picture">

        <h3 class="profile-username text-center">{{ $user->name }}</h3>
        @if ($user->autoCreated())
        <p class="text-muted text-center">
            <span class="label label-warning" title="{{ $user->name }} has never logged in; their account was created when placing an order.">Auto-Created</span>
        </p>
        @endif

        <ul class="list-group list-group-unbordered">
        <li class="list-group-item">
          <i class="fa fa-fw fa-truck"></i> <a href="{{ route('admin.users.orders', $user->username) }}"><b>Orders</b></a> <span class="pull-right">{{ $user->orders->count() }}</span>
        </li>
        <li class="list-group-item">
          <i class="fa fa-fw fa-map-marker"></i> <a href="{{ route('admin.users.addresses', $user->username) }}"><b>Addresses</b></a> <span class="pull-right">{{ $user->addresses->count() }}</span>
        </li>  
      </ul>
    </div>
</div>