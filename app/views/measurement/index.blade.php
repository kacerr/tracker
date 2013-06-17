@extends('layouts.master')

@section('content')
<div class="row">
	<div class="span12 offset3">
		<div class="well">
			<legend>
				{{ $title }}
				<span class="nav pull-right">
					{{ HTML::link('measurement/create','add measurement') }}
				</span>
			</legend>
			@foreach (measurement::all() as $measurement)
				@if ($measurement->visible)
					<span>
				@else
					<span style="color: lightsteelblue;">
				@endif
				<b>{{ $measurement->name }}: </b>{{ $measurement->value }}, taken: {{ $measurement->taken }} </b>
				{{ Form::open(array('url' => '/measurement/' . $measurement->id, 'method' => 'DELETE', 'style' => 'display: inline;')) }}
					{{ Form::submit('delete', array('class' => 'btn-mini btn-danger')) }}
			    {{ Form::close() }}
				{{ Form::open(array('url' => '/measurement/' . $measurement->id . "/edit/", 'method' => 'GET', 'style' => 'display: inline;')) }}
					{{ Form::submit('edit', array('class' => 'btn-mini btn-warning')) }}
			    {{ Form::close() }}
					</span>
					<br>
					{{ $measurement->description }}
					<div style="height:8px; margin-top: 4px; border-top: 1px black solid;">&nbsp;</div>
			@endforeach
		</div>
	</div>
</div>
<!-- experimental graph drawing -->
<script src="/js/jquery.flot.js"></script>
<script src="/js/jquery.flot.time.js"></script>
<script language="javascript">
    $( document ).ready(function() 
    {
        request='/measurement?json=true&name=weight';
        //jsDebug(request);
        getResult=$.ajax({url: request, dataType: 'json', async: false});
        if (getResult.status=='200')
        {
            oObjects = $.parseJSON(getResult.responseText);
            var aValues	 = [];
            htmlValues = '';
            for (i in oObjects)
            {
            	aValues.push([oObjects[i][0]*1000, parseInt(oObjects[i][1])]);
            	htmlValues += oObjects[i][0]*1000 + ', ' + oObjects[i][1] + '<br>';
            }
            
    
		    $.plot($("#placeholder"), [ aValues ], {
        			xaxis: { 
        			 mode: "time", 
        			 min: new Date(2013, 5, 8).getTime(),
        			 max: new Date(2013, 5, 22).getTime(),
        			 minTickSize: [1, "day"], 
        			 timeformat: "%d.%m.%Y"}
        			}
        		);

            /*alert(aValues);
            var d2 = [[0, 3], [4, 8], [8, 5], [9, 13]];
            #alert (d2);
            $('#data').html(htmlValues);
        	#$.plot($("#placeholder"), d2);

        	/*, { 
        			yaxis: { }, 
        			xaxis: { 
        			}
        		});
        	/*
        				max: 200, min:1 
        				min: 1371081600000,
        				max: 1371349000000
        			 mode: "time", 
        			 min: new Date(2013, 5, 8).getTime(),
        			 max: new Date(2013, 5, 22).getTime(),
        			 minTickSize: [1, "day"], 
        			 timeformat: "%d.%m.%Y"}


        	*/
        	//alert (new Date(2013, 4, 0).getTime() + ' -  ' + new Date(2013, 6, 31).getTime());
        }
    });
</script>
<div class="row">
	<div class="span9 offset3 well">
		<div id="placeholder" style="width:600px;height:300px"></div>
		<div class="data" id="data"></div>
	</div>
</div>
@stop
