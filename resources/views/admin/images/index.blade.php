@extends('admin.layouts.admin')

@section('title')
Images
@stop

@section('admin.content')

    <h1>{{$title or 'Images'}}</h1>

    <div class="panel panel-default">
        <div class="panel-body">

        <table class="table table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th>File</th>
                    <th>Author</th>
                    <th>Parent</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($images as $image)
                <tr>
                    <td><img src="/{{ $image->thumbnail_path }}" alt="" width="50" height="50"></td>
                    <td>{!! $image->present()->title() !!}</td>
                    <td>{{ $image->present()->owner() }}</td>
                    <td>
                    <a href="{{ $image->present()->parentUrl() }}">
                    {{ $image->present()->parent() }}
                    </a>
                    </td>
                    <td>{{ $image->created_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        {!! $images->render() !!}
        </div>
    </div>
@stop