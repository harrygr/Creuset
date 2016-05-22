<form class="form" action="{{ route('shop.search') }}" method="get">

    <div class="input-group">
      {!! Form::text('query', Request::get('query'), ['class' => 'form-control', 'placeholder' => 'Search Products']) !!}
      <span class="input-group-btn">
        <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
      </span>
    </div><!-- /input-group -->

</form>
