	<div class="setup-list-container">
		<input type="hidden" id="token" name="_token" value="<?= csrf_token() ?>" />
		<table class="table table-bordered table-hover table-condensed table-striped">
		  <thead>
		    <tr>
		      <th class="hide">id</th>
		      <th>Name</th>
		      <th class="small-col"></th>
		    </tr>
		  </thead>
		  <tbody id="roleContent">
		  	@if(isset($roles) && $roles->count() > 0)
			  	@foreach($roles as $role)
			    <tr>
			      <td id="role_id" class="hide">{{$role->id}}</td>
			      <td>{{$role->name}}</td>
			      <td class="text-center">
			      	<a href="{{url('setup/get_role')}}" id="edit_role" class="btn btn-default btn-xs" title="Edit" data-toggle="tooltip" data-placement="top"><i class="picon picon-pencil-3"></i></a>
			      	<a href="{{url('setup/delete_role')}}" id="role_delete" class="btn btn-default btn-xs" title="Remove" data-toggle="tooltip" data-placement="top"><i class="picon picon-cup"></i></a>
			      </td>

			    </tr>
			  	@endforeach
			@else
				<tr>
					<td colspan="2">No roles available</td>
				</tr>
			@endif
		  </tbody>
		</table>
	</div>

	<button class="btn btn-primary pull-right" id="role">Create a Role</button>

	<div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModal">
	  <form action="{{url('setup/save_role')}}" method="post" id="role_form" class="form">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title text-center" id="exampleModalLabel">Create/Edit Role</h4>
	      </div>
	      <div class="modal-body">
	        <div class="container-fluid">
	          <div class="row">
	          	<div class="col-md-12">
	          	@include('setup.forms.role_form')
	          	</div>
	          </div>
	        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="cancel_role">Cancel</button>
	        <button type="submit" class="btn btn-primary" id="save_role">Save Role</button>
	      </div>
	    </div>
	  </div>
	  </form>
	</div>

<script>
var roles = new Jets({
  searchTag: '#roleSearch',
  contentTag: '#roleContent',
  cols: [0] // optional, search by first column only
});
</script>
