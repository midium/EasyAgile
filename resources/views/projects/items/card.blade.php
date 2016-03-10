<div class="project-card transition" data-id="{{$project->id}}">
  <div class="project-color" style="background: #765643;">&nbsp;</div>
  <div class="project-icon-element inline text-center">
    <img class="project-type-icon" src="{{asset('/storage/app/projects_icons').'/'.$project->id.'.png'}}" onerror="this.src='{{ asset('/storage/app/projects_icons/default.png') }}'"/>
  </div>
  <div class="project-main-body inline">
    <div class="project-info">
      <img class="project-status-icon" src="{{asset('/assets/project_status_icons/'.$project->status->id.'.png')}}"/>
      <span class="project-name fade-text"><a class="dark-link" href="{{url('/project/'.$project->id)}}">{{$project->name}}</a></span>
      <time class="project-time">{{substr($project->created_at,0,10)}}</time>
    </div>
    <div class="tasks-info inline">
      <span>Open Tasks:&nbsp;</span><span class="badge tasks-count">{{$project->getTotalOpenTasks()}}</span>
      <span>Completed Tasks:&nbsp;</span><span class="badge tasks-count">{{$project->getTotalClosedTasks()}}</span>
    </div>
  </div>
  <span class="project-owner pull-right" title="{{($project->manager != null)?$project->manager->name:'Unassigned'}}">{{($project->manager != null)?$project->manager->name:'Unassigned'}}<img class="manager-img" src="{{$project->manager->getAvatarURI()}}" onerror="{{asset('/assets/unassigned.png')}}" /></span>
</div>
