<thead>
<tr>
    @if(!isset($is_export) || $is_export == false )
    <th class="transition project-icon text-center">&nbsp;<br>&nbsp;</th>
    @endif
    <th class="transition code">&nbsp;<br>Code</th>
    <th class="transition summary">&nbsp;<br>Summary</th>
    <th class="transition type text-center" title="Type">&nbsp;<br>{{(!isset($is_export) || $is_export == false )?'T':'Task Type'}}</th>
    <th class="transition status text-center" title="Status">&nbsp;<br>{{(!isset($is_export) || $is_export == false )?'S':'Task Status'}}</th>
    <th class="transition total text-center" title="Total Time">&nbsp;<br>{{(!isset($is_export) || $is_export == false )?'Σ':'Total Logged Time'}}</th>
    <th class="transition spacer-col">&nbsp;<br>&nbsp;</th>
    <?php $flg_saturday = true; ?>
    @for($i=1; $i<=date('t', $current_date); $i++)
    <?php
      $date = $year.'/'.$month.'/'.$i;
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
    ?>
    <th class="transition day-col text-center {{($i==date('j') && $year==date('Y') && $month==date('m'))?'today':''}} {{$working_day}}">{{sprintf("%02d", $i)."\n".$day}}</th>
    @endfor
</tr>
</thead>
