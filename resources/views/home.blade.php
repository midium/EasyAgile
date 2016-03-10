@extends('app')

@section('content')
<div class="container-fluid">
    <div class="row">&nbsp;</div>
    <div class="row">
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome to Easy Agile</div>

                <div class="panel-body">
                    Welcome <strong>{{Auth::user()->name}}</strong> to Easy Agile. Are you ready for another exciting working day?
                </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <h4 class="underline"><i class="picon picon-history icon-lesstop">&nbsp;</i>Recent Activity</h4>
            <div class="recent-activity">
              @if(Auth::user()->task_logs()->count() > 0)
                @foreach(Auth::user()->task_logs()->orderBy('created_at', 'desc')->get() as $log)
                  <?php
                  $task = $log->task;
                  $hide_tools = true;
                  ?>
                  @include('tasks.items.log')
                @endforeach
              @else
              <p>Ouch! You have no activity logged so far. Please be sure to do something soon.</p>
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-12">
            <h4 class="underline"><i class="picon picon-box-inbox icon-lesstop">&nbsp;</i>My Recent Tasks</h4>
            <div class="recent-tasks">
              @if(Auth::user()->getUserNotClosedTasks()->count() > 0)
                @foreach(Auth::user()->getUserNotClosedTasks()->orderBy('created_at', 'desc')->get() as $task_item)
                  @include('tasks.items.card')
                @endforeach

              @else
              <p>WOW! You have no tickets assigned to you.<br>Try navigate the projects to see if you can help with some of the available tickets.</p>
              @endif
            </div>
          </div>
        </div>
        <div class="row">&nbsp;</div>
        <div class="row">
          <div class="col-md-12">
            <h4 class="underline"><i class="picon picon-repo icon-lesstop">&nbsp;</i>Recent Projects</h4>
            <div class="recent-projects">
              @if(App\Project::all()->count() > 0)
                @foreach(App\Project::orderBy('created_at', 'desc')->get() as $project)
                  @include('projects.items.card')
                @endforeach

              @else
              <p class="text-center">Mmmh, there are still no Projects. Start now creating your first project <a href="projects/create">here</a>.</p>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">&nbsp;</div>
</div>
@endsection

@section('beforebodyend')
<script>
$('[data-toggle="tooltip"]').tooltip();
</script>
<style>
.task-subject{
  /* Overriding style to decrease available space */
  max-width: 35% !important;
}
</style>
@endsection
