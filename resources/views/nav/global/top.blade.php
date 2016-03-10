<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="{{ URL::to('/') }}">
				<img class="easy-logo" alt="Brand" src="{{asset('/assets/logo.png')}}">
			</a>
		</div>

		@unless (Auth::guest())
		@if (!((isset($is_setup) && $is_setup == true)))
			<div class="col-sm-3 collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-left">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Projects <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="{{ url('/projects') }}"><i class="picon top-menu-picon picon-database-2"></i>List</a></li>
							<li><a href="{{ url('/projects/create') }}"><i class="glyphicon glyphicon-plus top-menu-picon"></i>Create</a></li>
							@if(App\Project::all()->count() > 0)
								<li role="separator" class="divider"></li>
								<?php $cur_status = 0; ?>
								@foreach (App\Project::orderBy('status_id')->get() as $prj)
								@if($cur_status != $prj->status->id && $prj->status->id >= 4)
									@if($cur_status < 4)
									<li role="separator" class="divider"></li>
									@endif
									<?php $cur_status = $prj->status->id; ?>
								@endif
								<?php $url = '/project/'.$prj->id; ?>
								<li><a href="{{ url($url) }}"><img class="project-icon" src="{{$prj->getProjectIcon()}}" />&nbsp;{{$prj->name.'&nbsp;('.($prj->code).')'}}</a></li>
								@endforeach
							@endif
						</ul>
					</li>
					@if(App\Project::all()->count() > 0)
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Issues <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/tasks') }}">List</a></li>
								<li><a href="{{ url('/tasks/create') }}">Create</a></li>
							</ul>
						</li>
					@endif
					<li>
						<a href="{{url('/timesheet')}}" class="dropdown-toggle" role="button" aria-expanded="false">Timesheet</a>
					</li>
				</ul>
			</div>
		@endif
		@endunless

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
			<ul class="nav navbar-nav navbar-right {{(Auth::guest())?'login-tools':''}}">
				@if (Auth::guest())
					<li><a href="{{ url('/auth/login') }}">Login</a></li>
					<li><a href="{{ url('/auth/register') }}">Register</a></li>
				@else
					@include('nav.global.search')
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
					  		<img class="img-circle" id="top_header_avatar" width="24" height="24" src="{{Auth::user()->getAvatarURI()}}" onerror="this.src='{{ asset('css/icons/ic_account_circle_grey600_36dp.png') }}'" />&nbsp;&nbsp;
							{{ Auth::user()->name }} <span class="caret"></span></a>

						<ul class="dropdown-menu" role="menu">
							@if(Auth::check() && Auth::user()->privileges->id == 1)
							<li><a href="{{ url('/setup') }}"><div class="picon picon-gears-setting inline">&nbsp;</div><span>Easy Agile Setup</span></a></li>
							<li role="separator" class="divider"></li>
							@endif
							<li><a href="{{ url('/account') }}"><div class="picon picon-address-book inline">&nbsp;</div><span>My Account</span></a></li>
							<li role="separator" class="divider"></li>
							<li><a href="{{ url('/auth/logout') }}"><i class="picon picon-power-off">&nbsp;</i><span>Logout</span></a></li>
						</ul>
					</li>
				@endif
			</ul>
		</div>
	</div>
</nav>

@if(isset($header) && $header!='')
	@include($header)
@endif
