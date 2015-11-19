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
            @foreach ($media as $item)
                <tr>
                    <td><img src="{{ $item->thumbnail_url }}" alt="" width="50" height="50"></td>
                    <td>
                    {{ $item->name }}
                    <br>
                    <a href="{{ route('admin.images.delete', $item->id) }}" id="delete-{{ $item->id }}" data-method="delete" class="text-danger" data-confirm="Are you sure?">Delete</a>
                    </td>
                    <td>{{-- $image->present()->owner() --}}</td>
                    <td>
                    <a href="">
                    {{-- $image->present()->parent() --}}
                    </a>
                    </td>
                    <td>{{ $item->created_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        {!! $media->render() !!}
        </div>
    </div>
@stop