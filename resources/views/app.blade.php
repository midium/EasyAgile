<!DOCTYPE html>
<html lang="en" ng-app="app">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{env('APP_NAME')}}</title>

	<link rel="icon" type="image/png" href="{{asset('/assets/favicon.png')}}">

	<link href='//fonts.googleapis.com/css?family=Lato:400,300,100' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="{{ asset('/css/themes/'.((Auth::guest())?'default':Auth::user()->theme).'/bootstrap.min.css') }}">
	<link href="{{ asset('/css/common.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/themes/'.((Auth::guest())?'default':Auth::user()->theme).'/app.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/personal-icons.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/sweet-alert.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/jasny-bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/bootstrap-select.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">

	<script src="{{ asset('/js/jquery.min.js') }}"></script>
	<script src="{{ asset('/js/jets.min.js') }}"></script>
	<script src="{{ asset('/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('/js/moment.js') }}"></script>
	<script src="{{ asset('/js/transition.js') }}"></script>
	<script src="{{ asset('/js/collapse.js') }}"></script>
	<script src="{{ asset('/js/jasny-bootstrap.min.js') }}"></script>
	<script src="{{ asset('/js/sweet-alert.min.js') }}"></script>
	<script src="{{ asset('/js/bootstrap-select.min.js') }}"></script>
	<script src="{{ asset('/js/bootstrap-datetimepicker.min.js') }}"></script>

	@yield('top-js')

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="{{ asset('/js/html5shiv-3.7.2.js') }}"></script>
	<script src="{{ asset('/js/respond-1.4.2.js') }}"></script>
	<![endif]-->
</head>
<body>
@include('nav.global.top')

<div class="container-fluid {{(isset($container_overflow) && $container_overflow==true )?'overflowed':''}}">
	@yield('content')
</div>

@yield('js-includes')
@yield('css-includes')

@yield('beforebodyend')
</body>
</html>
