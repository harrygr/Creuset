<ul class="sidebar-menu">

    <li>
        <a href="{{ route('admin.dashboard') }}"><i class="fa fa-fw fa-dashboard"></i> <span>Dashboard</span></a>
    </li>

    <li class="treeview">
        <a href="{{ route('admin.pages.index') }}"><i class="fa fa-fw fa-files-o"></i> <span>Pages</span></a>
        <ul class="treeview-menu">
            <li><a href="{{ route('admin.pages.index') }}"><i class="fa fa-circle-o"></i> All Pages</a></li>
            <li><a href="{{ route('admin.pages.create') }}"><i class="fa fa-circle-o"></i> New Page</a></li>
        </ul>
    </li>

    <li class="treeview">
        <a href="{{ route('admin.posts.index') }}"><i class="fa fa-fw fa-files-o"></i> <span>Posts</span></a>
        <ul class="treeview-menu">
            <li><a href="{{ route('admin.posts.index') }}"><i class="fa fa-circle-o"></i> All Posts</a></li>
            <li><a href="{{ route('admin.posts.create') }}"><i class="fa fa-circle-o"></i> New Post</a></li>
            <li><a href="{{ route('admin.categories.index') }}"><i class="fa fa-circle-o"></i> Categories</a></li>
            <li><a href="{{ route('admin.tags.index') }}"><i class="fa fa-circle-o"></i> Tags</a></li>
        </ul>
    </li>

    {{-- SHOP --}}
    <li class="treeview">
        <a href="{{ route('admin.products.index') }}"><i class="fa fa-fw fa-shopping-cart"></i> <span>Shop</span></a>
        <ul class="treeview-menu">
            <li><a href="{{ route('admin.products.index') }}"><i class="fa fa-circle-o"></i> All Products</a></li>
            <li><a href="{{ route('admin.products.create') }}"><i class="fa fa-circle-o"></i> New Product</a></li>
            <li><a href="{{ route('admin.terms.index', 'product_categories') }}"><i class="fa fa-circle-o"></i> Product Categories</a></li>
            <li><a href="{{ route('admin.attributes.index') }}"><i class="fa fa-circle-o"></i> Attributes</a></li>
            <li><a href="{{ route('admin.shipping_methods.index') }}"><i class="fa fa-circle-o"></i> Shipping Methods</a></li>
        </ul>
    </li>

    <li class="treeview">
        <a href="{{ route('admin.orders.index') }}"><i class="fa fa-fw fa-truck"></i> <span>Orders 
        @if ($order_count > 0)
        <span class="label label-primary pull-right">{{ $order_count }}</span>
        @endif
        </span></a>
        <ul class="treeview-menu">
            <li><a href="{{ route('admin.orders.index') }}"><i class="fa fa-circle-o"></i> All Orders</a></li>
        </ul>
    </li>

    <li class="treeview">
        <a href="{{ route('admin.media.index') }}"><i class="fa fa-fw fa-image"></i> <span>Media</span></a>
        <ul class="treeview-menu">
            <li><a href="{{ route('admin.media.index') }}"><i class="fa fa-circle-o"></i> All Images</a></li>
        </ul>
    </li>

    <li class="treeview">
        <a href="{{ route('admin.users.index') }}"><i class="fa fa-fw fa-users"></i> <span>Users</span></a>
        <ul class="treeview-menu">
            <li><a href="{{ route('admin.users.profile') }}"><i class="fa fa-circle-o"></i> My Profile</a></li>
            <li><a href="{{ route('admin.users.index') }}"><i class="fa fa-circle-o"></i> All Users</a></li>
            <li><a href="{{ route('admin.users.create') }}"><i class="fa fa-circle-o"></i> New User</a></li>
        </ul>
    </li>
</ul>
