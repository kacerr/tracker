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
				@if ($todo->status==3) <?php $statusClass="text-success"; ?>
				@else <?php $statusClass="";?>
				@endif
				<div class="{{ $statusClass }}">
				<b>{{ $todo->topic }}</b>, posted by: {{ $todo->author->email }} </b>
				<!--{{ Form::open(array('url' => '/todo/' . $todo->id, 'method' => 'DELETE', 'style' => 'display: inline;')) }} -->
					{{ Form::button('delete', array('class' => 'btn-mini btn-danger', 'onclick' => 'confirmDelete("todo", ' . $todo->id . ')')) }}
			    <!--{{ Form::close() }} -->
				{{ Form::open(array('url' => '/todo/' . $todo->id . "/edit/", 'method' => 'GET', 'style' => 'display: inline;')) }}
					{{ Form::submit('edit', array('class' => 'btn-mini btn-warning')) }}
			    {{ Form::close() }}
					</span>
					<br>
					{{ $todo->description }}
				</div>
				<div style="height:8px; margin-top: 4px; border-top: 1px black solid;">&nbsp;</div>
			@endforeach
		</div>
	</div>
</div>

@stop

<!-- Modal deletion confirmation -->
<div id="confirmDeleteDialog" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Delete item confirmation</h3>
  </div>
  <div class="modal-body">
    <p>Are you sure you want to delete item with id: <span id="idToDelete"></span></p>
  </div>
  <div class="modal-footer">
  	<form id="deleteForm" method="POST" action="" style="inline">
  		<input type="hidden" name="_method" value="DELETE">
    	<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    	<input type="submit" value="Delete !!!" class="btn btn-primary"></input>
    </form>
  </div>
</div>

