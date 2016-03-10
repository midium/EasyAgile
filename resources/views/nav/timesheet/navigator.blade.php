<?php $current_date = strtotime($year.'-'.$month.'-01'); ?>

<div class="date-navigator inline" data-year="{{$year}}" data-month="{{$month}}">
  <a class="btn btn-default prev-month" id="change_month" data-direction="prev" href="#"><i class="picon picon-chevron-left-1"></i></a>
  <span class="year-month">{{date('F', $current_date).' '.$year}}</span>
  <a class="btn btn-default next-month pull-right" id="change_month" data-direction="next" href="#"><i class="picon picon-chevron-right-1"></i></a>
</div>
