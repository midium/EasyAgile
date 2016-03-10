<nav class="navbar navbar-default project-header nav-fixed-top clearfix">
  <img class="img-circle avatar" id="header_avatar" width="50" height="50" src="{{$user->getAvatarURI()}}"  onerror="this.src='{{ asset('css/icons/ic_account_circle_grey600_36dp.png') }}'" />&nbsp;&nbsp;
	<span id="project_name">
		<h1 class="inline">{{$user->name}}</h1>
	</span>

  <input type="hidden" id="token" name="_token" value="<?= csrf_token() ?>" />
  <input type="hidden" id="uid" name="uid" value="{{$user->id}}" />

  <div id="month_navigator" class="inline">
    @include('nav.timesheet.navigator')
  </div>

  <div id="timesheet_export" class="inline pull-right">
    @include('nav.timesheet.export')
  </div>
</nav>
