@extends('layouts.master')

@section('content')
<div class="row">
	<div class="span2 well">
		Welcome to your profile page {{ ucwords(Auth::user()->email) }}
	</div>
	<div class="span4 well">
		<legend>Edit profile</legend>
		{{ Form::open(array('url' => 'register')) }}
		{{ Form::text('email-disabled', Auth::user()->email, array('class' => 'span3 readOnly', 'placeholder' => 'Email', 'disabled' => 'disabled')) }}
		{{ Form::hidden('email', Auth::user()->email) }}
		{{ Form::hidden('action', 'update-profile') }}
		{{ Form::text('name', Auth::user()->name, array('class' => 'span3', 'placeholder' => 'Name')) }} (first name)
		{{ Form::text('surname', Auth::user()->surname, array('class' => 'span3', 'placeholder' => 'Last Name')) }} (last name)
		<!-- 
		{{ Form::password('password', array('class' => 'span3', 'placeholder' => 'Password')) }}
		-->
		{{ Form::submit('Update', array('class' => 'btn btn-warning')) }}

		{{ Form::close()}}
	</div>	
</div>
@stop
 