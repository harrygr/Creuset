
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    {!! Form::text('title', null, ['class' => 'form-control input-lg', 'placeholder' => 'Title']) !!}
                </div>
                <div class="form-group">
                    {!! Form::text('slug', null, ['class' => 'form-control', 'placeholder' => 'Slug']) !!}
                </div>

                <div class="form-group">
                    {!! Form::textarea('content', null, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    {!! Form::label('published_at', 'Publish at') !!}
                    {!! Form::input('date', 'published_at', Carbon\Carbon::now()->format('Y-m-d'), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('user_id', 'Author') !!}
                    {!! Form::select('user_id', Creuset\User::lists('name', 'id'), \Auth::user()->id, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    </div>

    <script>


    </script>