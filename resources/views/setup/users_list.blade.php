	<div class="setup-list-container">
	<table class="table table-bordered table-hover table-condensed table-striped">
	  <thead>
	    <tr>
	      <th class="hide">id</th>
	      <th>Name</th>
	      <th>Email</th>
	      <th>Privileges</th>
	      <th>Role</th>
	      <th class="small-col"></th>
	    </tr>
	  </thead>
	  <tbody id="userContent">
	  	@foreach($users as $user)
	    <tr>
	      <td id="user_id" class="hide">{{$user->id}}</td>
	      <td>{{$user->name}}</td>
	      <td><a href="mailto:{{$user->email}}" id="user_email">{{$user->email}}</a></td>
	      <td>{{$user->privileges->name}}</td>
	      <td>{{($user->role!=null)?$user->role->name:''}}</td>
	      <td class="text-center">
	      	<a id="user_privilege_role" href="{{url('setup/get_user_credentials')}}" class="btn btn-default btn-xs" title="Edit privilege and role" data-toggle="tooltip" data-placement="top"><i class="picon picon-pencil-3"></i></a>
	      	<a id="remove_user" href="{{url('setup/remove_user')}}" class="btn btn-default btn-xs" title="Remove user" data-toggle="tooltip" data-placement="top"><i class="picon picon-cup"></i></a>
					<span>{{$user->token}}</span>
	      	<a id="reset_user_password" href="{{url('password/email')}}" class="btn btn-default btn-xs" title="Reset Password" data-toggle="tooltip" data-placement="top"><i class="picon picon-cloud-thunder"></i></a>
	      </td>

	    </tr>
	  	@endforeach
	  </tbody>
	</table>
	</div>

	<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModal">
		<form action="{{url('setup/save_user_credentials')}}" method="post" id="user_form" class="form">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title text-center" id="exampleModalLabel">Edit User Privileges and Role</h4>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-12" id="users_form_container">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="cancel_user">Cancel</button>
					<button type="submit" class="btn btn-primary" id="save_user">Save</button>
				</div>
			</div>
		</div>
		</form>
	</div>

	<script>
	var users = new Jets({
	  searchTag: '#userSearch',
	  contentTag: '#userContent'
	});
	</script>
