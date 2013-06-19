@extends('layouts.master')

@section('content')
<div class="row">
	<div class="span4 offset4">
		<div class="well">
			<legend>Please register</legend>
			{{ Form::open(array('url' => '/password/reset')) }}
			Enter new password here, it will be changed immediately
			{{ Form::hidden('user_id', $passwordRecovery->user_id) }}
			{{ Form::hidden('token', $passwordRecovery->token) }}
			{{ Form::password('password', array('class' => 'span3', 'placeholder' => 'Password')) }}
			{{ Form::submit('Reset password', array('class' => 'btn btn-warning')) }}

			{{ Form::close()}}
		</div>
	</div>
</div>
@stop