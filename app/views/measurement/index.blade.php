@extends('layouts.master')

@section('content')
<div class="row">
	<div class="span12 offset3">
		<div class="well">
			<legend>
				{{ $title }}
				<span class="nav pull-right">
					{{ HTML::link('measurement/create','add measurement') }}
				</span>
			</legend>
			@foreach (measurement::all() as $measurement)
				@if ($measurement->visible)
					<span>
				@else
					<span style="color: lightsteelblue;">
				@endif
				<b>{{ $measurement->name }}: </b>{{ $measurement->value }}, taken: {{ $measurement->taken }} </b>
				{{ Form::open(array('url' => '/measurement/' . $measurement->id, 'method' => 'DELETE', 'style' => 'display: inline;')) }}
					{{ Form::submit('delete', array('class' => 'btn-mini btn-danger')) }}
			    {{ Form::close() }}
				{{ Form::open(array('url' => '/measurement/' . $measurement->id . "/edit/", 'method' => 'GET', 'style' => 'display: inline;')) }}
					{{ Form::submit('edit', array('class' => 'btn-mini btn-warning')) }}
			    {{ Form::close() }}
					</span>
					<br>
					{{ $measurement->description }}
					<div style="height:8px; margin-top: 4px; border-top: 1px black solid;">&nbsp;</div>
			@endforeach
		</div>
	</div>
</div>
@stop
