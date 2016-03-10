<form action="{{url('/task/update_details')}}" method="post" id="details_form">
  <input type="hidden" id="token" name="_token" value="<?= csrf_token() ?>" />
  <input type="hidden" id="task_id" name="task_id" value="{{$task->id}}" />
  <input type="hidden" id="type" name="type" value="widgets" />

<div class="form-group clearfix">
  <div class="col-md-6 no-left-padding">
    <label class="control-label">Task Status:</label>
    <div class="form-control-wrapper">
      <select class="form-control selectpicker" name="status_id" id="status_id" required>
      @if(isset($task_statuses))
        @foreach($task_statuses as $task_status)
        <option value="{{$task_status->id}}" {{($task->task_status->id == $task_status->id)?'selected="selected"':''}} data-content="<img class='project-icon' src='{{asset('/assets/task_status_icons/'.$task_status->id.'.png')}}' /></span><span style='display:inline-block;'>&nbsp;{{$task_status->name}}</span>"</option>
        @endforeach
      @endif
      </select>
    </div>
  </div>
  <div class="col-md-6 no-right-padding">
    <label class="control-label">Epic:</label>
    <div class="form-control-wrapper">
      <select class="form-control selectpicker" name="epic_id" id="epic_id">
        @if(isset($epics))
        <option value="-1">None</option>
          @foreach($epics as $epic)
        <option value="{{$epic->id}}" {{($task->epic != null && $task->epic->id == $epic->id)?'selected="selected"':''}}>({{$epic->project->name}}) {{$epic->name}}</option>
          @endforeach
        @endif
      </select>
    </div>
  </div>
</div>
<div class="form-group">
  <div class="col-md-6 no-left-padding">
    <label class="control-label">Issue Type:</label>
    @if($task->task_type->id != 6)
    <div class="form-control-wrapper">
      <select class="form-control selectpicker" name="task_type_id" id="task_type_id" required>
      @if(isset($task_types))
        @foreach($task_types as $task_type)
        <option value="{{$task_type->id}}" {{($task->task_type->id == $task_type->id)?'selected="selected"':''}} data-content="<img class='project-icon' src='{{asset('/assets/task_type_icons/'.$task_type->id.'.png')}}' /></span><span style='display:inline-block;'>&nbsp;{{$task_type->name}}</span>"</option>
        @endforeach
      @endif
      </select>
    </div>
    @else
    <div><img class="details-icon" src="{{asset('/assets/task_type_icons/'.$task->task_type->id.'.png')}}" />{{$task->task_type->name}}</div>
    <input type="hidden" name="task_type_id" id="task_type_id" value="{{$task->task_type->id}}" />
    @endif
  </div>
  <div class="col-md-6 no-right-padding">
    <label class="control-label">Task Priority:</label>
    <div class="form-control-wrapper">
      <select class="form-control selectpicker" name="priority_id" id="priority_id" required>
      @if(isset($priorities))
        @foreach($priorities as $priority)
        <option value="{{$priority->id}}" {{($priority->id == $task->priority->id)?'selected="selected"':''}} data-content="<img class='project-icon' src='{{asset('/assets/task_priority_icons/'.$priority->id.'.png')}}' /></span><span style='display:inline-block;'>&nbsp;{{$priority->name}}</span>"</option>
        @endforeach
      @endif
      </select>
    </div>
  </div>
</div>
<div class="form-group">&nbsp;</div>
<div class="form-group">
  <button type="button" class="btn btn-default btn-sm" id="cancel">Cancel</button>
  <button type="submit" class="btn btn-default btn-sm pull-right" id="save">Save</button>
</div>

</form>

<script>
$('.selectpicker').selectpicker();
</script>
