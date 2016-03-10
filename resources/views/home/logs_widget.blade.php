<section class="logs-header">
  <div class="inline user text-center">User</div>
  <div class="inline date">Date</div>
  <div class="inline description">Description</div>
  <div class="inline worked">Worked</div>
</section>
<section class="logs-content">
  @foreach($task->task_logs as $log)
  <div class="log-item transition">
    <div class="inline user text-center">
      <img title="{{$task->owner->name}}" data-toggle="tooltip" data-placement="right" src="{{$task->owner->getAvatarURI()}}" onerror="this.src='{{ asset('css/icons/ic_account_circle_grey600_36dp.png') }}" />
    </div>
    <time class="inline text-middle date">{{substr($log->log_date,0,-9)}}</time>
    <description class="inline text-middle description">{{$log->log_description}}</description>
    <time class="inline text-middle worked">{{$log->getLoggedTime()}}</time>
  </div>
  @endforeach
</section>
