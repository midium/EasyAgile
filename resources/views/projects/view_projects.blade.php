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
@if(!isset($projects) || $projects->count() <= 0)
	<h4 class="text-center">There are currently no projects available. Start creating your first amazing project <a href="{{ url('/projects/create') }}">here</a>.</h4>
@else
		<div class="col-md-3">
			<h4 class="underline"><i class="picon picon-checkbox icon-lesstop">&nbsp;</i>Filters</h4>
			<div class="filters-container">
			@include('projects.forms.filters')
			</div>
		</div>
		<div class="col-md-9">
			<h4 class="underline"><i class="picon picon-repo icon-lesstop">&nbsp;</i>Projects</h4>
			<div class="projects-container">
				@include('projects.widgets.projects_list')
			</div>
		</div>
@endif
  </div>
</div>
@endsection

@section('js-includes')
<script src="{{ asset('/js/all_projects.js') }}"></script>
@endsection
