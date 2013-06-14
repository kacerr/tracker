@extends('layouts.master')

@section('content')
<div class="row">
	<div class="span12 well">

	What to say about that? I was thinking for longer time about writing some kind of "tracker" for me. It can track workouts, food consumption, money expenditures, weight, work progress ... just about anything.

	The time to do this came with the need to learn a new web development technology and to excercise my skills on something.
	Here we go, Laravel 4, Twitter bootstrap, something else coming?
	[2013-06-12]

	</div>
</div>
<div class="row">
	@foreach (Blogpost::where('visible', '=', '1')->get() as $blogpost)
	<div class="span12">
		<div class="hero-unit" style="padding:20px;">
			<h1 style="display: inline;">{{ $blogpost->title }} </h1> posted by: {{ $blogpost->author->email }} / {{  $blogpost->updated_at }}
			<hr style="border-color:black;">
			<p>{{ $blogpost->content }}</p>
		</div>
	</div>
	@endforeach
</div>

@stop