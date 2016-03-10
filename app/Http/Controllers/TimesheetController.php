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
use Excel;
use App\User;
use App\Project;
use App\Task;
use App\TaskLog;

class TimesheetController extends Controller
{

	public function timesheetPage()
	{
		return view('timesheet/page')->with('user', Auth::user())
          												->with('header', 'nav.timesheet.header')
                                  ->with('header_no_buttons', true)
																	->with('year', date('Y'))
																	->with('month', date('m'));
	}

	public function timesheetChangeMonth(Request $request)
	{

		if($request->uid == null || $request->uid == ''){
			return response()->json(['success' => false, 'error' => 'User identity not provided']);
		}

		if($request->year == null || $request->year == ''){
			return response()->json(['success' => false, 'error' => 'Reference year not provided']);
		}

		if($request->month == null || $request->month == ''){
			return response()->json(['success' => false, 'error' => 'Reference month not provided']);
		}

		if($request->direction == null || $request->direction == ''){
			return response()->json(['success' => false, 'error' => 'Direction of navigation is missing']);
		}

		$original_date = strtotime($request->year.'-'.$request->month.'-01');

		if(strtolower($request->direction) == 'next'){
			$next_year = date('Y', strtotime("+1 months", $original_date));
			$next_month = date('m', strtotime("+1 months", $original_date));
		} else {
			$next_year = date('Y', strtotime("-1 months", $original_date));
			$next_month = date('m', strtotime("-1 months", $original_date));
		}

		$view = view('timesheet/table')->with('user', User::find($request->uid))
          												->with('header', 'nav.timesheet.header')
                                  ->with('header_no_buttons', true)
																	->with('year', $next_year)
																	->with('month', $next_month);

		$navigator = view('nav/timesheet/navigator')->with('year', $next_year)
																								->with('month', $next_month);

		$export = view('nav/timesheet/export')->with('year', $next_year)
																					->with('month', $next_month);

		return response()->json(['success' => true, 'value' => $view->render(),
																								'nav' => $navigator->render(),
																								'export' => $export->render()]);

	}

	public function timesheetGetLog(Request $request){
		if($request->task_id == null){
			return response()->json(['success' => false, 'error' => 'Task identity not provided']);
		}

		$work_log = null;
		if($request->log_id != null){
			$work_log = TaskLog::find($request->log_id);
		}

		$task = Task::find($request->task_id);

		$view = view('timesheet/forms/work_log')->with('edit_log', $work_log)
																			  ->with('task', $task)
																				->with('date', $request->date)
																				->with('year', $request->year)
																				->with('month', $request->month);

		return response()->json(['success' => true, 'value' => $view->render()]);
	}

	public function timesheetSaveLog(Request $request){
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

		//I reload the timesheet table
		$next_year = $request->year;
		$next_month = $request->month;

		$view = view('timesheet/table')->with('user', Auth::user())
          												->with('header', 'nav.timesheet.header')
                                  ->with('header_no_buttons', true)
																	->with('year', $next_year)
																	->with('month', $next_month);

		$navigator = view('nav/timesheet/navigator')->with('year', $next_year)
																								->with('month', $next_month);

		$export = view('nav/timesheet/export')->with('year', $next_year)
																					->with('month', $next_month);

		return response()->json(['success' => true, 'value' => $view->render(),
																								'nav' => $navigator->render(),
																								'export' => $export->render()]);

	}

	public function timesheetExport(Request $request){

		$filename = Auth::user()->name.'-'.$request->year.'-'.$request->month.'_timesheet';

		Excel::create($filename, function($excel) use ($request) {
		    $excel->sheet('Timesheet', function($sheet) use ($request) {
		        $sheet->loadView('timesheet/table')->with('user', Auth::user())
																					->with('year', $request->year)
																					->with('month', $request->month)
																					->with('is_export', true);
		    });
		})->download('xlsx');

	}
}
