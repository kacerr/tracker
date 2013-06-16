@extends('layouts.master')

@section('content')
<div class="row">
	<div class="span12 offset3 well ">
			<legend>
				{{ $title }}
				<span class="nav pull-right">
					{{ HTML::link('blogpost/create','add post') }}
				</span>
			</legend>
			@foreach ($blogposts as $blogpost)
				@if ($blogpost->visible)
					<span>
				@else
					<span style="color: lightsteelblue;">
				@endif
				<b>{{ $blogpost->title }} </b>, posted by: {{ $blogpost->author->email }} </b>
				{{ Form::open(array('url' => '/blogpost/' . $blogpost->id, 'method' => 'DELETE', 'style' => 'display: inline;')) }}
					{{ Form::submit('delete', array('class' => 'btn-mini btn-danger')) }}
			    {{ Form::close() }}
				{{ Form::open(array('url' => '/blogpost/' . $blogpost->id . "/edit/", 'method' => 'GET', 'style' => 'display: inline;')) }}
					{{ Form::submit('edit', array('class' => 'btn-mini btn-warning')) }}
			    {{ Form::close() }}
				<br>
				{{ $blogpost->content }}
				<hr>
					</span>
			@endforeach
	</div>
	<div class="span1 well pull-left">
		Labels: <br>
		{{ HTML::link('blogpost', 'all') }}
		<br>
		@foreach ($labels as $label)
			{{ HTML::link('blogpost?label=' . $label->id, $label->label) }}
			<br>
		@endforeach
	</div>
</div>
@stop
