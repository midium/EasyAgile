<?php global $totals; ?>
@if($user->task_logs()->count()<=0)
  <p class="text-center">You have no activity logged so far.</p>
@else
  @if($user->getYearMonthLogs($year, $month)->count() <= 0)
  <p class="text-center">You have no activity logged so far on this month.</p>
  @else

<?php
$current_date = strtotime($year.'-'.$month.'-01');
$totals = array_fill(0, date('t', $current_date) + 1, 0);
?>

<table class="timesheet-table table table-striped transition">
  @include('timesheet.items.table_header')
  <tbody>
    <?php $cur_prj = 0; ?>

    @foreach($user->getYearMonthLoggedTasks($year, $month) as $task)
      @if($cur_prj != $task->project->id)
        @include('timesheet.items.table_project_row')
        <?php $cur_prj = $task->project->id; ?>
      @endif
      @include('timesheet.items.table_task_row')
    @endforeach
    @include('timesheet.items.table_totals_row')

  </tbody>
</table>
<!--<table class="header-fixed"></table>-->

  @endif
@endif
