@if ( Session::has('alert') )
<div class="top-buffer alert alert-dismissable alert-{{ Session::get('alert-class', 'info') }} alert-block"  role="alert">
	 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	{{ Session::get('alert') }}
</div>
@endif
