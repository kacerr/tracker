@extends('layouts.master')

@section('content')
<div class="row">
	<div class="span12 offset3">
		<div class="well">
			<legend>
				{{ $title }}
				<span class="nav pull-right">
					{{ HTML::link('todo/create','add todo') }}
				</span>
			</legend>
			@foreach (Todo::all() as $todo)
				@if ($todo->visible)
					<span>
				@else
					<span style="color: lightsteelblue;">
				@endif
				<b>{{ $todo->topic }}</b>, posted by: {{ $todo->author->email }} </b>
				{{ Form::open(array('url' => '/todo/' . $todo->id, 'method' => 'DELETE', 'style' => 'display: inline;')) }}
					{{ Form::submit('delete', array('class' => 'btn-mini btn-danger')) }}
			    {{ Form::close() }}
				{{ Form::open(array('url' => '/todo/' . $todo->id . "/edit/", 'method' => 'GET', 'style' => 'display: inline;')) }}
					{{ Form::submit('edit', array('class' => 'btn-mini btn-warning')) }}
			    {{ Form::close() }}
					</span>
					<br>
					{{ $todo->description }}
					<div style="height:8px; margin-top: 4px; border-top: 1px black solid;">&nbsp;</div>
			@endforeach
		</div>
	</div>
</div>
@stop
