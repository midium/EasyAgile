<div class="setup-list-container">
	<table class="table table-bordered table-hover table-condensed table-striped">
	  <thead>
	    <tr>
	      <th class="hide">id</th>
	      <th>Name</th>
	      <th>Description</th>
				<th>Users</th>
	      <th>Projects</th>
	      <th class="small-col"></th>
	    </tr>
	  </thead>
		<tbody id="teamContent">
	  	@if(isset($teams) && $teams->count() > 0)
		  	@foreach($teams as $team)
		    <tr>
		      <td id="team_id" class="hide">{{$team->id}}</td>
		      <td>{{$team->name}}</td>
		      <td>{{$team->description}}</td>
					<td>
						@if($team->users()->count() > 0)
							@foreach($team->users as $user)
							<span class="team-user-item">{{$user->name}}</span>
							@endforeach
						@else
							<span>No users in this team so far.</span>
						@endif
					</td>
		      <td>{{(isset($team->projects))?$team->projects->count():'0'}}</td>
		      <td class="text-center">
		      	<a href="{{url('setup/get_team')}}" class="btn btn-default btn-xs" title="Edit" data-toggle="tooltip" data-placement="top" id="edit_team"><i class="picon picon-pencil-3"></i></a>
		      	<a href="{{url('setup/remove_team')}}" class="btn btn-default btn-xs" title="Remove" data-toggle="tooltip" data-placement="top" id="remove_team"><i class="picon picon-cup"></i></a>
		      </td>
		    </tr>
		  	@endforeach
		@else
			<tr>
				<td colspan="4">No teams available</td>
			</tr>
		@endif
	  </tbody>
	</table>
</div>

	<button class="btn btn-primary pull-right" id="create_team">Create a Team</button>

	@include('teams.team_create')

	<script>
	var teams = new Jets({
		searchTag: '#teamSearch',
		contentTag: '#teamContent'
	});
	</script>
