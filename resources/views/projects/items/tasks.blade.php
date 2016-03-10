@if($sprint != null)
<div class="sprint-container">
  <div id="sprint_head">
    @include('projects.items.sprint_header')
  </div>
  <section class="sprint-tasks-container {{($sprint->status->id == 2)?'linked':'standalone'}}" data-id="{{$sprint->id}}">
    @foreach($sprint->tasks()->where('parent_task_id', '=', 0)->orderByRaw('-order_number desc')->get() as $task_item)
      @include('tasks.items.card')
    @endforeach
  </section>
</div>
@endif
<h4 class="underline tasks">
  <i class="picon picon-clipboard-notes icon-lesstop">&nbsp;</i>Backlog
  <span class="issues-count">{{($project->getBacklogTasks() != null)?$project->getBacklogTasks()->count().' issues':''}}</span>
  <a href="#" id="sort_older" title="Sort by oldest tasks" data-toggle="tooltip" data-position="top" class="sprint-tool-icon extra pull-right"><i class="glyphicon glyphicon-sort-by-attributes"></i></a>
  <a href="#" id="sort_newer" title="Sort by newer tasks" data-toggle="tooltip" data-position="top" class="sprint-tool-icon pull-right"><i class="glyphicon glyphicon-sort-by-attributes-alt"></i></a>

</h4>
<section class="tasks-container linked">
  @foreach($project->getBacklogTasks() as $task_item)
    @include('tasks.items.card')
  @endforeach
</section>

<script>
$('[data-toggle="tooltip"]').tooltip();
</script>
