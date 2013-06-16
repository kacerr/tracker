@extends('layouts.master')

@section('content')
<div class="row">
	<div class="span8 offset4">
		<div class="well">
			<legend>Add new measurement</legend>
			{{ Form::open(array('url' => '/measurement')) }}
			{{ Form::hidden('id',$measurement->id) }}
			{{ Form::text('name',$measurement->name, array('class' => 'span7', 'placeholder' => 'measurement name')) }}
			{{ Form::text('value',$measurement->value, array('class' => 'span7', 'placeholder' => 'measurement value')) }}
			{{ Form::text('taken',$measurement->taken, array('class' => 'span7', 'placeholder' => 'measurement date')) }}
			{{ Form::submit('Save measurement', array('class' => 'btn btn-warning')) }}

			{{ Form::close() }}
		</div>
	</div>
</div>
@stop