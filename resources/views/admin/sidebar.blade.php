<ul class="sidebar-nav">
    <li class="sidebar-brand">
        <a href="#">
            Creuset
        </a>
    </li>
    <li>
        <a href="{{ route('admin.dashboard') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
    </li>
    <li>
        <a href="{{ route('admin.posts.index') }}"><i class="fa fa-fw fa-files-o"></i> Posts</a>
        <ul>
            <li><a href="{{ route('admin.posts.index') }}">All Posts</a></li>
            <li><a href="{{ route('admin.posts.create') }}">New Post</a></li>
            <li><a href="{{ route('admin.categories.index') }}">Categories</a></li>
            <li><a href="{{ route('admin.tags.index') }}">Tags</a></li>
        </ul>
    </li>

    <li>
        <a href="{{ route('admin.images.index') }}"><i class="fa fa-fw fa-image"></i> Images</a>
        <ul>
            <li><a href="{{ route('admin.images.index') }}">All Images</a></li>
        </ul>
    </li>

    <li>
        <a href="{{ route('admin.users.index') }}"><i class="fa fa-fw fa-users"></i> Users</a>
        <ul>
            <li><a href="{{ route('admin.users.profile') }}">My Profile</a></li>
            <li><a href="{{ route('admin.users.index') }}">All Users</a></li>
            <li><a href="{{ route('admin.users.create') }}">New User</a></li>
        </ul>
    </li>
</ul>
