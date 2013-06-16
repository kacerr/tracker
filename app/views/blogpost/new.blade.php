@extends('layouts.master')

@section('content')
<div class="row">
	<div class="span8 offset2">
		<div class="well">
			<?php /* quick fix for the "action" variable */
			/* all variables should be prepared before we start displaying the view !!!! */
			if (!isset($action)) $action="";
			/* end of fix */
			?>
			<legend>Add new blogpost</legend>
			{{ Form::open(array('url' => '/blogpost')) }}
			@if ($action=="edit")
				{{ Form::hidden('id',$blogpost->id) }}
				{{ Form::text('title',$blogpost->title, array('class' => 'span7', 'placeholder' => 'blog title')) }}
			@else
				{{ Form::text('title','', array('class' => 'span7', 'placeholder' => 'blog title')) }}
			@endif
			<br>
			@if ($action=="edit")
				{{ Form::textarea('content',$blogpost->content, array('class' => 'span7', 'placeholder' => 'blog content')) }}
			@else
				{{ Form::textarea('content','', array('class' => 'span7', 'placeholder' => 'blog content')) }}
			@endif
			<br>
			<label>visible:
				@if ($action=="edit")
					{{ Form::checkbox('visible','1', $blogpost->visible,  array('id' => 'chkVisible', 'class' => 'span7', 'placeholder' => 'blog content')) }}
				@else
					{{ Form::checkbox('visible','1', 'false',  array('id' => 'chkVisible', 'class' => 'span7', 'placeholder' => 'blog content')) }}
				@endif
			</label>
			<br>
			Labels: 
			@foreach (Label::all() as $label)
					{{ Form::checkbox('label[]',$label->id, Label::isLabelSet($label->id, $setLabels), array('id' => 'chkLabel' . $label->id)) }}
					<label for "{{ $label->id }}" style="display: inline;">{{$label->label}}</label>
			@endforeach
			<br>
			{{ Form::submit('Save post', array('class' => 'btn btn-warning')) }}

			{{ Form::close() }}
		</div>
	</div>
</div>
@stop