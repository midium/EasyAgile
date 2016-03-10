<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use View;
use Session;
use Cookie;
use Auth;
use Mail;
use Log;
use Storage;
use File;
use App\User;
use App\Project;
use App\Epic;
use App\Team;
use App\Role;
use App\Privilege;

class EasyAgileController extends Controller
{

	public function setupPage()
	{
		$users = User::orderBy('name')->get();
		$projects = Project::orderBy('name')->get();
		$teams = Team::orderBy('name')->get();
		$roles = Role::orderBy('name')->get();

		return view('setup/setup_page')->with('users', $users)
										->with('projects', $projects)
										->with('teams', $teams)
										->with('roles', $roles)
										->with('team_form_uri', 'setup/team_save')
										->with('is_setup', true)
										->with('header', 'nav.setup.setup_header')
										->with('container_overflow', true);
	}

	public function setupDeleteRole(Request $request)
	{
		if(isset($request->id)){
			return response()->json(['success' => false, 'error' => 'Role ID not provided.']);

		} else {
			$role = Role::find($request->id);
			if(isset($role)){
				$role->delete();
			}

			$roles = Role::orderBy('name')->get();
			$view = view('setup.roles_list')->with('roles', $roles);

			return response()->json(['success' => true, 'value' => $view->render()]);

		}
	}

	public function getRole(Request $request)
	{
		if(isset($request->id)){
			return response()->json(['success' => false, 'error' => 'Role ID not provided.']);

		} else {
			$role = Role::find($request->id);

			return response()->json(['success' => true, 'value' => $role]);

		}
	}

	public function setupSaveRole(Request $request)
	{

		if($request->id != null){
			$role = Role::find($request->id);
			if(isset($role)){
				$role->name = $request->name;

			} else {
				$role = Role::create($request->all());

			}

		} else {
			$name_choosen = Role::where('name', '=', $request->name)->get();

			if(isset($name_choosen) && $name_choosen->count()!=0){
				return response()->json(['success' => false, 'error' => 'Role name already choosen.']);
			}

			$role = Role::create($request->all());

		}
		$role->save();

		$roles = Role::orderBy('name')->get();
		$view = view('setup.roles_list')->with('roles', $roles);

		return response()->json(['success' => true, 'value' => $view->render()]);

	}

	public function getUserCredentials(Request $request){
		$user = User::find($request->id);
		$privileges = Privilege::orderBy('name')->get();
		$roles = Role::orderBy('name')->get();

		$view = view('setup.forms.user_permissions')->with('user', $user)
																								->with('privileges', $privileges)
																								->with('roles', $roles);

		return response()->json(['success' => true, 'value' => $view->render()]);

	}

	public function setupRemoveUser(Request $request){
		if(isset($request->id)){
			return response()->json(['success' => false, 'error' => 'User ID not provided.']);

		} else {
			$user = User::find($request->id);
			if(isset($user)){
				$user->delete();
			}

			$view = view('setup.users_list')->with('users', User::orderBy('name')->get());

			return response()->json(['success' => true, 'value' => $view->render()]);

		}
	}

	public function saveUserCredentials(Request $request){
			if($request->user_id != null){
				$user = User::find($request->user_id);
				if(isset($user)){
					$user->privilege_id = $request->privilege_id;
					$user->role_id = ($request->role_id!=null && $request->role_id!=-1)?$request->role_id:null;

				} else {
					return response()->json(['success' => false, 'error' => 'Can\'t find the specified user.']);

				}

			} else {
				return response()->json(['success' => false, 'error' => 'User not specified.']);

			}
			$user->save();

			$users = User::orderBy('name')->get();
			$view = view('setup.users_list')->with('users', $users);

			return response()->json(['success' => true, 'value' => $view->render()]);
	}

