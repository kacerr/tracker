@extends('layouts.master')

@section('content')
<div class="row">
	<div class="span12 offset3 well ">
			<legend>
				{{ $title }}
			</legend>
			@foreach ($challenges as $challenge)
				<div style="margin-top: 10px;">
					@if ($challenge->visible)
						<span>
					@else
						<span style="color: lightsteelblue;">
					@endif
					<b>{{ $challenge->title }} </b>, posted {{ $challenge->updated_at->format("d.m.Y") }} by: {{ $challenge->author->email }} </b>
					{{ $challenge->getHTMLContent() }}
					</span>
					@if (in_array($challenge->id, $aAcceptedChallenges))
						<div class="pull-right">
							<button class="btn-danger" onclick="accept({{ $challenge->id }},'unaccept');">X unaccept</button>
							<button class="btn-info">accepted already</button>
						</div>
					@else
						<div class="pull-right">
							<button class="btn-success" onclick="accept({{ $challenge->id }}, 'accept');">accept</button>
						</div>
					@endif
				</div>
				<div class="clearfix"></div>
				<div style="height:8px; margin-top: 4px; border-top: 1px black solid;">&nbsp;</div>

			@endforeach
			{{ $challenges->appends($urlParams)->links(); }}
	</div>
</div>


<script language="javascript">
	function accept(challengeID, action)
	{
		// here we are going to make ajax call to the backend to delete element
		//alert ('going to delete element id: ' + $('#idToDelete').html());
	    request='/challenges';
	    requestType='POST';
		dataPayload = {
			"challengeID": challengeID,
			"action": action
			}        
		result = $.ajax(
		{
        	url: request, 
        	method: "POST",
	    	data: dataPayload, 
        	success: function(data)
        	{
        		result = data;
        	}, 
	       	dataType: 'json',
        	async: false
        });
	}
</script>


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

@stop