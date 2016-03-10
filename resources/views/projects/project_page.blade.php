@extends('app')

@section('top-js')
<script src="{{ asset('/js/jquery-sortable-min.js') }}"></script>
<script src="{{ asset('/js/projects.js') }}"></script>
<script src="{{ asset('/js/tinysort.min.js') }}"></script>
@endsection

@section('content')
<div class="container-fluid">
	<input type="hidden" value="{{(isset($message))?$message:''}}" id="messages" />
	<input type="hidden" value="{{(isset($message_type))?$message_type:''}}" id="message_type" />
	<input type="hidden" value="{{(isset($message_title))?$message_title:''}}" id="message_title" />

	<div class="row">&nbsp;</div>
    <div class="row">
			<input type="hidden" id="project_id" value="{{$project->id}}" />
			<input type="hidden" id="token" name="_token" value="<?= csrf_token() ?>" />
@if($project->epics->count() <= 0)
			<h4 class="text-center">The project seems missing the basic setup. Please check the project <a href="{{url('project').'/'.$project->id.'/settings'}}">settings</a> in order to continue.</h4>
@else
			<div class="col-md-2">
				<h4 class="underline"><i class="picon picon-repo-clone icon-lesstop">&nbsp;</i>Epics <span class="issues-count">{{($project->epics != null)?$project->epics->count().' epics':''}}</span></h4>
				<section class="epics-container">
					@if(($project->epics != null))
					<div class="checkbox">
						<label>
							<input type="checkbox"> Filter out completed tasks
						</label>
					</div>
					<div class="list-group">
						<a href="#" class="list-group-item small" data-id="all"><div class="pull-left epic-color-menu"></div>Show All</a>
						@foreach($project->epics as $epic)
						<a href="#" class="list-group-item small" data-id="{{$epic->id}}"><div class="pull-left epic-color-menu" style="background: {{$epic->color}};">&nbsp;</div>{{$epic->name}}</a>
						@endforeach
					</div>
					@endif
				</section>

				<h4 class="underline"><i class="picon picon-repo-clone icon-lesstop">&nbsp;</i>Sprints <span class="issues-count">{{($project->sprints != null)?$project->sprints->count().' sprints':''}}</span></h4>
				<section class="sprints-list-container">
					@if(($project->sprints != null))
					<div class="list-group">
						@foreach($project->sprints()->orderBy('sprint_status_id')->get() as $sprint_item)
						<a href="{{url('project/'.$sprint_item->project->id.'/'.$sprint_item->id)}}" class="list-group-item small" data-id="{{$sprint_item->id}}"><img class="sprint-menu-icon" src="{{asset('/assets/sprint_status_icons/'.$sprint_item->status->id.'.png')}}" />{{$sprint_item->name}}</a>
						@endforeach
					</div>
					@endif
				</section>

			</div>
			<div class="col-md-10" id="sprint_tasks">
				@include('projects.items.tasks')
			</div>
@endif
  	</div>

</div>
@endsection

@section('js-includes')
<script src="{{ asset('/js/projects.js') }}"></script>
<script>
@if(!isset($project->epics) || $project->epics->count() <= 0)
		$('button').attr('disabled', 'disabled');
@endif
</script>
@endsection

@section('beforebodyend')
<div class="modal fade" id="sprintModal" tabindex="-1" role="dialog" aria-labelledby="sprintModal"></div>

@endsection
