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
use DB;
use App\User;
use App\Project;
use App\Epic;
use App\Team;
use App\TaskType;
use App\TaskStatus;
use App\Priority;
use App\Task;
use App\TaskLog;
use App\TaskComment;
use App\TaskAttachment;

class TaskController extends Controller
{

	public function quickSearchTask(Request $request)
	{
		$text = $request->string;
		$where = '';

		//First I explode on '-' to check eventually entered task code
		$pieces = explode('-', $text);

		//If there have been a real split then it make sense also to check the task id coming from the task code
		$task_id = '';

		if(count($pieces)>1){
			$task_id = $pieces[count($pieces)-1];

			$where = "(tasks.id = $task_id";
		}

		if($where == ''){
			$where = "LCASE(projects.code) LIKE '%".strtolower($pieces[0])."%' OR LCASE(tasks.subject) LIKE '%".strtolower($text)."%'";
		} else {
			$where .= " AND LCASE(projects.code) LIKE '%".strtolower($pieces[0])."%') OR LCASE(tasks.subject) LIKE '%".strtolower($text)."%'";
		}

		$how_many = Task::select(DB::raw('tasks.*'))->join('projects', 'tasks.project_id', '=', 'projects.id')->whereRaw($where)->count();
		if($how_many > 0) {
			$tasks = Task::select(DB::raw('tasks.*'))->join('projects', 'tasks.project_id', '=', 'projects.id')->whereRaw($where)->orderBy('tasks.created_at', 'desc')->paginate(20);
			if($how_many == 1) {
				//Single task found heading to that task page
				return redirect('/task/'.$tasks->first()->id);

			} else {
				//Multiple founded
				if($request->json == null || $request->json == false) {
					return view('tasks.founded')->with('tasks', $tasks)
							->with('header', 'nav.tasks.all_tasks_header')
							->with('search_string', $text);
				} else {
					$view = view('tasks.widgets.tasks_list')->with('tasks', $tasks);
					$pagination = view('personal.paginator')->with('paginator', $tasks)->with('show_pages', false);

					return response()->json(['success' => true, 'value' => $view->render(), 'nav' => $pagination->render()]);

				}

			}

		} else {
			return back()->withInput();
		}

	}

