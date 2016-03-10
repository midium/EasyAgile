<section class="logs-header">
  <div class="inline user text-center">User</div>
  <div class="inline date">Date</div>
  <div class="inline description">Description</div>
  <div class="inline worked">Worked</div>
</section>
<section class="logs-content">
  @foreach($task->task_logs as $log)
    @include('tasks.items.log')
  @endforeach
</section>
