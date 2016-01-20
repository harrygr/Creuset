@extends('admin.layouts.admin')

@section('title')
Media
@stop

@section('heading')
{{$title or 'Images'}}
@stop

@section('admin.content')

    <div class="box box-primary">
        <div class="box-body">

        <table class="table table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th>File</th>
                    <th>Parent</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($media as $item)
                <tr>
                    <td><img src="{{ $item->thumbnail_url }}" alt="" width="50" height="50"></td>
                    <td>
                    <a href="{{ $item->getUrl() }}">
                    {{ $item->name }}
                    </a>
                    <br>
                    <a href="{{ route('admin.media.delete', $item->id) }}" id="delete-{{ $item->id }}" data-method="delete" class="text-danger" data-confirm="Are you sure?">Delete</a>
                    </td>
                    <td>
                    <a href="{{ $item->model->getEditUri() }}">
                    {{ $item->model->getName() }}
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