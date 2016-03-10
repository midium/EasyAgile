<?php global $totals; ?>
<tr class="project-info">
  @if(!isset($is_export) || $is_export == false )
  <td class="transition project-icon text-center no-left-padding no-right-padding"><img src="{{$task->project->getProjectIcon()}}"></td>
  @endif
  <td class="transition code">
    @if(!isset($is_export) || $is_export == false )
    <a href="{{url('/project/'.$task->project->id)}}" class="dark-link">{{$task->project->code}}</a>
    @else
    {{$task->project->code}}
    @endif
  </td>
  <td class="transition summary">
    @if(!isset($is_export) || $is_export == false )
    <a href="{{url('/project/'.$task->project->id)}}" class="dark-link">{{$task->project->name}}</a>
    @else
    {{$task->project->name}}
    @endif
  </td>
  <td class="transition type text-center no-left-padding no-right-padding">&nbsp;</td>
  <td class="transition status text-center no-left-padding no-right-padding">&nbsp;</td>
  <td class="transition total text-right" title="Total Time">{{SecondsToTimesheet($task->project->getTotalLoggedTimeForUserOnYearMonth($user->id, $year, $month))}}</td>

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

    $logged_time = $task->project->getTotalLoggedTimeOnDateForUser($date, Auth::user()->id);

    $totals[$i] += $logged_time;

  ?>
  <td class="transition day-col text-center {{($i==date('j') && $year==date('Y') && $month==date('m'))?'today':''}} {{$working_day}}">{{($logged_time !=0)?SecondsToTimesheet($logged_time):'&nbsp;'}}</td>
  @endfor
</tr>
