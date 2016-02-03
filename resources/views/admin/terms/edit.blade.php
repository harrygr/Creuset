@extends('admin.layouts.admin')

@section('title')
Edit {{ $term->getTaxonomy() }}
@stop

@section('heading')
Edit {{ $term->getTaxonomy() }}
@stop

@section('admin.content')

<div class="box box-primary">
    <div class="box-body">
        {!! Form::model($term, ['method' => 'PATCH', 'route' => ['admin.terms.update', $term]]) !!}
        
        {!! Form::hidden('taxonomy') !!}

        <div class="row">
        <div class="form-group col-sm-6 {{ $errors->has('term') ? 'has-error' : '' }}">
            {!! Form::label('term', 'Term') !!}
            {!! Form::text('term', null, ['class' => 'form-control']) !!}
            {!! $errors->has('term') ? '<span class="help-block">'.$errors->first('term').'</span>' : '' !!}
        </div>

        <div class="form-group col-sm-6 {{ $errors->has('slug') ? 'has-error' : '' }}">
            {!! Form::label('slug', 'Slug') !!}
            {!! Form::text('slug', null, ['class' => 'form-control']) !!}
            {!! $errors->has('slug') ? '<span class="help-block">'.$errors->first('slug').'</span>' : '' !!}
        </div>
        </div>
        
        <button type="submit" name="submit" class="btn btn-primary">Update {{ $term->getTaxonomy() }}</button>
        {!! Form::close() !!}
    </div>
</div>

@stop
