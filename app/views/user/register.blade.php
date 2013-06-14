@extends('layouts.master')

@section('content')
<div class="row">
	<div class="span4 offset4">
		<div class="well">
			<legend>Please register</legend>
			{{ Form::open(array('url' => 'register')) }}
			{{ Form::text('email','', array('class' => 'span3', 'placeholder' => 'Email')) }}
			{{ Form::text('name','', array('class' => 'span3', 'placeholder' => 'Name')) }}
			{{ Form::text('surname','', array('class' => 'span3', 'placeholder' => 'Last Name')) }}
			{{ Form::password('password', array('class' => 'span3', 'placeholder' => 'Password')) }}
			{{ Form::submit('Register', array('class' => 'btn btn-warning')) }}

			{{ Form::close()}}
		</div>
	</div>
</div>
@stop