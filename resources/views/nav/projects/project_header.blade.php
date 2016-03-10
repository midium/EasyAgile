<nav class="navbar navbar-default project-header nav-fixed-top clearfix">
	@if(isset($project))
	<img class="project-icon-big inline" src="{{$project->getProjectIcon()}}" />
	<span id="project_name">
		<h1 class="inline">{{ $project->name }}</h1><h5 class="project-status inline">{{$project->status->name}}</h5>
	</span>

	@if(!isset($isSettings) || $isSettings == false)
	<div class="project-manager pull-right">
		<div><i class="picon picon-torso-business">&nbsp;</i><span>Manager: <span class="text-username">{{ ($project->manager != null && $project->manager != '')?$project->manager->name:'' }}</span></span></div>
		<div><i class="picon picon-archive">&nbsp;</i><span>Tasks: <span class="text-tasks">{{$project->tasks()->count()}}</span></span></div>
		@if(Auth::user()->role->id == 11 || Auth::user()->id == $project->manager->id)
		<div><i class="picon picon-gear">&nbsp;</i><a class="light-link" href="{{url('project').'/'.$project->id.'/settings'}}"><span>Settings</span></a></div>
		@endif
	</div>
	@if(!isset($header_no_buttons) || $header_no_buttons == false)
		@if($project->status->id == 1 || $project->status->id == 2 || $project->status->id == 3)
	<div class="project-tools pull-right clearfix">
		<a href="{{url('tasks/create/'.$project->id)}}" class="btn btn-default text-center" id="create_sprint"><i class="picon picon-repo-clone">&nbsp;</i>Create Sprint</a>
		<a href="{{url('tasks/create/'.$project->id)}}" class="btn btn-default text-center" id="create_task"><i class="picon picon-clippy">&nbsp;</i>Create Task</a>
	</div>
		@endif
	@endif
	@else
	<div class="project-manager pull-right">
		<div><i class="glyphicon glyphicon-chevron-left">&nbsp;</i><a class="light-link" href="{{url('project/'.$project->id)}}"><span>Back to project page</span></a></div>
	</div>
	@endif

	@else
	<span id="project_name">
		<h1 class="inline">&nbsp;</h1>
	</span>

	@endif
</nav>
