{!! Form::open(['url' => $url, 'method' => 'DELETE', 'class' => 'form-inline', 'style' => 'display:inline', 'onsubmit' => "return confirm('Are you sure?');"]) !!}
    <button type="submit" class="btn btn-link"><span class="text-danger">{{ $link_text or 'Delete'}}</span></button>
{!! Form::close() !!}
