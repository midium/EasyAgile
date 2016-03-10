<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use View;
use Session;
use Cookie;
use Auth;
use Mail;
use Log;
use DB;
use Storage;
use File;
use App\User;
use App\Project;
use App\Epic;
use App\Team;
use App\Sprint;
use App\SprintStatus;
use App\ProjectStatus;
use App\Task;

class ProjectController extends Controller
{

	public function filterProjects(Request $request){
		$name = $request->name;
		$code = $request->code;
		$manager_id = $request->manager_id;
		$status_id = $request->status_id;
		$from_date = $request->from_date;
		$to_date = $request->to_date;

		$projects = null;

		if(($name == null || $name == '') &&
			 ($code == null || $code == '') &&
			 ($manager_id == null || $manager_id == '' || $manager_id <= 0) &&
			 ($status_id == null || $status_id == ''  || $status_id <= 0) &&
			 ($from_date == null || $from_date == '') &&
			 ($to_date == null || $to_date == '')){
			//Basically no filters
			$projects = Project::orderBy('name')->paginate(10);

		} else {
			//Filters to be applied
			$where = '';

			if($name != null && $name != ''){
				$where = "LCASE(name) LIKE '%".strtolower($name)."%'";
			}

			if($code != null && $code != ''){
				if($where == ''){
					$where = "LCASE(code) LIKE '%".strtolower($code)."%'";
				} else {
					$where .= " AND LCASE(code) LIKE '%".strtolower($code)."%'";
				}
			}

			if($manager_id != null && $manager_id != '' && $manager_id > 0){
				if($where == ''){
					$where = "manager_id = $manager_id";
				} else {
					$where .= " AND manager_id = $manager_id";
				}
			}

			if($status_id != null && $status_id != '' && $status_id > 0){
				if($where == ''){
					$where = "status_id = $status_id";
				} else {
					$where .= " AND status_id = $status_id";
				}
			}

			if($from_date != null && $from_date != ''){
				if($where == ''){
					$where = "created_at >= '$from_date 00:00:00'";
				} else {
					$where .= " AND created_at >= '$from_date 00:00:00'";
				}
			}

			if($to_date != null && $to_date != ''){
				if($where == ''){
					$where = "created_at <= '$to_date 23:59:59'";
				} else {
					$where .= " AND created_at <= '$to_date 23:59:59'";
				}
			}

			$projects = Project::whereRaw($where)->orderBy('name')->paginate(10);

		}

		$projects->setPath('projects');

		$view = view('projects.widgets.projects_list')->with('projects', $projects);

		return response()->json(['success' => true, 'value' => $view->render()]);

	}

	public function getSprintForm(Request $request){
		if($request->sprint_id != null){
			$sprint = Sprint::find($request->sprint_id);
			$project_id = $sprint->project->id;
		} else {
			$sprint = null;
			$project_id = $request->prj_id;
		}

		$sprint_statuses = SprintStatus::all();

		$view = view('projects.forms.sprint')->with('sprint', $sprint)
																							->with('project_id', $project_id)
																						 	->with('sprint_statuses', $sprint_statuses);

		return response()->json(['success' => true, 'value' => $view->render()]);
	}

	/**
	* This routine will be called to allow sorting the backlog list when we are not in the page
	*		allowing to add tasks to a sprint (finished or in progress).
	*/
	public function sortBacklogTasks(Request $request)
	{
		try{
			$data = json_decode($request->data);
			$counter = 1;
			foreach($data[0] as $key => $info){
				$task = Task::find($info->id);
				if(isset($task)){
					$task->order_number = $counter;
					$task->save();

					$counter++;
				}
			}

			return response()->json(['success' => true]);

		} catch(Exception $e) {
			return response()->json(['success' => false, 'error' => $e->getMessage()]);
		}
	}

