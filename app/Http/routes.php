<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Models
Route::model('project', 'App\Project');

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

Route::group(['middleware' => 'auth'], function () {
	Route::get('/', function () {
	    return view('home');
	});

	Route::get('home', function(){
		return view('home');
	});

	//Account related routes
	Route::get('account', 'AccountController@accountPage');
	Route::post('account/upload_avatar', 'AccountController@uploadAvatar');
	Route::post('account/use_gravatar', 'AccountController@accountUseGravatar');
	Route::post('account/update_password', 'AccountController@accountUpdatePassword');
	Route::post('account/update_username', 'AccountController@accountUpdateUsername');
	Route::post('account/update_email', 'AccountController@accountUpdateEmail');
	Route::post('account/update_user_theme', 'AccountController@accountUpdateUserTheme');

	//Project related routes
	Route::get('projects/create', 'ProjectController@createProjectView');
	Route::get('projects', 'ProjectController@allProjectsView');
	Route::post('project/save', 'ProjectController@saveProject');
	Route::post('project/update', 'ProjectController@saveProject');
	Route::get('project/{id}', 'ProjectController@projectPage');
	Route::get('project/{id}/settings', 'ProjectController@projectSettingsPage');
	Route::post('project/get_epic', 'ProjectController@projectGetEpic');
	Route::post('project/save_epic', 'ProjectController@projectSaveEpic');
	Route::post('project/remove_epic', 'ProjectController@projectRemoveEpic');
	Route::post('project/add_team', 'ProjectController@projectAddTeam');
	Route::post('project/remove_team', 'ProjectController@projectRemoveTeam');
	Route::post('project/get_team', 'ProjectController@getTeam');
	Route::post('project/create_team', 'ProjectController@createTeam');
	Route::post('project/get_sprint', 'ProjectController@getSprintForm');
	Route::post('project/delete_sprint', 'ProjectController@deleteSprint');
	Route::post('project/save_sprint', 'ProjectController@saveSprint');
	Route::post('project/task_to_sprint', 'ProjectController@moveTaskToSprint');
	Route::post('project/sort_tasks', 'ProjectController@sortBacklogTasks');
	Route::post('project/change_sprint_status', 'ProjectController@changeSprintStatus');
	Route::post('project/check_sprint_open_tasks', 'ProjectController@checkSprintOpenTasks');
	Route::post('project/move_sprint_open_tasks_to_backlog', 'ProjectController@moveOpenTasksToBacklog');
	Route::post('projects/filter', 'ProjectController@filterProjects');
	Route::get('project/{id}/{sprint_id}', 'ProjectController@projectPage');

	//Tasks related routes
	Route::get('tasks/create', 'TaskController@createTaskView');
	Route::get('tasks/create/{id}', 'TaskController@createProjectTaskView');
	Route::get('tasks/create/{pid}/{tid}', 'TaskController@createSubTaskView');
	Route::get('tasks', 'TaskController@viewAllTasks');
	Route::post('task/save', 'TaskController@saveTask');
	Route::get('task/{id}', 'TaskController@viewTask');
	Route::post('task/get_log', 'TaskController@getLog');
	Route::post('task/save_log', 'TaskController@saveLog');
	Route::post('task/remove_log', 'TaskController@removeLog');
	Route::post('task/assign_to_me', 'TaskController@assignToMe');
	Route::post('task/assign_to_user', 'TaskController@assignToUser');
	Route::post('task/get_people', 'TaskController@getPeople');
	Route::post('task/get_details', 'TaskController@getDetails');
	Route::post('task/update_details', 'TaskController@saveDetails');
	Route::post('task/set_status', 'TaskController@setTaskStatus');
	Route::post('task/get_estimates', 'TaskController@getEstimates');
	Route::post('task/set_estimates', 'TaskController@setTaskEstimates');
	Route::post('task/get_description', 'TaskController@getDescription');
	Route::post('task/set_description', 'TaskController@setTaskDescription');
	Route::post('task/get_subject', 'TaskController@getSubject');
	Route::post('task/set_subject', 'TaskController@setTaskSubject');
	Route::post('task/get_attachments_view', 'TaskController@getAttachmentsView');
	Route::post('task/get_attachments_form', 'TaskController@getAttachmentsForm');
	Route::post('task/delete_attachment', 'TaskController@deleteAttachment');
	Route::post('task/save_attachment', 'TaskController@saveAttachment');
	Route::post('task/get_comment', 'TaskController@getComment');
	Route::post('task/save_comment', 'TaskController@saveTaskComment');
	Route::get('task/convert_to_normal/{id}/{pid}', 'TaskController@convertSubtaskToNormal');
	Route::post('tasks/filter', 'TaskController@filterTasks');
	Route::post('tasks/quick_search', 'TaskController@quickSearchTask');
	Route::post('task/get_task_sprint_status', 'TaskController@getTaskSprintStatus');
	Route::post('task/move_task_to_backlog', 'TaskController@moveTaskToBacklog');

	//Easy Agile Setup
	Route::get('setup', 'EasyAgileController@setupPage');
	Route::post('setup/save_role', 'EasyAgileController@setupSaveRole');
	Route::post('setup/delete_role', 'EasyAgileController@setupDeleteRole');
	Route::post('setup/get_role', 'EasyAgileController@getRole');
	Route::post('setup/get_user_credentials', 'EasyAgileController@getUserCredentials');
	Route::post('setup/save_user_credentials', 'EasyAgileController@saveUserCredentials');
	Route::post('setup/remove_user', 'EasyAgileController@setupRemoveUser');
	Route::post('setup/get_project', 'EasyAgileController@getProject');
	Route::post('setup/save_project', 'EasyAgileController@setupSaveProject');
	Route::post('setup/delete_project', 'EasyAgileController@setupDeleteProject');
	Route::post('setup/get_team', 'EasyAgileController@getTeam');
	Route::post('setup/team_save', 'EasyAgileController@setupSaveTeam');
	Route::post('setup/remove_team', 'EasyAgileController@setupDeleteTeam');

	//Timesheet
	Route::get('timesheet', 'TimesheetController@timesheetPage');
	Route::post('timesheet/change_month', 'TimesheetController@timesheetChangeMonth');
	Route::post('timesheet/get_log', 'TimesheetController@timesheetGetLog');
	Route::post('timesheet/save_log', 'TimesheetController@timesheetSaveLog');
	Route::post('timesheet/export', 'TimesheetController@timesheetExport');
});

// Display all SQL executed in Eloquent
Event::listen('illuminate.query', function($query)
{
	if(Config::get('app.debug_queries')){
    var_dump($query);
	}
});