	public function filterTasks(Request $request)
	{
		$subject = $request->subject;
		$code = $request->code;
		$project_id = $request->project_id;
		$status_id = $request->status_id;
		$from_date = $request->from_date;
		$to_date = $request->to_date;
		$task_type_id = $request->task_type_id;
		$priority_id = $request->priority_id;
		$owned_by = $request->owned_by;
		$reported_by = $request->reported_by;

		$tasks = null;

		if(($subject == null || $subject == '') &&
			 ($code == null || $code == '') &&
			 ($project_id == null || $project_id == '' || $project_id <= 0) &&
			 ($status_id == null || $status_id == ''  || $status_id <= 0) &&
			 ($task_type_id == null || $task_type_id == '' || $task_type_id <= 0) &&
			 ($priority_id == null || $priority_id == ''  || $priority_id <= 0) &&
			 ($owned_by == null || $owned_by == '' || $owned_by <= 0) &&
			 ($reported_by == null || $reported_by == ''  || $reported_by <= 0) &&
			 ($from_date == null || $from_date == '') &&
			 ($to_date == null || $to_date == '')){
			//Basically no filters
			$tasks = Task::orderBy('created_at', 'desc')->paginate(20);

		} else {
			//Filters to be applied
			$where = '';
			$join = false;

			if($subject != null && $subject != ''){
				$where = "LCASE(subject) LIKE '%".strtolower($subject)."%'";
			}

			if($code != null && $code != ''){
				//Code need to be checked if the user set it complete like EAGILE-1 as in that case we need to check the code from project and the number is the task id
				$join = true;

				$exploded = explode('-', $code);

				if(count($exploded)>1){
					//There is also the task number
					if($where == ''){
						$where = "tasks.id = ".$exploded[count($exploded)-1];
					} else {
						$where .= " AND tasks.id = ".$exploded[count($exploded)-1];
					}
				}

				//Code check
				if($where == ''){
					$where = "LCASE(projects.code) LIKE '%".$exploded[0]."%'";
				} else {
					$where .= " AND LCASE(projects.code) LIKE '%".$exploded[0]."%'";
				}
			}

			if($project_id != null && $project_id != '' && $project_id > 0){
				if($where == ''){
					$where = "project_id = $project_id";
				} else {
					$where .= " AND project_id = $project_id";
				}
			}

			if($status_id != null && $status_id != '' && $status_id > 0){
				if($where == ''){
					$where = "tasks.status_id = $status_id";
				} else {
					$where .= " AND tasks.status_id = $status_id";
				}
			}

			if($from_date != null && $from_date != ''){
				if($where == ''){
					$where = "tasks.created_at >= '$from_date 00:00:00'";
				} else {
					$where .= " AND tasks.created_at >= '$from_date 00:00:00'";
				}
			}

			if($to_date != null && $to_date != ''){
				if($where == ''){
					$where = "tasks.created_at <= '$to_date 23:59:59'";
				} else {
					$where .= " AND tasks.created_at <= '$to_date 23:59:59'";
				}
			}

			if($task_type_id != null && $task_type_id != '' && $task_type_id > 0){
				if($where == ''){
					$where = "tasks.task_type_id = $task_type_id";
				} else {
					$where .= " AND tasks.task_type_id = $task_type_id";
				}
			}

			if($priority_id != null && $priority_id != '' && $priority_id > 0){
				if($where == ''){
					$where = "tasks.priority_id = $priority_id";
				} else {
					$where .= " AND tasks.priority_id = $priority_id";
				}
			}

			if($owned_by != null && $owned_by != '' && $owned_by > 0){
				if($where == ''){
					$where = "owned_by = $owned_by";
				} else {
					$where .= " AND owned_by = $owned_by";
				}
			}

			if($reported_by != null && $reported_by != '' && $reported_by > 0){
				if($where == ''){
					$where = "created_by = $reported_by";
				} else {
					$where .= " AND created_by = $reported_by";
				}
			}

			if(!$join)
				$tasks = Task::select(DB::raw('tasks.*'))->whereRaw($where)->orderBy('tasks.created_at', 'desc')->paginate(20);
			else
				$tasks = Task::select(DB::raw('tasks.*'))->join('projects', 'tasks.project_id', '=', 'projects.id')->whereRaw($where)->orderBy('tasks.created_at', 'desc')->paginate(20);

		}

		$tasks->setPath('tasks');

		$view = view('tasks.widgets.tasks_list')->with('tasks', $tasks);
		$pagination = view('personal.paginator')->with('paginator', $tasks)->with('show_pages', false);

		return response()->json(['success' => true, 'value' => $view->render(), 'nav' => $pagination->render()]);
	}

	public function viewAllTasks()
	{
		return view('tasks/all')->with('tasks', Task::orderBy('created_at', 'desc')->paginate(20))
																				->with('header', 'nav.tasks.all_tasks_header')
																				->with('users', User::orderBy('name')->get())
																				->with('task_types', TaskType::all())
																				->with('priorities', Priority::all())
																				->with('projects', Project::orderBy('name')->get())
																				->with('task_statuses', TaskStatus::all());

	}

	public function createTaskView()
	{
		return view('tasks/create')->with('users', User::orderBy('name')->get())
      												->with('task_types', TaskType::all())
															->with('title', 'New Task')
                              ->with('task_statuses', TaskStatus::all())
                              ->with('priorities', Priority::all())
                              ->with('projects', Project::orderBy('name')->get())
                              ->with('epics', Epic::all())
      												->with('project', null)
															->with('parent_task', null)
      												->with('header', 'nav.projects.project_header')
                              ->with('header_no_buttons', true);
	}

  public function createProjectTaskView($id)
	{
		return view('tasks/create')->with('users', User::orderBy('name')->get())
      												->with('task_types', TaskType::all())
															->with('title', 'New Task')
                              ->with('task_statuses', TaskStatus::all())
                              ->with('priorities', Priority::all())
                              ->with('projects', Project::orderBy('name')->get())
                              ->with('epics', Epic::all())
      												->with('project', Project::find($id))
															->with('parent_task', null)
      												->with('header', 'nav.projects.project_header')
                              ->with('header_no_buttons', true);
	}

