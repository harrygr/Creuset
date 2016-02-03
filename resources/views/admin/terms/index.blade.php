@extends('admin.layouts.admin')

@section('title')
{{ $title or 'Terms' }}
@stop

@section('heading')
{{ $title or 'Terms' }}
@stop

@section('admin.content')

<div class="box box-primary">
    <div class="box-body">

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Slug</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($terms as $term)
            <tr>
                <td>
                    <strong>{{ $term->term }}</strong>
                    <div class="row-actions">
                        <a href="{{ route('admin.terms.edit', [$term->id]) }}">Edit</a> |
                        <a href="{{ route('admin.terms.delete', [$term->id]) }}" id="delete-{{ $term->id }}" data-method="delete" data-confirm="Are you sure?" class="text-danger" rel="nofollow">Trash</a>
                    </div>
                </td>
                <td>{{ $term->slug }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{--!! $posts->render() !!--}}
</div>
</div>

@stop
