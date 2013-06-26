@extends('layouts.master')

@section('content')
<div class="row">
	<div class="span2 well">
		Welcome to your profile page {{ $user->email }}
	</div>
	<div class="span5 well">
		<legend>Edit profile</legend>
		{{ Form::open(array('url' => 'register')) }}
		{{ Form::text('email-disabled', Auth::user()->email, array('class' => 'span3 readOnly', 'placeholder' => 'Email', 'disabled' => 'disabled')) }}
		{{ Form::hidden('email', Auth::user()->email) }}
		{{ Form::hidden('action', 'update-profile') }}
		{{ Form::text('name', Auth::user()->name, array('class' => 'span3', 'placeholder' => 'Name')) }} (first name)
		{{ Form::text('surname', Auth::user()->surname, array('class' => 'span3', 'placeholder' => 'Last Name')) }} (last name)
		<!-- 
		{{ Form::password('password', array('class' => 'span3', 'placeholder' => 'Password')) }}
		-->
		{{ Form::submit('Update', array('class' => 'btn btn-warning')) }}

		{{ Form::close()}}

		<div style="border-bottom: 1px solid #e5e5e5;">Extended attributes</div>
		@foreach ($extendedAttributes as $extendedAttribute)
			<div id="div-extended-attribute-{{$extendedAttribute->id}}">
				{{ Form::text('extended-attribute-' . $extendedAttribute->id, $extendedAttribute->value, array('class' => 'span3', 'placeholder' => $extendedAttribute->extended_attribute_type->name)) }} ( {{ $extendedAttribute->extended_attribute_type->name }} )
				<button class="btn-tracker-default" onclick="confirmDelete('extendedAttribute', '{{ $extendedAttribute->id }}')" title="delete"><i class="icon-trash _icon-large"></i></button>
			</div>
		@endforeach
		<div><button class="btn-tracker-default" onclick="addAttributeDialog();"><i class="icon-plus _icon-large"></i>add attribute</button></div>
	</div>	
</div>

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
			"parentID": {{ $user->id}},
			"parentType": "User"
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


@stop
 