	public function createSubTaskView($pid, $tid)
	{
		return view('tasks/create')->with('users', User::orderBy('name')->get())
      												->with('task_types', null)
															->with('title', 'New Sub Task of: ')
                              ->with('task_statuses', TaskStatus::all())
                              ->with('priorities', Priority::all())
                              ->with('projects', null)
                              ->with('epics', null)
      												->with('project', Project::find($pid))
															->with('parent_task', Task::find($tid))
      												->with('header', 'nav.projects.project_header')
                              ->with('header_no_buttons', true);
	}

	public function convertSubtaskToNormal($id, $pid){
		if(!isset($pid) || $pid <= 0)
			$prj_uri = 'projects/all';
		else
			$prj_uri = "project/$pid";


		if(!isset($id) || $id <= 0){
			return redirect($prj_uri)->with('error', 'Task identity not valid');
		}

		$task = Task::find($id);

		if(!isset($task)){
			return redirect($prj_uri)->with('error', 'Task not found');
		}

		$task->sprint_id = $task->parent_task->sprint_id;
		$task->parent_task_id = 0;
		$task->save();

		return redirect($prj_uri);

	}

	public function getComment(Request $request){
		if($request->task_id == null){
			return response()->json(['success' => false, 'error' => 'Task identity not provided']);
		}

		if($request->type == null || $request->type == ''){
			$type = 'widgets';
		} else {
			$type = $request->type;
		}

		$edit_comment = null;
		if($request->comment_id){
			$edit_comment = TaskComment::find($request->comment_id);
		}

		$quote = '';
		if($request->quote != null){
			$quote = '<blockquote>'.$request->quote.'</blockquote><br>';
		}

		$view = view('tasks/'.$type.'/comments')->with('task', Task::find($request->task_id))
																					  ->with('users', User::all())
																						->with('quote', $quote)
																						->with('edit_comment', $edit_comment);

		return response()->json(['success' => true, 'value' => $view->render()]);

	}

	public function saveTaskComment(Request $request){
		if($request->task_id == null){
			return response()->json(['success' => false, 'error' => 'Task identity not provided']);
		}

		if($request->id == null){
			//New
			$comment = TaskComment::create($request->all());

		} else {
			//Edit
			$comment = TaskComment::find($request->id);
			$comment->body = $request->body;

		}

		$comment->user_id = Auth::user()->id;

		$comment->save();

		$view = view('tasks/widgets/comments')->with('task', Task::find($request->task_id));

		return response()->json(['success' => true, 'value' => $view->render()]);

	}

	public function getPeople(Request $request){
		if($request->task_id == null){
			return response()->json(['success' => false, 'error' => 'Task identity not provided']);
		}

		if($request->type == null || $request->type == ''){
			$type = 'widgets';
		} else {
			$type = $request->type;
		}

		$view = view('tasks/'.$type.'/assigned')->with('task', Task::find($request->task_id))
																				->with('users', User::all());

		return response()->json(['success' => true, 'value' => $view->render()]);
	}

	public function getAttachmentsView(Request $request){
		if($request->task_id == null){
			return response()->json(['success' => false, 'error' => 'Task identity not provided']);
		}

		if($request->view_mode == null || $request->view_mode == ''){
			$view_mode = 'view';
		} else {
			$view_mode = $request->view_mode;
		}

		$task = Task::find($request->task_id);

		if($task->attachments != null && $task->attachments()->count() > 0){
			$view = view('tasks/widgets/attachments_'.$view_mode)->with('task', $task);
			return response()->json(['success' => true, 'value' => $view->render()]);
		} else {
			return response()->json(['success' => true, 'value' => '']);
		}
	}

	public function getAttachmentsForm(Request $request){
		if($request->task_id == null){
			return response()->json(['success' => false, 'error' => 'Task identity not provided']);
		}

		if($request->view_mode == null || $request->view_mode == ''){
			$view_mode = 'view';
		} else {
			$view_mode = $request->view_mode;
		}

		$view = view('tasks/forms/attachments')->with('task_id', $request->task_id)
																						->with('view_mode', $view_mode);

		return response()->json(['success' => true, 'value' => $view->render()]);
	}

