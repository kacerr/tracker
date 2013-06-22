@extends('layouts.master')


@section('content')
<div class="row">
	<div class="span12 offset3">
		<div class="well">
			<legend>
				{{ $title }}
				<span class="nav pull-right">
					<a href="/todo/create">
						<button class="btn-tracker-default"><i class="icon-plus _icon-large"></i>add todo</button>
					</a>	
				</span>
			</legend>
			@foreach ($todos as $todo)
				@if ($todo->status==3) <?php $statusClass="text-success _completed"; ?>
				@elseif ($todo->status==2) <?php $statusClass="_in_progress"; ?>
				@else <?php $statusClass="";?>
				@endif
				@if ($todo->visible)
				@else
					<?php $statusClass.=" _not_visible"; ?>
				@endif
				<div class="{{ $statusClass }}" style="display: inline;">
				<b>{{ $todo->topic }}</b>, posted by: {{ $todo->author->email }} </b>
				</div>
				<div class="inline" style="margin-left: 8px; padding: 2px; display: inline;">
					{{ Form::open(array('id' => 'edit_' . $todo->id, 'url' => '/todo/' . $todo->id . "/edit/", 'method' => 'GET', 'style' => 'display: inline;')) }}
						<button class="btn-tracker-default" onclick="$('#edit_{{ $todo->id }}').submit();" title="edit"><i class="icon-edit _icon-large"></i></button>
				    {{ Form::close() }}
					<button class="btn-tracker-default" onclick="confirmDelete('todo', '{{ $todo->id }}')" title="delete"><i class="icon-trash _icon-large"></i></button>
				</div>
				<div class="{{ $statusClass }}">
					{{ $todo->description }}
				</div>
				
				<div style="height:8px; margin-top: 4px; border-top: 1px black solid;">&nbsp;</div>
			@endforeach
			{{ $todos->appends($urlParams)->links(); }}
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

