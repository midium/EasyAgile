<div data-allow="context" class="task-card transition {{($task_item->isCompleted())?'completed':'movable'}}" data-id="{{$task_item->id}}" data-project-id="{{$task_item->project->id}}" data-epic-id="{{($task_item->epic !== null && $task_item->epic()->count()>0)?$task_item->epic->id:''}}" data-create="{{$task_item->created_at}}">
  <div data-allow="context" class="task-title">
    <div data-allow="context" class="epic-color" style="background: {{($task_item->epic !== null && $task_item->epic()->count()>0)?$task_item->epic->color:''}};">&nbsp;</div>
    <div data-allow="context" class="task-icon-element inline text-center" data-toggle="tooltip" data-placement="top" title="{{$task_item->task_type->name}}">
      <img data-allow="context" class="task-type-icon" src="{{asset('/assets/task_type_icons/'.$task_item->task_type_id.'.png')}}"/>
    </div>
    <div data-allow="context" class="task-icon-element inline text-center" data-toggle="tooltip" data-placement="top" title="{{$task_item->priority->name}}">
      <img data-allow="context" class="task-priority-icon" src="{{asset('/assets/task_priority_icons/'.$task_item->priority_id.'.png')}}"/>
    </div>
    <div data-allow="context" class="task-icon-element inline text-center" data-toggle="tooltip" data-placement="top" title="{{$task_item->task_status->name}}">
      <img data-allow="context" class="task-status-icon" src="{{asset('/assets/task_status_icons/'.$task_item->status_id.'.png')}}"/>
    </div>
    <span data-allow="context" class="task-code"><a data-allow="context" href="{{ url('/task/'.$task_item->id) }}">{{$task_item->getCode()}}</a></span>
    <span data-allow="context" class="task-subject fade-text">{{$task_item->subject}}</span>
    <span data-allow="context" class="badge work-hours pull-right">{{SecondsToTimeString($task_item->getTotalEstimatedTime())}}</span>
    <span data-allow="context" class="task-owner pull-right" title="{{($task_item->owner !== null && $task_item->owner()->count() > 0)?$task_item->owner->name:'Unassigned'}}"><img data-allow="context" class="user-img" src="{{($task_item->owner !== null && $task_item->owner()->count() > 0 && $task_item->owner->id != -1)?$task_item->owner->getAvatarURI():asset('/assets/unassigned.png')}}" /></span>

    <div data-allow="context" class="sub-task-time inline pull-right" >
      <?php
        $estimates = $task_item->getTotalEstimatedTime();
        $remaining = $task_item->getRemainingTime();
        $logged = $task_item->getTotalLoggedTime();

        $estimates_percentage = GetTimePercentage($estimates, $remaining, $logged, 'estimates');
        $remaining_percentage = GetTimePercentage($estimates, $remaining, $logged, 'remaining');
        $logged_percentage = GetTimePercentage($estimates, $remaining, $logged, 'logged');
      ?>
        <div data-allow="context" class="progress">
          <div data-allow="context" class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="{{$estimates_percentage}}" aria-valuemax="100" style="width: {{$estimates_percentage}}%;"></div>
        </div>

        <div data-allow="context" class="progress">
          <div data-allow="context" class="progress-bar progress-bar-warning" aria-valuenow="{{$logged_percentage}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$logged_percentage}}%">&nbsp;</div>
          <div data-allow="context" class="progress-bar progress-bar-success" aria-valuenow="{{$remaining_percentage}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$remaining_percentage}}%">&nbsp;</div>
        </div>

    </div>
    <span data-allow="context" class="logged-percentage inline pull-right" data-toggle="tooltip" data-placement="top" title="{{($estimates_percentage == 0 && $logged_percentage == 0)?'Not Estimated':''}}" >{{($estimates_percentage == 0 && $logged_percentage == 0)?'NE':str_replace('.00','',number_format($logged_percentage,2)).'%'}}</span>

  </div>
</div>
