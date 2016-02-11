@extends('admin.layouts.admin')

@section('title')
{{ $title or 'Attributes' }}
@stop

@section('heading')
{{ $title or 'Attributes' }}
@stop

@section('admin.content')

<p>
    <a href="{{route('admin.attributes.create')}}" class="btn btn-success pull-right">New Attribute</a>
</p>
<p class="clearfix"></p>

<div class="box box-primary">
    <div class="box-body">


        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Attribute</th>
                    <th>Properties</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($terms as $attribute => $properties)
                <tr>
                    <td>
                        <strong>{{ Present::labelText($attribute) }}</strong>
                    </td>
                    <td>{{ $properties->implode('term', ', ') }}</td>
                    <td>
                        <a href="{{ route('admin.attributes.edit', $attribute) }}"><i class="fa fa-pencil"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
</div>

@stop
