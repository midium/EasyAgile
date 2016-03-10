@extends('task')

@section('content')
<div class="container-fluid task-overflowed">
  <input type="hidden" id="token" name="_token" value="<?= csrf_token() ?>" />
  <input type="hidden" id="task_id" value="{{$task->id}}" />
  <div class="row">&nbsp;</div>
  <div class="row">
    <div class="col-md-8">
      <h4 class="underline"><i class="picon picon-repo icon-lesstop">&nbsp;</i>Details
        @if($project->status->id == 1 || $project->status->id == 2 || $project->status->id == 3)
        <a href="#" class="pull-right dark-link" id="edit_details" data-toggle="tooltip" data-placement="left" title="Edit Details"><i class="picon picon-pencil icon-lesstop"></i></a>
        @endif
      </h4>
      <section id="task_details_container">
        @include('tasks.widgets.details')
      </section>

      <div>&nbsp;</div>
      <h4 class="underline"><i class="picon picon-clipboard-pencil icon-lesstop">&nbsp;</i>Description
        @if($project->status->id == 1 || $project->status->id == 2 || $project->status->id == 3)
        <a href="#" class="pull-right dark-link" id="edit_description" data-toggle="tooltip" data-placement="left" title="Edit Description"><i class="picon picon-pencil icon-lesstop"></i></a>
        @endif
      </h4>
      <section id="task_description_container">
        @include('tasks.widgets.description')
      </section>

      @if($task->sub_tasks != null && $task->sub_tasks()->count() > 0)
      <div>&nbsp;</div>
      <h4 class="underline"><i class="picon picon-repo-clone icon-lesstop">&nbsp;</i>Sub-Tasks</h4>
      <section id="task_subtasks_container">
        @include('tasks.widgets.subtasks')
      </section>

      @include('tasks.items.context_menu')

      @endif

      <div>&nbsp;</div>
      <h4 class="underline">
        <i class="picon picon-paper-clip icon-lesstop">&nbsp;</i>Attachments
        <a href="#" class="head-tools view active dark-link {{($task->attachments != null && $task->attachments()->count() > 0)?'':'hidden'}}" id="view_mode" data-view-mode="view" data-toggle="tooltip" data-placement="top" title="Preview Mode"><i class="picon picon-picture icon-lesstop"></i></a>
        <a href="#" class="head-tools list dark-link {{($task->attachments != null && $task->attachments()->count() > 0)?'':'hidden'}}" id="view_mode" data-view-mode="list" data-toggle="tooltip" data-placement="top" title="List Mode"><i class="picon picon-list-unordered icon-lesstop"></i></a>
        @if($project->status->id == 1 || $project->status->id == 2 || $project->status->id == 3)
        <a href="#" class="pull-right dark-link" id="add_attachment" data-toggle="tooltip" data-placement="left" title="Add Attachment"><i class="glyphicon glyphicon-plus icon-lesstop"></i></a>
        @endif
      </h4>
      <section id="task_attachments_container">
        @if($task->attachments != null && $task->attachments()->count() > 0)
          @include('tasks.widgets.attachments_view')
        @endif
      </section>

      <div>&nbsp;</div>
      <h4 class="underline"><i class="picon picon-history icon-lesstop">&nbsp;</i>Work Logs
        @if($project->status->id == 1 || $project->status->id == 2 || $project->status->id == 3)
        <a href="#" class="pull-right dark-link" id="add_log" data-toggle="tooltip" data-placement="left" title="Add New Work Log"><i class="glyphicon glyphicon-plus icon-lesstop"></i></a>
        @endif
      </h4>
      <section id="task_worklogs_container">
        @if($task->task_logs != null && $task->task_logs()->count() > 0)
        @include('tasks.widgets.logs')
        @endif
      </section>

      <div>&nbsp;</div>
      <h4 class="underline"><i class="picon picon-chat-bubble-two icon-lesstop">&nbsp;</i>Comments
        @if($project->status->id == 1 || $project->status->id == 2 || $project->status->id == 3)
        <a href="#" class="pull-right dark-link" id="add_comment" data-toggle="tooltip" data-placement="left" title="Add New Comment"><i class="glyphicon glyphicon-plus icon-lesstop"></i></a>
        @endif
      </h4>
      <section id="task_comments_container">
        @include('tasks.widgets.comments')
      </section>

    </div>
    <div class="col-md-4">
      <h4 class="underline"><i class="picon picon-torsos icon-lesstop">&nbsp;</i>People
        @if($project->status->id == 1 || $project->status->id == 2 || $project->status->id == 3)
        <a href="#" class="pull-right dark-link" id="edit_people" data-toggle="tooltip" data-placement="left" title="Edit Assignements"><i class="picon picon-pencil icon-lesstop"></i></a>
        @endif
      </h4>
      <section id="task_people_container">
        @include('tasks.widgets.assigned')
      </section>

      <div class="space-maker">&nbsp;</div>
      <h4 class="underline"><i class="picon picon-calendar-2 icon-lesstop">&nbsp;</i>Dates</h4>
      <section id="date_info">
        <div class="form-group">
          <div><label>Created:&nbsp;</label><time>{{$task->created_at}}</time></div>
          <div><label>Updated:&nbsp;</label><time>{{$task->updated_at}}</time></div>
        </div>
      </section>

      <div class="space-maker">&nbsp;</div>
      <h4 class="underline">
        <i class="picon picon-clock-1 icon-lesstop">&nbsp;</i>Time Tracking
        @if($project->status->id == 1 || $project->status->id == 2 || $project->status->id == 3)
        <a href="#" class="pull-right head-tools dark-link" id="add_log" data-toggle="tooltip" data-placement="left" title="Add New Work Log"><i class="glyphicon glyphicon-plus icon-lesstop"></i></a>
        <a href="#" class="pull-right head-tools dark-link" id="edit_estimates" data-toggle="tooltip" data-placement="left" title="Edit Task Estimates"><i class="picon picon-pencil icon-lesstop"></i></a>
        @endif
      </h4>
      <section id="time_traking">
        @include('tasks.widgets.estimates')
      </section>

    </div>
  </div>
  <div class="row">&nbsp;</div>
</div>
@endsection

@section('js-includes')
<script src="{{ asset('/js/dropify.min.js') }}"></script>
@endsection

@section('css-includes')
<link rel="stylesheet" href="{{ asset('/css/dropify.min.css') }}">
@endsection

@section('beforebodyend')
<script src="{{ asset('/js/tasks.js') }}"></script>

<div id="modal_container"></div>
@endsection
