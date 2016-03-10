@extends('app')

@section('content')
<div class="container setup-page">
	<div class="row">&nbsp;</div>
    <div class="row">
    	<div class="col-md-8">
	        <div class="panel panel-default">
						<div class="user-loading">
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
	            <div class="panel-heading">
	            	<div class="row">
		            	<div class="col-md-6 title">
		            		<i class="picon picon-torso-business">&nbsp;&nbsp;&nbsp;&nbsp;</i>Users
		            	</div>
		            	<div class="col-md-6">
			                <div class="input-group">
									      <input type="text" class="form-control" placeholder="Search user..." id="userSearch">
									      <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
									    </div>
									</div>
								</div>
	            </div>

	            <div class="panel-body">
	            	<div class="container-fluid" id="users_container">
	                @include('setup.users_list')
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="col-md-4">
	        <div class="panel panel-default">
	        	<div class="role-loading">
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
	            <div class="panel-heading">
	            	<div class="row">
		            	<div class="col-md-6 title">
			            	<i class="picon picon-puzzle">&nbsp;&nbsp;&nbsp;&nbsp;</i>Roles
			            </div>
		            	<div class="col-md-6">
			                <div class="input-group">
						      <input type="text" class="form-control" placeholder="Search role..." id="roleSearch">
						      <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
						    </div>
						</div>
					</div>
			    </div>

	            <div class="panel-body">
	            	<div class="container-fluid" id="roles_container">
	                @include('setup.roles_list')
	                </div>
	            </div>
	        </div>
	    </div>
    </div>
    <div class="row">
    	<div class="col-md-12">
	        <div class="panel panel-default">
						<div class="project-loading">
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
	            <div class="panel-heading">
	            	<div class="row">
		            	<div class="col-md-6 title">
			            	<img class="project-icon" src="{{asset('storage/app/projects_icons/default.png')}}" />Projects
			            </div>
		            	<div class="col-md-6">
			                <div class="input-group">
						      <input type="text" class="form-control" placeholder="Search project..." id="prjSearch">
						      <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
						    </div>
						</div>
					</div>
			    </div>

	            <div class="panel-body">
	            	<div class="container-fluid" id="project_container">
	                @include('setup.projects_list')
	                </div>
	            </div>
	        </div>
	    </div>
    </div>
    <div class="row">
    	<div class="col-md-12">
	        <div class="panel panel-default">
						<div class="teams-loading">
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
	            <div class="panel-heading">
	            	<div class="row">
		            	<div class="col-md-6 title">
			            	<i class="picon picon-torsos-all">&nbsp;&nbsp;&nbsp;&nbsp;</i>Teams
			            </div>
		            	<div class="col-md-6">
			                <div class="input-group">
						      <input type="text" class="form-control" placeholder="Search team..." id="teamSearch">
						      <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
						    </div>
						</div>
					</div>
			    </div>

	            <div class="panel-body">
	            	<div class="container-fluid" id="teams_container">
	                @include('setup.teams_list')
	              </div>
	            </div>
	        </div>
	    </div>
    </div>
</div>
@endsection

@section('js-includes')
<script src="{{ asset('/js/setup.js') }}"></script>

@endsection
