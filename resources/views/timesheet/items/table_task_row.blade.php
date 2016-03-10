<tr class="task-info">
  @if(!isset($is_export) || $is_export == false )
  <td class="transition project-icon text-center no-left-padding no-right-padding">&nbsp;</td>
  @endif
  <td class="transition code">
    @if(!isset($is_export) || $is_export == false )
    <a href="{{url('/task/'.$task->id)}}" class="cyan-link">{{$task->getCode()}}</a></td>
    @else
    {{$task->getCode()}}
    @endif
  <td class="transition summary">
    @if(!isset($is_export) || $is_export == false )
      @if($task->parent_task != null && $task->parent_task()->count() > 0)
      <a href="{{url('/task/'.$task->parent_task->id)}}" class="dark-link">{{$task->parent_task->getCode()}}</a>&nbsp;/&nbsp;
      @endif
      <a href="{{url('/task/'.$task->id)}}" class="cyan-link">{{$task->subject}}</a>
    @else
      @if($task->parent_task != null && $task->parent_task()->count() > 0)
      {{$task->parent_task->getCode()}}&nbsp;/&nbsp;
      @endif
      {{$task->subject}}
    @endif
  </td>
  <td class="transition type text-center no-left-padding no-right-padding" data-toggle="tooltip" data-placement="top" title="{{$task->task_type->name}}">
    @if(!isset($is_export) || $is_export == false )
    <img src="{{asset('/assets/task_type_icons/'.$task->task_type->id.'.png')}}">
    @else
    {{$task->task_type->name}}
    @endif
  </td>
  <td class="transition status text-center no-left-padding no-right-padding" data-toggle="tooltip" data-placement="top" title="{{$task->task_status->name}}">
    @if(!isset($is_export) || $is_export == false )
    <img src="{{asset('/assets/task_status_icons/'.$task->task_status->id.'.png')}}">
    @else
    {{$task->task_status_name}}
    @endif
  </td>
  <td class="transition total text-right" title="Total Time">{{SecondsToTimesheet($task->getThisTaskLoggedTimeForUser(Auth::user()->id))}}</td>
  <td class="transition spacer-col">&nbsp;</td>
  <?php $flg_saturday = true; ?>
  @for($i=1; $i<=date('t', $current_date); $i++)
  <?php
    $date = $year.'-'.$month.'-'.$i;
    $day = substr(date('l', strtotime($date)),0,1);

    $working_day = '';
    if($day=='S'){
      if($flg_saturday){
        $working_day = 'not-working-day end-week';
        $flg_saturday = false;
      } else {
        $working_day = 'not-working-day';
        $flg_saturday = true;
      }
    }

    $logged_time = $task->getThisTaskLoggedTimeOnDateForUser($date, Auth::user()->id);

  ?>
  <td class="transition day-col editable text-center {{($i==date('j') && $year==date('Y') && $month==date('m'))?'today':''}} {{$working_day}}" data-date="{{$date}}" data-task-id="{{$task->id}}" data-log-id="{{($logged_time !=0)?$task->getThisTaskLoggedIdOnDateForUser($date, Auth::user()->id):''}}">{{($logged_time !=0)?SecondsToTimesheet($logged_time):'&nbsp;'}}</td>
  @endfor
</tr>
