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
</ul>
