@extends('layouts.master')

@section('content')
<div class="row">
	<div class="span6 offset1">
		<div class="well">
			<legend>
				{{ $title }}
				<span class="nav pull-right">
                    <a href="/measurement/create">
                        <button class="btn-tracker-default"><i class="icon-plus _icon-large"></i>add</button>
                    </a>    
				</span>
			</legend>
			@foreach ($measurements as $measurement)
                <div>
    				<b>{{ $measurement->name }}: </b>{{ $measurement->value }}, taken: {{ $measurement->taken }} </b>
                    <div class="pull-right">
                    {{ Form::open(array('id' => 'edit_' . $measurement->id, 'url' => '/measurement/' . $measurement->id . "/edit/", 'method' => 'GET', 'style' => 'display: inline;')) }}
                        <button class="btn-tracker-default" onclick="$('#edit_{{ $measurement->id }}').submit();" title="edit"><i class="icon-edit _icon-large"></i></button>
                    {{ Form::close() }}
                    <button class="btn-tracker-default" onclick="confirmDelete('measurement', '{{ $measurement->id }}')" title="delete"><i class="icon-trash _icon-large"></i></button>
                    </div>
                </div>
				<div style="height:8px; margin-top: 4px; border-top: 1px black solid;">&nbsp;</div>
			@endforeach
            {{ $measurements->appends($urlParams)->links(); }}
		</div>
	</div>
    <div class="span8 well">
        <div id="placeholder" style="width:600px;height:300px"></div>
        <div class="data" id="data"></div>
    </div>
    <div class="span2 well pull-left">
        Measurement names: <br>
        {{ HTML::link('/measurement', 'all') }}
        {{ Form::open(array('url' => '/measurement', 'method' => 'GET')) }}
        @for ($i = 0; $i < count($measurementNames); $i++)
            {{ Form::checkbox('name[]',$measurementNames[$i]->name, in_array($measurementNames[$i]->name, $names), array('id' => 'chkName' . $measurementNames[$i]->name)) }}
            <label for "{{ $measurementNames[$i]->name }}" style="display: inline;">{{$measurementNames[$i]->name }}</label>
            <br>
        @endfor
        <br>
        {{ Form::submit('Go !', array('class' => 'btn-small btn-warning')) }}
        {{ Form::close() }}
    </div>
</div>


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


<!-- experimental graph drawing -->
<script src="/js/jquery.flot.js"></script>
<script src="/js/jquery.flot.time.js"></script>
<script language="javascript">
    $( document ).ready(function() 
    {
        request='{{ $graphsRequest }}';
        //alert(request);
        //jsDebug(request);
        getResult=$.ajax({url: request, dataType: 'json', async: false});
        if (getResult.status=='200')
        {
            var aValues  = [];
            var aLabels = [];
            var iCounter = 0;
            oObjects = $.parseJSON(getResult.responseText);
            //alert (var_dump(oObjects));
            for (measurement in oObjects)
            {
                
                aLabels[iCounter] = measurement;
                aValues[iCounter]  = [];
                for (i in oObjects[measurement])
                {
                    aValues[iCounter].push([oObjects[measurement][i][0]*1000, parseInt(oObjects[measurement][i][1])]);
                }
                iCounter++;
            }
            //alert (var_dump(aValues));
            //alert(aValues[0]);

            /* we need to prepare array for ploting with labels */
            var aData = [];
            for (i=0; i<aValues.length; i++)
            {
                aData.push({data: aValues[i], label: aLabels[i]});
            }
            //alert (aData);


            $.plot($("#placeholder"), aData, {
                    xaxis: { 
                     mode: "time", 
                     min: new Date(2013, 5, 8).getTime(),
                     max: new Date(2013, 5, 22).getTime(),
                     minTickSize: [1, "day"], 
                     timeformat: "%d.%m.%Y"}
                    }
                    );
        }
    });
</script>
@stop
