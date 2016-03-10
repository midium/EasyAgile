<nav class="navbar navbar-default project-header nav-fixed-top clearfix">
  <img class="img-circle avatar" id="header_avatar" width="50" height="50" src="{{$user->getAvatarURI()}}"  onerror="this.src='{{ asset('css/icons/ic_account_circle_grey600_36dp.png') }}'" />&nbsp;&nbsp;
	<span id="project_name">
		<h1 class="inline">Profile: {{$user->name}}</h1>
	</span>
</nav>