	public function getSubject(Request $request){
		if($request->task_id == null){
			return response()->json(['success' => false, 'error' => 'Task identity not provided']);
		}

		$view = view('tasks/forms/subject')->with('task', Task::find($request->task_id));

		return response()->json(['success' => true, 'value' => $view->render()]);
	}

	public function setTaskSubject(Request $request){
		if($request->id == null){
			return response()->json(['success' => false, 'error' => 'Task identity not provided']);
		}

		$task = Task::find($request->id);
		$task->subject = ($request->subject == null)?'':$request->subject;
		$task->save();

		return response()->json(['success' => true, 'value' => $request->subject]);
	}

	public function getDescription(Request $request){
		if($request->task_id == null){
			return response()->json(['success' => false, 'error' => 'Task identity not provided']);
		}

		if($request->type == null || $request->type == ''){
			$type = 'widgets';
		} else {
			$type = $request->type;
		}

		$view = view('tasks/'.$type.'/description')->with('task', Task::find($request->task_id));

		return response()->json(['success' => true, 'value' => $view->render()]);
	}

	public function setTaskDescription(Request $request){
		if($request->task_id == null){
			return response()->json(['success' => false, 'error' => 'Task identity not provided']);
		}

		$task = Task::find($request->task_id);

		$task->description = ($request->description == null)?'':$request->description;
		$task->save();

		$view = view('tasks/widgets/description')->with('task', $task);

		return response()->json(['success' => true, 'value' => $view->render()]);
	}

	public function getEstimates(Request $request){
		if($request->task_id == null){
			return response()->json(['success' => false, 'error' => 'Task identity not provided']);
		}

		if($request->type == null || $request->type == ''){
			$type = 'widgets';
		} else {
			$type = $request->type;
		}

		$view = view('tasks/'.$type.'/estimates')->with('task', Task::find($request->task_id));

		return response()->json(['success' => true, 'value' => $view->render()]);
	}

	public function setTaskEstimates(Request $request){
		if($request->task_id == null){
			return response()->json(['success' => false, 'error' => 'Task identity not provided']);
		}

		$task = Task::find($request->task_id);

		$task->estimates = ($request->estimates == null)?0:StringToTimeSeconds($request->estimates);
		$task->save();

		$view = view('tasks/widgets/estimates')->with('task', $task);

		return response()->json(['success' => true, 'value' => $view->render()]);
	}

	public function getDetails(Request $request){
		if($request->task_id == null){
			return response()->json(['success' => false, 'error' => 'Task identity not provided']);
		}

		if($request->type == null || $request->type == ''){
			$type = 'widgets';
		} else {
			$type = $request->type;
		}

		$view = view('tasks/'.$type.'/details')->with('task', Task::find($request->task_id))
																					 ->with('task_statuses', TaskStatus::all())
																					 ->with('epics', Epic::all())
 																					 ->with('task_types', TaskType::all())
																					 ->with('priorities', Priority::all());

		return response()->json(['success' => true, 'value' => $view->render()]);
	}

	public function moveTaskToBacklog(Request $request){
		if($request->task_id == null){
			return response()->json(['success' => false, 'error' => 'Task identity not provided']);
		}

		$task = Task::find($request->task_id);
		$task->sprint_id = -1;
		$task->save();

		return response()->json(['success' => true, 'value' => '']);

	}

	public function getTaskSprintStatus(Request $request){
		if($request->task_id == null){
			return response()->json(['success' => false, 'error' => 'Task identity not provided']);
		}

		$task = Task::find($request->task_id);

		if($task == null){
			return response()->json(['success' => false, 'error' => 'Task not found']);
		}

		if($task->sprint != null){
			return response()->json(['success' => true, 'value' => $task->sprint->status->id]);
		}

		return response()->json(['success' => true, 'value' => '']);
	}

