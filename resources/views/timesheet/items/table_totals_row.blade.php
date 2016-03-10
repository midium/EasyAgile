<?php global $totals; ?>
<tr class="project-info">
  <td class="transition project-icon text-right" colspan="6">Daily Total Hours:</td>
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

    $logged_time = $totals[$i];
  ?>
  <td class="transition total-day-col {{($i==1)?'first':(($i==date('t')?'last':''))}} text-center {{($i==date('j') && $year==date('Y') && $month==date('m'))?'today':''}} {{$working_day}}">{{($logged_time !=0)?SecondsToTimesheet($logged_time):'&nbsp;'}}</td>
  @endfor
</tr>
