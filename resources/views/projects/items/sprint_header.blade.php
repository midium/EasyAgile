<h4 class="underline sprint">
  <i class="picon picon-clipboard-notes icon-lesstop">&nbsp;</i>{{$sprint->name}}
  <em class="sprint-period"><time>{{substr($sprint->from_date,0,-9).' - '.substr($sprint->to_date,0,-9)}}</time></em>
  <span class="issues-count">{{($sprint->tasks()->where('parent_task_id', '=', 0) != null)?$sprint->tasks()->where('parent_task_id', '=', 0)->count().' issues':''}}</span>
  <?php
  switch($sprint->status->id){
    case 1:
  ?>
  <a href="#" id="sprint_status_change" data-id="{{$sprint->id}}" data-status-id="{{$sprint->status->id}}" title="End the Sprint" data-toggle="tooltip" data-position="top" class="sprint-status pull-right"><span>{{$sprint->status->name}}</span><img class="sprint-status-icon" src="{{asset('/assets/sprint_status_icons/'.$sprint->status->id.'.png')}}" /></a>
  <a href="#" id="sprint_delete" data-id="{{$sprint->id}}" title="Delete the Sprint" data-toggle="tooltip" data-position="top" class="sprint-tool-icon extra pull-right"><i class="picon picon-trash"></i></a>
  <a href="#" id="sprint_edit" data-id="{{$sprint->id}}" title="Edit the Sprint" data-toggle="tooltip" data-position="top" class="sprint-tool-icon pull-right"><i class="picon picon-pencil"></i></a>
  <?php
      break;

    case 2:
  ?>
  <a href="#" id="sprint_status_change" data-id="{{$sprint->id}}" data-status-id="{{$sprint->status->id}}" title="Start the Sprint" data-toggle="tooltip" data-position="top" class="sprint-status pull-right"><span>{{$sprint->status->name}}</span><img class="sprint-status-icon" src="{{asset('/assets/sprint_status_icons/'.$sprint->status->id.'.png')}}" /></a>
  <?php
      break;

    case 3:
  ?>
  <div class="sprint-status pull-right"><span>{{$sprint->status->name}}</span><img class="sprint-status-icon" src="{{asset('/assets/sprint_status_icons/'.$sprint->status->id.'.png')}}" /></div>
  <?php
      break;
  }
  ?>
</h4>