	public function saveDetails(Request $request){
		if($request->task_id == null){
			return response()->json(['success' => false, 'error' => 'Task identity not provided']);
		}

		$task = Task::find($request->task_id);
		$task->status_id = ($request->status_id == null)?1:$request->status_id;
		$task->epic_id = ($request->epic_id == null)?-1:$request->epic_id;
		$task->task_type_id = ($request->task_type_id == null)?1:$request->task_type_id;
		$task->priority_id = ($request->priority_id == null)?4:$request->priority_id;
		$task->save();

		$view = view('tasks/widgets/details')->with('task', $task);

		return response()->json(['success' => true, 'value' => $view->render()]);
	}

	public function setTaskStatus(Request $request){
		if($request->task_id == null){
			return response()->json(['success' => false, 'error' => 'Task identity not provided']);
		}

		$task = Task::find($request->task_id);
		$task->status_id = ($request->status_id == null)?1:$request->status_id;
		$task->save();

		$view = view('tasks/widgets/details')->with('task', $task);

		return response()->json(['success' => true, 'value' => $view->render()]);
	}

	public function deleteAttachment(Request $request){
		if($request->task_id == null){
			return response()->json(['success' => false, 'error' => 'Task identity not provided']);
		}

		if($request->file_id == null){
			return response()->json(['success' => false, 'error' => 'File identity not provided']);
		}

		if($request->view_mode == null || $request->view_mode == ''){
			$view_mode = 'view';
		} else {
			$view_mode = $request->view_mode;
		}

		$file = TaskAttachment::find($request->file_id);

		if(Storage::disk('local')->exists('/attachments/'.$file->stored_filename)){
			Storage::disk('local')->delete('/attachments/'.$file->stored_filename);
		}

		$file->delete();

		$task = Task::find($request->task_id);
		if($task->attachments != null && $task->attachments()->count() > 0){
			$view = view('tasks/widgets/attachments_'.$view_mode)->with('task', $task);
			return response()->json(['success' => true, 'value' => $view->render()]);
		} else {
			return response()->json(['success' => true, 'value' => '']);
		}

	}

	public function saveAttachment(Request $request){
		if($request->task_id == null){
			return response()->json(['success' => false, 'error' => 'Task identity not provided']);
		}

		if($request->view_mode == null || $request->view_mode == ''){
			$view_mode = 'view';
		} else {
			$view_mode = $request->view_mode;
		}

		$task = Task::find($request->task_id);

		if ($request->hasFile('attachment') && $request->file('attachment')->isValid() ) {
			$file = $request->file('attachment');

			if(isset($file)){
				$attachment = new TaskAttachment;
				$attachment->task_id = $task->id;
				$attachment->user_id = Auth::user()->id;
				$attachment->filename = '';
				$attachment->stored_filename = '';
				$attachment->size = $request->file('attachment')->getSize();
				$attachment->save();

				$filename = $request->file('attachment')->getClientOriginalName();
				$file_extension = GetFileExtension($filename);
				$stored_filename = $task->project->code.'-'.$task->id.'-'.$attachment->id.'.'.$file_extension;

				Storage::disk('local')->put('/attachments/'.$stored_filename,  File::get($file));

				$attachment->filename = $filename;
				$attachment->stored_filename = $stored_filename;
				$attachment->save();

				if($task->attachments != null && $task->attachments()->count() > 0){
					$view = view('tasks/widgets/attachments_'.$view_mode)->with('task', $task);
					return response()->json(['success' => true, 'value' => $view->render()]);
				} else {
					return response()->json(['success' => true, 'value' => '']);
				}

			} else {
				return response()->json(['success' => false, 'error' => 'No valid file provided.']);

			}
		}


	}

	public function saveTask(Request $request){
		$task = Task::create($request->all());

		$task->estimates = ($request->estimates == '')?0:StringToTimeSeconds($request->estimates);
		$task->created_by = Auth::user()->id;
		$task->save();

		//Saving and eventual attachment
		$error = '';
		if ($request->hasFile('attachment') && $request->file('attachment')->isValid() ) {
			$file = $request->file('attachment');

			if(isset($file)){
				$attachment = new TaskAttachment;
				$attachment->task_id = $task->id;
				$attachment->user_id = Auth::user()->id;
				$attachment->filename = '';
				$attachment->stored_filename = '';
				$attachment->size = $request->file('attachment')->getSize();
				$attachment->save();

				$filename = $request->file('attachment')->getClientOriginalName();
				$file_extension = GetFileExtension($filename);
				$stored_filename = $task->project->code.'-'.$task->id.'-'.$attachment->id.'.'.$file_extension;

				Storage::disk('local')->put('/attachments/'.$stored_filename,  File::get($file));

				$attachment->filename = $filename;
				$attachment->stored_filename = $stored_filename;
				$attachment->save();

			} else {
				$error = 'No valid file provided.';

			}
		}

		if($request->parent_task_id != null && $request->parent_task_id > 0){
			return redirect('task/'.$request->parent_task_id)->with('error', $error);
		} else {
			return redirect('project/'.$request->project_id)->with('error', $error);
		}

	}

