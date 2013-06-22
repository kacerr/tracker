@extends('layouts.master')

@section('content')
<div class="row">
	<div class="span12 offset3 well ">
			<legend>
				{{ $title }}
				<span class="nav pull-right">
					@if ($currentUser) 
						<a href="/blogpost/create">
							<button class="btn-tracker-default"><i class="icon-plus _icon-large"></i>add post</button>
						</a>
					@endif
				</span>
			</legend>
			@foreach ($blogposts as $blogpost)
				<div style="margin-top: 10px;">
					@if ($blogpost->visible)
						<span>
					@else
						<span style="color: lightsteelblue;">
					@endif
					<b>{{ $blogpost->title }} </b>, posted {{ $blogpost->updated_at->format("d.m.Y") }} by: {{ $blogpost->author->email }} </b>
					@if ($currentUser) 
						{{ Form::open(array('id' => 'edit_' . $blogpost->id, 'url' => '/blogpost/' . $blogpost->id . "/edit/", 'method' => 'GET', 'style' => 'display: inline;')) }}
							<button class="btn-tracker-defaul
							t" onclick="$('#edit_{{ $blogpost->id }}').submit();" title="edit"><i class="icon-edit _icon-large"></i></button>
					    {{ Form::close() }}
						<button class="btn-tracker-default" onclick="confirmDelete('blogpost', '{{ $blogpost->id }}')" title="delete"><i class="icon-trash _icon-large"></i></button>
				    @endif
					<br>
					{{ $blogpost->getHTMLContent() }}
					</span>
				</div>
				<div style="height:8px; margin-top: 4px; border-top: 1px black solid;">&nbsp;</div>

			@endforeach
			{{ $blogposts->appends($urlParams)->links(); }}
	</div>
	@if ($currentUser) 
	<div class="span1 well pull-left">
		Labels: <br>
		{{ HTML::link('blogpost', 'all') }}
		<br>
		@foreach ($labels as $label)
			{{ HTML::link('blogpost?label=' . $label->id, $label->label) }}
			<br>
		@endforeach
	</div>
	@endif
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