	/**
	* This routine is handling the move of tasks from backlog to the sprint.
	* It is given both the list of the tasks dragged into the sprint in order and also
	*  the list of all the tasks in the backlog sorted as well.
	* We can then use this to sort both those lists.
	* Anyway this is just called when moving tasks looking to a planned sprint.
	*/
	public function moveTaskToSprint(Request $request)
	{
		if($request->sprint_id == null || $request->sprint_id == '' || $request->sprint_id == 0){
			return response()->json(['success' => false, 'error' => 'Sprint not declared or not available']);
		}

		//Checking if the task is already solved as in case I won't allow to add it
		$data = json_decode($request->data);
		foreach($data[0] as $key => $info){
			$task = Task::find($info->id);
			if(isset($task)){
				if($task->isCompleted()){
					return response()->json(['success' => false, 'error' => 'You cannot move a closed task inside a sprint.']);
				}
			}
		}

		//First I remove association of any task previously associated to this sprint
		// (this allow to restore tasks in the backlog if I've removed it from the sprint with the drag/drop)
		DB::table('tasks')->where('sprint_id', $request->sprint_id)->update(['sprint_id' => -1]);

		//Now I associate all the necessary tasks
		//$data[0] is the sprint container
		$counter = 1;
		foreach($data[0] as $key => $info){
			$task = Task::find($info->id);
			if(isset($task)){
				$task->sprint_id = $request->sprint_id;
				$task->order_number = $counter;
				$task->save();

				$counter++;
			}
		}

		//Now I also order the $data[1] which is the backlog
		$counter = 1;
		foreach($data[1] as $key => $info){
			$task = Task::find($info->id);
			if(isset($task)){
				$task->order_number = $counter;
				$task->save();

				$counter++;
			}
		}

		//Getting sprint and tasks for counting purposes
		$sprint =  Sprint::find($request->sprint_id);
		$tasks = $sprint->project->getBacklogTasks();

		return response()->json(['success' => true, 'value' => ['sprint_tasks' => $sprint->tasks()->count(),
																														'backlog_tasks' => $tasks->count() ]]);

	}

	public function createProjectView()
	{
		return view('projects/create_project')->with('users', User::all())
												->with('title', 'Create')
												->with('project', null)
												->with('uri', 'project/save')
												->with('project_statuses', ProjectStatus::all())
												->with('header', '');
	}

	public function allProjectsView(){
		return view('projects/view_projects')->with('projects', Project::orderBy('created_at','desc')->paginate(10))
																				 ->with('header', 'nav.projects.all_projects_header')
																				 ->with('users', User::all())
																				 ->with('project_statuses', ProjectStatus::all());
	}

	public function saveSprint(Request $request)
	{
		if($request->project_id == null || $request->project_id == ''){
			return response()->json(['success' => false, 'error' => 'Project not specified.']);

		} else {
			//Before continuing I need to check if the provided sprint limits are not inside other sprints periods
			$sprint_on_period = Sprint::where('project_id', '=', $request->project_id)
																->whereRaw("((LEFT(from_date,10) < '".substr($request->from_date,0,10)."' AND LEFT(to_date, 10) > '".substr($request->from_date,0,10)."') OR (LEFT(from_date,10) < '".substr($request->to_date,0,10)."' AND LEFT(to_date, 10) > '".substr($request->to_date,0,10)."'))")
																->count();
			if($sprint_on_period > 0){
				return response()->json(['success' => false, 'error' => "It has been specified a period where there is already another sprint for this project.\nPlease amend the values to continue."]);
			}

			if($request->id != null){
				$sprint = Sprint::find($request->id);
				$sprint->name = $request->name;
				$sprint->from_date = $request->from_date;
				$sprint->to_date = $request->to_date;

			} else {
				$sprint = Sprint::create($request->all());
			}

			$sprint->save();

			return response()->json(['success' => true]);
		}
	}

	public function checkSprintOpenTasks(Request $request){

		$sprint = Sprint::find($request->sprint_id);
		$sprint_tasks = $sprint->tasks;

		foreach($sprint_tasks as $task){
			if($task->isCompleted() == false){
				return response()->json(['success' => true, 'value' => true]);

			} else {
				foreach($task->sub_tasks as $subtask){
					if($subtask->isCompleted() == false){
						return response()->json(['success' => true, 'value' => true]);
					}
				}
			}
		}

		return response()->json(['success' => true, 'value' => false]);
	}