	public function saveLog(Request $request){
		if($request->task_id == null){
			return response()->json(['success' => false, 'error' => 'Task identity not provided']);
		}

		if($request->id == null){
			//As it is a new one I need to prevent log for same user in the same day
			$tasklog = TaskLog::where('user_id', '=', Auth::user()->id)
												->where('log_date', '>=', $request->log_date.' 00:00:00')
												->where('log_date', '<=', $request->log_date.' 23:59:59')
												->where('task_id', '=', $request->task_id)->get();

			if($tasklog != null && $tasklog->count() > 0){
				return response()->json(['success' => false, 'error' => "You have already logged hours for this task.\nPlease edit the already entered log instead."]);
			}

			$log = TaskLog::create($request->all());
			$log->user_id = Auth::user()->id;

		} else {
			//edit
			$log = TaskLog::find($request->id);
			$log->log_date = $request->log_date;
			$log->log_description = $request->log_description;

		}

		$log->time_logged = ($request->time_logged == '')?0:StringToTimeSeconds($request->time_logged);
		$log->save();

		$view = view('tasks/widgets/logs')->with('task', Task::find($request->task_id));

		return response()->json(['success' => true, 'value' => $view->render()]);
	}

	public function assignToMe(Request $request){
		if($request->task_id == null){
			return response()->json(['success' => false, 'error' => 'Task identity not provided']);
		}

		$task = Task::find($request->task_id);
		$task->owned_by = Auth::user()->id;
		$task->save();

		$view = view('tasks/widgets/assigned')->with('task', $task);

		return response()->json(['success' => true, 'value' => $view->render()]);
	}

	public function assignToUser(Request $request){
		if($request->task_id == null){
			return response()->json(['success' => false, 'error' => 'Task identity not provided']);
		}

		$task = Task::find($request->task_id);
		$task->owned_by = ($request->owned_by == null)?-1:$request->owned_by;
		$task->save();

		$view = view('tasks/widgets/assigned')->with('task', $task);

		return response()->json(['success' => true, 'value' => $view->render()]);
	}

	public function removeLog(Request $request){
		if($request->task_id == null){
			return response()->json(['success' => false, 'error' => 'Task identity not provided']);
		}

		if($request->log_id == null){
			return response()->json(['success' => false, 'error' => 'Work Log identity not provided']);
		}

		$log = TaskLog::find($request->log_id);
		$log->delete();

		$view = view('tasks/widgets/logs')->with('task', Task::find($request->task_id));

		return response()->json(['success' => true, 'value' => $view->render()]);
	}

	public function getLog(Request $request){
		if($request->task_id == null){
			return response()->json(['success' => false, 'error' => 'Task identity not provided']);
		}

		$work_log = null;
		if($request->log_id != null){
			$work_log = TaskLog::find($request->log_id);
		}

		$task = Task::find($request->task_id);

		$view = view('tasks/forms/work_log')->with('edit_log', $work_log)
																			 ->with('task', $task);

		return response()->json(['success' => true, 'value' => $view->render()]);
	}

	public function viewTask($id){
		$task = Task::find($id);

		return view('tasks/page')->with('task', $task)
														 ->with('project', $task->project)
														 ->with('header', 'nav.tasks.tasks_header')
														 ->with('task_types', TaskType::all())
														 ->with('task_statuses', TaskStatus::all())
														 ->with('priorities', Priority::all())
														 ->with('epics', Epic::all())
														 ->with('users', User::orderBy('name')->get())
														 ->with('header_no_buttons', true);

	}

}
