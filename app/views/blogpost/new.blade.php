@extends('layouts.master')

@section('content')
<div class="row">
	<div class="span8 offset2 well">
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
			<div class="control-group">
				<label>visible:
					@if ($action=="edit")
						{{ Form::checkbox('visible','1', $blogpost->visible,  array('id' => 'chkVisible', 'class' => 'span7', 'placeholder' => 'blog content')) }}
					@else
						{{ Form::checkbox('visible','1', 'false',  array('id' => 'chkVisible', 'class' => 'span7', 'placeholder' => 'blog content')) }}
					@endif
				</label>
			</div>
			<div class="control-group">
				Labels: 
				@foreach (Label::all() as $label)
						{{ Form::checkbox('label[]',$label->id, Label::isLabelSet($label->id, $setLabels), array('id' => 'chkLabel' . $label->id)) }}
						<label for "{{ $label->id }}" style="display: inline;">{{$label->label}}</label>
				@endforeach
			</div>
			{{ Form::submit('Save post', array('class' => 'btn btn-warning')) }}

			{{ Form::close() }}
			@if ($action=="edit")
			<div class="control-group">
				<div style="border-bottom: 1px solid #e5e5e5;">Extended attributes</div>
				@foreach ($extendedAttributes as $extendedAttribute)
					<div id="div-extended-attribute-{{$extendedAttribute->id}}">
						{{ Form::text('extended-attribute-' . $extendedAttribute->id, $extendedAttribute->value, array('class' => 'span3', 'placeholder' => $extendedAttribute->extended_attribute_type->name)) }} ( {{ $extendedAttribute->extended_attribute_type->name }} )
						<button class="btn-tracker-default" onclick="confirmDelete('extendedAttribute', '{{ $extendedAttribute->id }}')" title="delete"><i class="icon-trash _icon-large"></i></button>
					</div>
				@endforeach
			</div>	
			<div class="control-group">
				<div>
					<button class="btn-tracker-default" onclick="addAttributeDialog();"><i class="icon-plus _icon-large"></i>add attribute</button>
				</div>
			</div>
			@endif
	</div>
</div>



@if ($action=="edit")
	<script language="javascript">
		function deleteConfirmed()
		{
			// here we are going to make ajax call to the backend to delete element
			//alert ('going to delete element id: ' + $('#idToDelete').html());
			$('#confirmDeleteDialog').modal('hide'); 		
	        id = $('#idToDelete').html();
	        request='/extendedAttribute/' + id;
	        requestType='DELETE';
	        jsDebug(requestType + ": " + request);
	        result=$.ajax({
	        	url: request, 
	        	type: requestType,
	        	dataType: 'json', 
	        	async: false
	        });		
			$('#div-extended-attribute-' + id ).hide();
		}


		function addAttributeDialog()
		{
			$('#addAttributeDialog').modal();
		}

		function addAttribute()
		{
			value = $('#attributeValue').val();
			attributeID = $('#attributeType').val();
			request='/extendedAttribute';
			requestType='POST';
			dataPayload = {
				"attributeTypeID": attributeID,
				"value": value,
				"parentID": {{ $blogpost->id}},
				"parentType": "Blogpost"
				}

	      result = $.ajax({
	        	url: request, 
	        	data: dataPayload, 
	        	method: "POST",
	        	success: function(data)
	        	{
	        		result = data;
	        	},
	        	dataType: 'json',
	        	async: false
	        });

			$('#addAttributeDialog').modal('hide');
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
    <input type="hidden" name="_method" value="DELETE">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary" onclick="deleteConfirmed();">Delete !!!</button>
  </div>
</div>

	
<!-- Modal add attribute -->

<div id="addAttributeDialog" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Add attribute</h3>
  </div>
  <div class="modal-body">
	<select name="attributeType" id="attributeType">
  	@foreach ($attributeTypes as $attributeType)
		<option value="{{ $attributeType->id }} ">{{ $attributeType->name }}</option>
  	@endforeach
  	</select>
  	<input type="text" class="span3" name="attributeValue" id="attributeValue"></input>
  </div>
  <div class="modal-footer">
    <input type="hidden" name="_method" value="PUT">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary" onclick="addAttribute();">Add attribute</button>
  </div>
</div> 
@endif

@stop