	public function moveOpenTasksToBacklog(Request $request){

		$sprint = Sprint::find($request->sprint_id);
		$sprint_tasks = $sprint->tasks;
		foreach($sprint_tasks as $task){
			if($task->isCompleted() == false){
				$task->sprint_id = -1;
				$task->save();

			} else {
				foreach($task->sub_tasks as $subtask){
					if($subtask->isCompleted() == false){
						//If the task has even a single subtask still open, the entire task will be moved to the backlog
						$task->sprint_id = -1;
						$task->save();
						break;
					}
				}
			}
		}

	}

	public function changeSprintStatus(Request $request){
		if($request->sprint_id == null || trim($request->sprint_id) == ''){
			return response()->json(['success' => false, 'error' => 'Sprint not specified.']);
		}

		if($request->status_id == null || trim($request->status_id) == ''){
			return response()->json(['success' => false, 'error' => 'Current sprint status not specified.']);
		}

		$sprint = Sprint::find($request->sprint_id);

		switch($request->status_id){
			case 1: //In Progress --> setting finished
				$sprint->sprint_status_id = 3;
				break;

			case 2: //Planned --> setting in progress
				$open_sprints = Sprint::where('sprint_status_id', '=', 1)->where('project_id', '=', $sprint->project_id)->count();

				if($open_sprints > 0){
					return response()->json(['succes' => false, 'error' => "There is another sprint in progress at the moment for this project.\nPlease complite that sprint to run this one."]);
				}

				$sprint->sprint_status_id = 1;
				break;
		}
		$sprint->save();

		return response()->json(['success' => true, 'value' => '']);

	}

	public function deleteSprint(Request $request){
		if($request->sprint_id == null || trim($request->sprint_id) == ''){
			return response()->json(['success' => false, 'error' => 'Sprint not specified.']);
		}

		DB::update('UPDATE tasks SET sprint_id = -1 WHERE sprint_id = ?', array($request->sprint_id));

		$sprint = Sprint::find($request->sprint_id);
		$project_id = $sprint->project_id;
		$sprint->delete();

		return response()->json(['success' => true, 'value' => "/project/$project_id"]);
	}

	public function saveProject(Request $request)
	{

		if ($request->hasFile('image') && $request->file('image')->isValid() ) {
			$file = $request->file('image');
		}

		if($request->id != null){
			$project = Project::find($request->id);
			$project->name = $request->name;
			$project->description = $request->description;
			$project->manager_id = $request->manager_id;
			$project->status_id = $request->status_id;

		} else {
			$project = Project::create($request->all());

		}

		$project->save();

		if(isset($file)){
			Storage::disk('local')->put('/projects_icons/'.$project->id.'.png',  File::get($file));
		}

		return redirect('/project/'.$project->id.'/settings');

	}

	public function projectRemoveEpic(Request $request){
		if($request->epic_id == null){
			return response()->json(['success' => false, 'error' => 'Epic ID not provided.']);

		} else {
			$epic = Epic::find($request->epic_id);
			if(isset($epic)){
				$epic->delete();
			}

			$epics = Project::find($request->project_id)->epics;
			$view = view('projects.epics_table')->with('epics', $epics)->with('project', Project::find($request->project_id));

			return response()->json(['success' => true, 'value' => $view->render()]);

		}
	}

	public function projectAddTeam(Request $request){
		if($request->project_id != null){
			if($request->team_id != null){
				$project = Project::find($request->project_id);
				if(isset($project)){
					//I attach the team to the project
					$project->teams()->attach($request->team_id);

					return response()->json(['success' => true]);

				} else {
					return response()->json(['success' => false, 'error' => 'The project doesn\'t exists.']);
				}

			} else {
				return response()->json(['success' => false, 'error' => 'The team has not been specified.']);

			}

		} else {
			return response()->json(['success' => false, 'error' => 'The project has not been specified.']);

		}
	}

