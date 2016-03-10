@extends('app')

@section('content')
<div class="container-fluid project-settings-scroller">
	<input type="hidden" id="token" name="_token" value="<?= csrf_token() ?>" />
	<input type="hidden" id="project_id" value="{{$project->id}}" />
	<div class="row">&nbsp;</div>
    <div class="row">
    	<div class="col-md-6">
	        <div class="panel panel-default">
	            <div class="panel-heading"><i class="picon picon-pencil-3">&nbsp;</i>Project Details</div>

	            <div class="panel-body">
	            	<div class="container-fluid">
	                @include('projects.project_details_form')
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="col-md-6">
	        <div class="panel panel-default">
	            <div class="panel-heading"><i class="picon picon-gears-setting">&nbsp;</i>Project Settings</div>

	            <div class="panel-body">
		            <div class="container-fluid">

		            <h1>To be implemented</h1>

		            </div>
	            </div>
	        </div>

	    </div>
    </div>
    <div class="row">
        <div class="col-md-6">
	        <div class="panel panel-default">
	            <div class="panel-heading"><i class="picon picon-flow-tree">&nbsp;</i>Project Epics</div>

	            <div class="panel-body">
	            	<div class="container-fluid no-padding epics-list-container" id="epics_list">
	            		@if(isset($epics) && $epics->count()>0)
										@include('projects.epics_table')
									@else
									<div class="text-center"><strong>No epics available for this project at the moment.</strong></div>
									@endif
								</div>

								<div class="container-fluid no-padding">
									@if($project->status->id == 1 || $project->status->id == 2 || $project->status->id == 3)
									<button class="btn btn-primary pull-right" id="create_epic">Create an Epic</button>
									@endif

									<div class="modal fade" id="epicModal" tabindex="-1" role="dialog" aria-labelledby="epicModal">
									  <form action="{{url('project/save_epic')}}" method="post" id="epic_form" class="form">
										<input type="hidden" name="project_id" value="{{$project->id}}" />
									  <div class="modal-dialog" role="document">
									    <div class="modal-content">
									      <div class="modal-header">
									        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									        <h4 class="modal-title text-center" id="exampleModalLabel">Create/Edit Project Epic</h4>
									      </div>
									      <div class="modal-body">
									        <div class="container-fluid">
									          <div class="row">
									          	<div class="col-md-12" id="epic_form_body">
									          	</div>
									          </div>
									        </div>
									      </div>
									      <div class="modal-footer">
									        <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="cancel_epic">Cancel</button>
									        <button type="submit" class="btn btn-primary" id="save_epic">Save Epic</button>
									      </div>
									    </div>
									  </div>
									  </form>
									</div>

	            	</div>
	            </div>
	        </div>
	    </div>
	    <div class="col-md-6">
	        <div class="panel panel-default" id="teams_container">
	            @include('projects.project_teams')
	        </div>
	    </div>
    </div>
@include('teams.team_create')
</div>
@endsection

@section('css-includes')
<link href="{{ asset('/css/jquery.minicolors.css') }}" rel="stylesheet">
@endsection

@section('js-includes')
<script src="{{ asset('/js/jquery.minicolors.min.js') }}"></script>
<script src="{{ asset('/js/project_settings.js') }}"></script>
@endsection
