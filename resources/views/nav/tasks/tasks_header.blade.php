<nav class="navbar navbar-default project-header nav-fixed-top clearfix">
  <div class="inline">
  	<img class="project-task-icon-big inline" src="{{asset('/storage/app/projects_icons').'/'.$project->id.'.png'}}" onerror="this.src='{{ asset('/storage/app/projects_icons/default.png') }}'" />
  </div>
	<span id="project_name" class="project-task-name inline">
    <h5>
      @if($task->parent_task != null && $task->parent_task->count()>0)
      <a href="{{url('/project/'.$project->id)}}">{{ $project->name }}</a>&nbsp;&nbsp;/&nbsp;&nbsp;<a href="{{url('/task/'.$task->parent_task->id)}}">{{$task->parent_task->getCode().'&nbsp;&nbsp;'.$task->parent_task->subject}}</a>&nbsp;&nbsp;/&nbsp;&nbsp;{{$task->getCode()}}
      @else
      <a href="{{url('/project/'.$project->id)}}">{{ $project->name }}</a>&nbsp;&nbsp;/&nbsp;&nbsp;{{$task->getCode()}}
      @endif
    </h5>
    <span id="subject_view">
      <h3>{{$task->subject}}
        @if($project->status->id == 1 || $project->status->id == 2 || $project->status->id == 3)
        <a href="#" class="edit-subject" id="edit_subject"><i class="picon picon-pencil"></i></a>
        @endif
      </h3>
    </span>
	</span>

  <div class="project-tools pull-right clearfix">
    @if(!($task->parent_task != null && $task->parent_task->count()>0))
      @if($project->status->id == 1 || $project->status->id == 2 || $project->status->id == 3)
    <a href="{{url('tasks/create/'.$project->id.'/'.$task->id)}}" class="btn btn-default text-center" id="create_subtask"><i class="picon picon-git-branch">&nbsp;</i>Create Subtask</a>
      @endif
    @else
    <a href="{{url('task/convert_to_normal/'.$task->id.'/'.$project->id)}}" class="btn btn-default text-center"><i class="picon picon-git-branch">&nbsp;</i>Convert to Normal Task</a>
    @endif
	</div>
</nav>

<span id="subject_modal_holder"></span>