	public function projectRemoveTeam(Request $request){
		if($request->project_id != null){
			if($request->team_id != null){
				$project = Project::find($request->project_id);
				if(isset($project)){
					//I attach the team to the project
					$project->teams()->detach($request->team_id);

					return response()->json(['success' => true]);

				} else {
					return response()->json(['success' => false, 'error' => 'The project doesn\'t exists.']);
				}

			} else {
				return response()->json(['success' => false, 'error' => 'The team has not been specified.']);

			}

		} else {
			return response()->json(['success' => false, 'error' => 'The project has not been specified.']);

		}
	}

	public function projectSaveEpic(Request $request){
		if($request->project_id != null){
			if($request->id != null){
				$epic = Epic::find($request->id);
				if(isset($epic)){
					$epic->project_id = $request->project_id;
					$epic->name = $request->name;
					$epic->description = ($request->description!=null && $request->description!='')?$request->description:null;
					$epic->color = ($request->color!=null && $request->color!='')?$request->color:null;

				} else {
					return response()->json(['success' => false, 'error' => 'Can\'t find the specified Epic.']);

				}

			} else {
				$epic = Epic::create($request->all());

			}

		} else {
			return response()->json(['success' => false, 'error' => 'The project has not been specified, cannot continue creating the Epic.']);

		}
		$epic->save();

		$epics = Project::find($request->project_id)->epics;
		$view = view('projects.epics_table')->with('epics', $epics)->with('project', Project::find($request->project_id));

		return response()->json(['success' => true, 'value' => $view->render()]);
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

	public function projectGetEpic(Request $request){
		$epic = null;
		if(!($request->id == null || $request->id == '')){
			$epic = Epic::find($request->id);
		}

		$view = view('projects.forms.epic_form_body')->with('epic', $epic);

		return response()->json(['success' => true, 'value' => $view->render()]);
	}

	public function projectPage($id, $sprint_id = null)
	{
		$project = Project::find($id);

		$sprint = null;
		if($sprint_id == null){
			$sprint = $project->getCurrentSprint();
		} else {
			$sprint = Sprint::find($sprint_id);
		}

		if(isset($sprint->to_date) && $sprint->to_date != null && substr($sprint->to_date,0,10) == date('Y-m-d')){
			$message = "The sprint '".$sprint->name."' is ending today.\nPlease reviewit with your team before closing it.";
			$message_title = 'Sprint ending';
			$message_type = 'warning';
		} else {
			$message = '';
			$message_title = '';
			$message_type = '';
		}

		return view('projects/project_page')->with('project', $project)
																				->with('sprint', $sprint)
																				->with('message', $message)
																				->with('message_type', $message_type)
																				->with('message_title', $message_title)
																				->with('header', 'nav.projects.project_header');
	}

	public function createTeam(Request $request){

		$project = null;
		if($request->project_id == null){
			return response()->json(['success' => false, 'error' => 'Project not provided.']);

		} else {
			$project = Project::find($request->project_id);
			if(!isset($project)){
				return response()->json(['success' => false, 'error' => 'The given Project is no more available.']);
			}

		}

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

		//Attaching the new team to the project
		$team->projects()->attach($request->project_id);

		$available_teams = Team::whereNotIn('id', $project->teams->lists('id'))->orderBy('name')->get();
		$view = view('projects.project_teams')->with('project', $project)
																				 ->with('available_teams', $available_teams);

		return response()->json(['success' => true, 'value' => $view->render()]);

	}

	public function projectSettingsPage($id)
	{
		$project = Project::find($id);
		$epics = $project->epics;
		$available_teams = Team::whereNotIn('id', $project->teams->lists('id'))->orderBy('name')->get();

		return view('projects/project_settings')->with('project', $project)
												->with('isSettings', true)
												->with('epics', $epics)
												->with('available_teams', $available_teams)
												->with('uri', 'project/update')
												->with('team_form_uri', '/project/create_team')
												->with('users', User::all())
												->with('project_statuses', ProjectStatus::all())
												->with('header', 'nav.projects.project_header');
	}

}