	public function getProject(Request $request){
		if($request->prj_id != null){
			$project = Project::find($request->prj_id);
			$uri = 'project/update';
		} else {
			$project = null;
			$uri = 'project/save';
		}

		$view = view('projects.forms.project_details_form_body')->with('uri', $uri)
																														 ->with('project', $project)
																														 ->with('users', User::orderBy('name')->get());

		return response()->json(['success' => true, 'value' => $view->render()]);

	}

	public function setupSaveProject(Request $request)
	{

		if ($request->hasFile('image') && $request->file('image')->isValid() ) {
			$file = $request->file('image');
		}

		if($request->id != null){
			$project = Project::find($request->id);
			$project->name = $request->name;
			$project->description = $request->description;
			$project->manager_id = $request->manager_id;

		} else {
			$name_choosen = Project::where('name', '=', $request->name)->get();
			if(isset($name_choosen) && $name_choosen->count()!=0){
				return response()->json(['success' => false, 'error' => 'Project name already choosen.']);
			}

			$project = Project::create($request->all());

		}

		$project->save();

		if(isset($file)){
			Storage::disk('local')->put('/projects_icons/'.$project->id.'.png',  File::get($file));
		}

		$view = view('setup.projects_list')->with('projects', Project::orderBy('name')->get());

		return response()->json(['success' => true, 'value' => $view->render()]);

	}

	public function setupDeleteProject(Request $request)
	{
		if(isset($request->id)){
			return response()->json(['success' => false, 'error' => 'Project ID not provided.']);

		} else {
			$project = Project::find($request->id);
			if(isset($project)){
				//Removing all links to teams
				$project->teams()->detach();
				
				//TODO: remove also all epics related to the project and all the tasks

				$project->delete();
			}

			$view = view('setup.projects_list')->with('projects', Project::orderBy('name')->get());

			return response()->json(['success' => true, 'value' => $view->render()]);

		}
	}

	public function getTeam(Request $request){
		if($request->team_id != null){
			$team = Team::find($request->team_id);
			$available_users = User::whereIn('id', User::has('teams', '=', $request->team_id)->lists('id'))->orderBy('name')->get();
		} else {
			$team = null;
			$available_users = User::orderBy('name')->get();
		}

		$view = view('teams.team_form_modal_body')->with('team', $team)
																						 	->with('users', $available_users);

		return response()->json(['success' => true, 'value' => $view->render()]);

	}

	public function setupSaveTeam(Request $request)
	{

		if($request->id != null){
			$team = Team::find($request->id);
			if(isset($team)){
				$team->name = $request->name;
				$team->description = $request->description;

				//I remove all link to users to renew them later
				$team->users()->detach();

			} else {
				return response()->json(['success' => false, 'error' => 'The given Team is no more available.']);
			}

		} else {
			$name_choosen = Team::where('name', '=', $request->name)->get();
			if(isset($name_choosen) && $name_choosen->count()!=0){
				return response()->json(['success' => false, 'error' => 'Team name already choosen.']);
			}

			$team = Team::create($request->all());

		}

		$team->save();

		//Saving/Updating links to the users
		if($request->users!=null && $request->users!='')
		{
			$users_ids = explode(',', $request->users);

			foreach($users_ids as $user_id){
				$team->users()->attach($user_id);
			}
		}

		$view = view('setup.teams_list')->with('teams', Team::orderBy('name')->get());

		return response()->json(['success' => true, 'value' => $view->render()]);

	}

	public function setupDeleteTeam(Request $request)
	{

		if(isset($request->id) || $request->id == null){
			return response()->json(['success' => false, 'error' => 'Team ID not provided.']);

		} else {
			$team = Team::find($request->id);
			if(isset($team)){
				//First I delete the intermediate links
				$team->users()->detach();
				$team->projects()->detach();

				//Now I delete the Team
				$team->delete();
			}

			$view = view('setup.teams_list')->with('teams', Team::orderBy('name')->get())
																		  ->with('team_form_uri', 'setup/team_save');

			return response()->json(['success' => true, 'value' => $view->render()]);

		}
	}

}
