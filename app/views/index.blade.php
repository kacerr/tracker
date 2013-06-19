@extends('layouts.master')

@section('content')

<style>
	pre { font-family: monospace; font-size: 10px;}
</style>

<div class="row">
	<div class="span12 offset3">
		<div class="well">
			What to say about that? I was thinking for longer time about writing some kind of "tracker" for me. It can track workouts, food consumption, money expenditures, weight, work progress ... just about anything.

			The time to do this came with the need to learn a new web development technology and to excercise my skills on something.
			Here we go, Laravel 4, Twitter bootstrap, something else coming?
			[2013-06-12]
		</div>
	</div>
</div>

	<div class="span1 pull-right">
		&nbsp;
	</div>

	<div class="span4 well pull-right">
		<h4>
			{{ HTML::link('blogpost?label=2','History / changelog') }}
		</h4>
		@foreach (Label::find(2)->blogposts()->where('visible', '=', '1')->orderBy('updated_at', 'desc')->get() as $blogpost)
			<h5 style="">{{ $blogpost->updated_at->format("d.m.Y") }}: {{ $blogpost->title }} </h5> 
			<p>{{ $blogpost->content }}</p>
		@endforeach
	</div>


<div class="row">
	@foreach (Label::find(1)->blogposts()->where('visible', '=', '1')->orderBy('updated_at', 'desc')->get() as $blogpost)
	<div class="span9 offset3">
		<div class="hero-unit" style="padding:20px;">
			<h1 style="">{{ $blogpost->title }} </h1> 
			<p style="line-height: 20px; padding: 2px;">
				posted by: {{ $blogpost->author->email }} / {{  $blogpost->updated_at }}
				<br />
				labels:
				@foreach ($blogpost->labels()->get() as $label)
					{{ $label->label }}
				@endforeach
			</p>
			<hr style="border-color:black;">
			<p>{{ $blogpost->content }}</p>
		</div>
	</div>
	@endforeach
</div>

@stop