@extends('app')

@section('content')
<div class="projects-updating">
  <div class="spinner">
    <div class="spinner-container container1">
      <div class="circle1"></div>
      <div class="circle2"></div>
      <div class="circle3"></div>
      <div class="circle4"></div>
    </div>
    <div class="spinner-container container2">
      <div class="circle1"></div>
      <div class="circle2"></div>
      <div class="circle3"></div>
      <div class="circle4"></div>
    </div>
    <div class="spinner-container container3">
      <div class="circle1"></div>
      <div class="circle2"></div>
      <div class="circle3"></div>
      <div class="circle4"></div>
    </div>
  </div>
</div>

<div class="container-fluid all-projects-scroller">
	<input type="hidden" id="token" name="_token" value="<?= csrf_token() ?>" />
	<div class="row">&nbsp;</div>
  <div class="row">
@if(!isset($tasks) || $tasks->count() <= 0)
	<h4 class="text-center">There are currently no tasks available. Start creating your first task <a href="{{ url('/tasks/create') }}">here</a>.</h4>
@else
		<div class="col-md-12">
			<h4 class="underline"><i class="picon picon-checkbox icon-lesstop">&nbsp;</i>Filters
        <i class="pull-right picon picon-chevron-down show-hide-filters" data-toggle="tooltip" data-placement="left" title="Show/Hide Filter Form"></i>
      </h4>
			<div class="tasks-filters-container">
			@include('tasks.forms.filters')
			</div>
		</div>
  </div>
  <div class="row">
		<div class="col-md-12">
			<h4 class="underline">
        <i class="picon picon-inbox icon-lesstop">&nbsp;</i>Tasks
        <div class="paginator-container inline pull-right"><?php echo View::make('personal.paginator')->with('paginator', $tasks)->with('show_pages', false); ?></div>
      </h4>
			<div class="tasks-container">
        @include('tasks.widgets.tasks_list')
			</div>
		</div>
@endif
  </div>
</div>
@endsection

@section('js-includes')
<script src="{{ asset('/js/all_tasks.js') }}"></script>
@endsection
