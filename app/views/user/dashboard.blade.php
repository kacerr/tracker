@extends('layouts.master')

@section('content')
<div class="row">
	<!--
	<div class="span2 well">
		{{ $user->name }} welcome to your dashboard
	</div>
	-->
	<div class="span6 offset3" style="padding:5px;">
		<div class="span3" style="margin-left: 0px; padding-left:0px;">
			<div class="span3">
				<a href="/measurement"><img src="/images/home/graphs_measurements.jpg" width="200" height="200" class="img-circle"></a>
			</div>
			<div class="span3" style="text-align: center;">
				<a href="/measurement">measurements & graphs</a>
			</div>
		</div>
		<div class="span3 pull-right">
			<div class="span3" style="">
				<a href="/blogpost"><img src="/images/home/blog_icon.png" width="200" height="200" class="img-circle"></a>
			</div>
			<div class="span3" style="text-align: center;">
				<a href="/measurement">blogs & notes</a>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="span6 offset3" style="padding:5px;">
		<div class="row" style="line-height:20px;">&nbsp;</div>
		<div class="span3 pull-left">
			<div class="span3" style="">
				<a href="/challenges"><img src="/images/home/challenge.jpg" width="200" height="200" class="img-circle"></a>
			</div>
			<div class="span3" style="text-align: center;">
				<a href="/challenges">challenges</a>
			</div>
		</div>
	</div>	
</div>
@stop
 