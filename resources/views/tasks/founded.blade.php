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
  <input type="hidden" id="search_string" name="search_string" value="{{$search_string}}" />
	<div class="row">&nbsp;</div>
  <div class="row">
@if(!isset($tasks) || $tasks->count() <= 0)
	<h4 class="text-center">No tasks founded.</h4>
@else
		<div class="col-md-12">
			<h4 class="underline">
        <i class="picon picon-inbox icon-lesstop">&nbsp;</i>Founded Tasks
        <div class="paginator-container inline pull-right"><?php echo View::make('personal.paginator')->with('paginator', $tasks)->with('show_pages', false); ?></div>
      </h4>
			<div class="founded-tasks-container">
        @include('tasks.widgets.tasks_list')
			</div>
		</div>
@endif
  </div>
</div>
@endsection

@section('js-includes')
<script src="{{ asset('/js/found_tasks.js') }}"></script>
@endsection
