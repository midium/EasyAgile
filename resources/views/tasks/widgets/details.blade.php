<div>
  <label class="control-label task-details">Status:</label>
  <span><img class="details-icon" src="{{asset('/assets/task_status_icons/'.$task->task_status->id.'.png')}}" />{{$task->task_status->name}}</span>
  @if($task->project->status->id == 1 || $task->project->status->id == 2 || $task->project->status->id == 3)
  <?php
    switch($task->status_id){
      case 1: //Open
      case 6: //ToDo
        $button_action = 2;
        $button_text = "Start Task";
        break;

      case 2: //In Progress
      case 4: //Reopened
        $button_action = (($task->task_type->id==1)?11:3);
        $button_text = "Resolve Task";
        break;

      case 3: //Resolved
      case 5: //Closed
      case 7: //Blocked
      case 8: //Invalid
      case 10: //Done
      case 11: //Fixed
        $button_action = 4;
        $button_text = "Reopen Task";
        break;

      case 9: //Testing
        $button_action = 10;
        $button_text = "Tests Done";
        break;

    }
  ?>

  <button class="pull-right btn btn-default btn-sm" id="quick_action" data-action-type="{{$button_action}}">{{$button_text}}</button>
  @endif
</div>
<div>
  <label class="control-label task-details">Type:</label>
  <span><img class="details-icon" src="{{asset('/assets/task_type_icons/'.$task->task_type->id.'.png')}}" />{{$task->task_type->name}}</span>
</div>
<div>
  <label class="control-label task-details">Priority:</label>
  <span><img class="details-icon" src="{{asset('/assets/task_priority_icons/'.$task->priority->id.'.png')}}" />{{$task->priority->name}}</span>
</div>
<div>
  <label class="control-label task-details">Epic:</label>
  @if($task->epic != null)
  <span>({{$task->epic->project->code}}) {{$task->epic->name}}</span>
  @endif
</div>
