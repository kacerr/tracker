@extends('layouts.master')

@section('content')
<div class="row">
	<div class="span8 offset2">
		<div class="well">
			<?php /* quick fix for the "action" variable */
			if (!isset($action)) $action="";
			/* end of fix */
			?>
			<legend>Add new todo</legend>
			{{ Form::open(array('url' => '/todo')) }}
			@if ($action=="edit")
				{{ Form::hidden('id',$todo->id) }}
				{{ Form::text('topic',$todo->topic, array('class' => 'span7', 'placeholder' => 'todo topic')) }}
			@else
				{{ Form::text('topic','', array('class' => 'span7', 'placeholder' => 'todo topic')) }}
			@endif
			<br>
			@if ($action=="edit")
				{{ Form::textarea('description',$todo->description, array('class' => 'span7', 'placeholder' => 'todo content')) }}
			@else
				{{ Form::textarea('description','', array('class' => 'span7', 'placeholder' => 'todo content')) }}
			@endif
			<br>
			<label>visible:
				@if ($action=="edit")
					{{ Form::checkbox('visible','1', $todo->visible,  array('id' => 'chkVisible', 'class' => 'span7', 'placeholder' => 'todo content')) }}
				@else
					{{ Form::checkbox('visible','1', 'false',  array('id' => 'chkVisible', 'class' => 'span7', 'placeholder' => 'todo content')) }}
				@endif
			 </label> 
			<br>
			<?php
				if ($action=="edit") $status = $todo->status; else $status=1;
			?>
			{{ Form::select('status', Todo::$status, $status)}}
			{{ Form::submit('Save post', array('class' => 'btn btn-warning')) }}

			{{ Form::close() }}
		</div>
	</div>
</div>
@stop