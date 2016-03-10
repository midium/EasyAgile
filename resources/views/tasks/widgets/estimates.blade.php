<div class="form-group">
  <div class="form-control-wrapper">
    <?php
      $estimates = $task->getTotalEstimatedTime();
      $remaining = $task->getRemainingTime();
      $logged = $task->getTotalLoggedTime();

      $estimates_percentage = GetTimePercentage($estimates, $remaining, $logged, 'estimates');
      $remaining_percentage = GetTimePercentage($estimates, $remaining, $logged, 'remaining');
      $logged_percentage = GetTimePercentage($estimates, $remaining, $logged, 'logged');
    ?>
    <div class="task-estimates">
      <span class="estimates-label">Estimated:<span class="badge pull-right">{{SecondsToTimeString($estimates)}}</span></span>
      <div class="progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="{{$estimates_percentage}}" aria-valuemax="100" style="width: {{$estimates_percentage}}%;"></div>
      </div>
    </div>
    <div class="task-estimates">
      <span class="estimates-label">Remaining:<span class="badge pull-right">{{SecondsToTimeString($remaining)}}</span></span>
      <div class="progress">
        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{$remaining_percentage}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$remaining_percentage}}%"></div>
      </div>
    </div>
    <div class="task-estimates">
      <span class="estimates-label">Logged:<span class="badge pull-right">{{SecondsToTimeString($logged)}}</span></span>
      <div class="progress">
        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="{{$logged_percentage}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$logged_percentage}}%"></div>
      </div>
    </div>
  </div>
</div>
