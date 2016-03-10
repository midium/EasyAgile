<div class="form-group">
  <label class="control-label">Assigned to:</label>
  @if($task->project->status->id == 1 || $task->project->status->id == 2 || $task->project->status->id == 3)
  <a class="pull-right" href="#" id="assign_to_me">Assign to me</a>
  @endif
  <div class="form-control-wrapper">
    <span class="task-owner"><img class="creator-img" src="{{($task->owner != null)?$task->owner->getAvatarURI():asset('/assets/unassigned.png')}}" onerror="this.src='{{ asset('css/icons/ic_account_circle_grey600_36dp.png') }}" />{{($task->owner != null)?$task->owner->name:'Unassigned'}}</span>
  </div>
</div>

<div class="form-group">
  <label>Reported by:</label>
  <div class="form-control-wrapper">
    <span class="task-creator"><img class="creator-img" src="{{$task->creator->getAvatarURI()}}" onerror="this.src='{{ asset('css/icons/ic_account_circle_grey600_36dp.png') }}" />{{$task->creator->name}}</span>
  </div>
</div>
