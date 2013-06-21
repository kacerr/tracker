<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>{{ $title }}</title>
	{{ HTML::style('css/bootstrap.css') }}
	{{ HTML::style('css/tracker.css') }}
	{{ HTML::script('js/jquery.js') }}
	{{ HTML::script('js/bootstrap.js') }}
	{{ HTML::script('js/tracker-help.js') }}

    <style type="text/css">

      /* Sticky footer styles
      -------------------------------------------------- */

      html,
      body {
        height: 100%;
        /* The html and body elements cannot have any padding or margin. */
      }

      /* Wrapper for page content to push down footer */
      #wrap {
        min-height: 100%;
        height: auto !important;
        height: 100%;
        /* Negative indent footer by it's height */
        margin: 0 auto -60px;
      }

      /* Set the fixed height of the footer here */
      #push,
      #footer {
      	  /* position: relative; */
      	  position: relative;
          margin-top: 0px; /* negative value of footer height */
          clear:both;
      }
      #footer {
        background-color: #f5f5f5;
      }

      </style>	
</head>
<body>
 <!--<div id="wrap">-->
	<div class="navbar">
		<div class="navbar-inner">
			@if(Auth::user())
				{{ HTML::link('/', 'TRaCKer::home', array('class' => 'brand')) }}
				{{ HTML::link('/user/dashboard', 'dashboard', array('class' => 'brand')) }}
			@else
				{{ HTML::link('/', 'TRaCKer', array('class' => 'brand')) }}
			@endif
			<ul class="nav pull-left">
				<li>{{ HTML::link('/codetest', 'test:code') }}</li>
				<li>{{ HTML::link('/download/tracker.tar.bz2', 'code:download') }}</li>
				<li>
					@if (Session::get('debug'))
						{{ HTML::link('/toggledebug', 'toggle:debug', array('style' => 'color: lightgreen')) }}
					@else
						{{ HTML::link('/toggledebug', 'toggle:debug', array('style' => 'color: red')) }}
					@endif
				</li>
			</ul>
			<ul class="nav pull-right">
				@if(Auth::user())
					<li>{{ HTML::link('measurement','Measurement') }}</li>
					<li>{{ HTML::link('todo','Todo') }}</li>
					<li>{{ HTML::link('blogpost','Blog') }}</li>
					<li>{{ HTML::link('profile','Profile') }}</li>
					<li>{{ HTML::link('logout','Logout') }}</li>
				@else
					<li>{{ HTML::link('login','Login') }}</li>
				@endif
			</ul>
		</div>
	</div>

	<div class="">
		@include('plugins.status')
		@yield('content')
		<div id="push"></div>
	</div>
 <!--</div>-->
 <!--<div style="clear:both">&nbsp;</div>-->
 @if (Session::get('debug'))
 <div class="row">
 	<div class="span16" id="footer">
		<div class="container" style="margin: 15px; width: 99%;">
			<p class="muted credit" style="margin-top: 5px;">
				<?php
					echo "Input::all() :: ";
					var_dump(Input::all());
					echo "<br>";
					echo "\$_GET :: ";
					foreach ($_GET as $key => $value)
					{
						echo "<b>" . htmlspecialchars($key) ." => </b>$value&nbsp;&nbsp; ";
					}
					echo "<br>";
					echo "\$_POST :: ";
					foreach ($_POST as $key => $value)
					{
						echo "<b>$key => </b>$value&nbsp;&nbsp; ";
					}
					echo "<br>";
					echo "\$_SESSION :: ";
					foreach ($_SESSION as $key => $value)
					{
						echo "<b>$key => </b>" . var_dump($value) . "&nbsp;&nbsp; ";
					}
					echo "<br>";
					echo "\$_SERVER :: ";
					foreach ($_SERVER as $key => $value)
					{
						echo "<b>$key => </b>$value&nbsp;&nbsp; ";
					}
					echo "<br>";
					global $sqlHistory;
					echo "<b>SQL:</b> " . $sqlHistory;
				?>
			</p>
				@if($errors->has())
					<p style="color:red"><b>ERRORS: </b><br>
					@foreach ($errors->all() as $error)
					   {{ $error }}
					   <br>
					@endforeach
				@endif
			</p>
		</div>
	</div>
 </div>
 @endif
 <?php if (Session::get("debug"))
 {
 }
 ?>
</body>
</html>