<div class="setup-list-container">
	<table class="table table-bordered table-hover table-condensed table-striped">
	  <thead>
	    <tr>
	      <th class="hide">id</th>
	      <th>Icon</th>
	      <th>Name</th>
	      <th>Description</th>
	      <th>Manager</th>
	      <th class="small-col"></th>
	    </tr>
	  </thead>
	  <tbody id="prjContent">
	  	@if(isset($projects) && $projects->count() > 0)
		  	@foreach($projects as $prj)
		    <tr>
		      <td id="prj_id" class="hide">{{$prj->id}}</td>
		      <td class="text-center"><img class="project-icon-no-padding-no-margin" src="{{asset('storage/app/projects_icons').'/'.$prj->id.'.png'}}" onerror="this.src='{{ asset('storage/app/projects_icons/default.png') }}'" /></td>
		      <td>{{$prj->name}}</td>
		      <td>{{$prj->description}}</td>
		      <td>{{($prj->manager != null)?$prj->manager->name:''}}</td>
		      <td class="text-center">
		      	<a href="{{url('setup/get_project')}}" class="btn btn-default btn-xs" title="Edit" data-toggle="tooltip" data-placement="top" id="edit_prj"><i class="picon picon-pencil-3"></i></a>
		      	<a href="{{url('setup/delete_project')}}" class="btn btn-default btn-xs" title="Remove" data-toggle="tooltip" data-placement="top" id="delete_prj"><i class="picon picon-cup"></i></a>
		      </td>

		    </tr>
		  	@endforeach
		@else
			<tr>
				<td colspan="2">No projects available</td>
			</tr>
		@endif
	  </tbody>
	</table>
</div>

	<button class="btn btn-primary pull-right" id="project">Create a Project</button>

	<div class="modal fade" id="prjModal" tabindex="-1" role="dialog" aria-labelledby="prjModal">
	  <form action="{{url('setup/save_project')}}" method="post" id="prj_form" class="form" enctype="multipart/form-data">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title text-center" id="exampleModalLabel">Create/Edit Project</h4>
	      </div>
	      <div class="modal-body">
	        <div class="container-fluid">
	          <div class="row">
	          	<div class="col-md-12" id="prj_form_body">
	          	</div>
	          </div>
	        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="cancel_prj">Cancel</button>
	        <button type="submit" class="btn btn-primary" id="save_prj">Save Project</button>
	      </div>
	    </div>
	  </div>
	  </form>
	</div>

	<script>
	var prjs = new Jets({
	  searchTag: '#prjSearch',
	  contentTag: '#prjContent'
	});
	</script>
