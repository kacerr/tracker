@if (isset($errors) && count($errors->all()) > 0)
<div class="alert alert-error">
	<a class="close" href="#" data-dismiss="alert">x</a>
	<h4 class="alert-heading">Error occured!</h4>
	<ul>
		@foreach ($errors->all() as $message)
			<li>{{  $message }} </li>
		@endforeach
	</ul>
</div>
@endif

@if (Session::has('flash_notice'))
<div class="alert alert-notice">
	<a class="close" href="#" data-dismiss="alert">x</a>
	<h4 class="alert-heading">Notice!</h4>
	<ul>
		{{ Session::get('flash_notice') }}
	</ul>
</div>
@endif