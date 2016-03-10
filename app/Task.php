<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['created_by', 'owned_by', 'project_id', 'priority_id', 'status_id',
                           'task_type_id', 'epic_id', 'sprint_id', 'subject', 'description',
                           'estimates', 'parent_task_id', 'order_number'];

    public function isCompleted(){
      if($this->status_id == 3 || $this->status_id == 5 || $this->status_id == 7 ||
        $this->status_id == 8 || $this->status_id == 10 || $this->status_id == 11){
        return true;
      }

      return false;
    }

    public function getRemainingTime(){
      $estimates = $this->getTotalEstimatedTime();
      $logged = $this->getTotalLoggedTime();

      if($estimates <= $logged){
        return 0;
      } else {
        return $estimates - $logged;
      }

    }

    public function getThisTaskRemainingTime(){
      $estimates = $this->estimates;
      $logged = $this->getTotalLoggedTime();

      if($estimates <= $logged){
        return 0;
      } else {
        return $estimates - $logged;
      }

    }

    public function getThisTaskLoggedTime(){
      $total_log = 0;

      if($this->task_logs()->count()>0){
        foreach($this->task_logs as $log){
          $total_log = $total_log + $log->time_logged;
        }
      }

      return $total_log;
    }

    public function getThisTaskLoggedTimeForUser($user_id){
      $total_log = 0;

      if($this->task_logs()->where('user_id', '=', $user_id)->count()>0){
        foreach($this->task_logs()->where('user_id', '=', $user_id)->get() as $log){
          $total_log = $total_log + $log->time_logged;
        }
      }

      return $total_log;
    }

    public function getThisTaskLoggedTimeForUserOnYearMonth($user_id, $year, $month){
      $total_log = 0;

      if($this->task_logs()->where('user_id', '=', $user_id)
                           ->where('log_date', '>=', $year.'-'.$month.'-01 00:00:00')
                           ->where('log_date', '<=', $year.'-'.$month.'-31 23:59:59')->count()>0){

        foreach($this->task_logs()->where('user_id', '=', $user_id)
                                  ->where('log_date', '>=', $year.'-'.$month.'-01 00:00:00')
                                  ->where('log_date', '<=', $year.'-'.$month.'-31 23:59:59')->get() as $log){
          $total_log = $total_log + $log->time_logged;
        }
      }

      return $total_log;
    }

    public function getThisTaskLoggedTimeOnDateForUser($date, $user_id){
      $total_log = 0;

      if($this->task_logs()->where('user_id', '=', $user_id)->count()>0){

        foreach ($this->task_logs()->where('user_id', '=', $user_id)->where('log_date', '>=', $date.' 00:00:00')->where('log_date', '<=', $date.' 23:59:59')->get() as $log) {
          $total_log = $total_log + $log->time_logged;
        }
      }

      return $total_log;
    }

    public function getThisTaskLoggedIdOnDateForUser($date, $user_id){
      $id = '';

      if($this->task_logs()->where('user_id', '=', $user_id)->where('task_id', '=', $this->id)->count()>0){

        foreach ($this->task_logs()->where('user_id', '=', $user_id)->where('task_id', '=', $this->id)->where('log_date', '>=', $date.' 00:00:00')->where('log_date', '<=', $date.' 23:59:59')->get() as $log) {
          $id = $log->id;
        }
      }

      return $id;
    }

    public function getThisTaskLoggedTimeOnDate($date){
      $total_log = 0;

      if($this->task_logs()->count()>0){

        foreach ($this->task_logs()->where('log_date', '>=', $date.' 00:00:00')->where('log_date', '<=', $date.' 23:59:59')->get() as $log) {
          $total_log = $total_log + $log->time_logged;
        }
      }

      return $total_log;
    }

    public function getTotalLoggedTime(){
      $total_log = 0;

      if($this->task_logs()->count()>0){
        foreach($this->task_logs as $log){
          $total_log = $total_log + $log->time_logged;
        }
      }

      if($this->sub_tasks->count()>0){
        foreach($this->sub_tasks as $task){
          $total_log = $total_log + $task->getThisTaskLoggedTime();
        }
      }

      return $total_log;
    }

    public function getTotalEstimatedTime(){
      $total_estimates = $this->estimates;

      if($this->sub_tasks->count()>0){
        foreach($this->sub_tasks as $task){
          $total_estimates = $total_estimates + $task->estimates;
        }
      }

      return $total_estimates;
    }

    public function hasUserLogs($user_id)
    {
      return $this->task_logs()->where('user_id', '=', $user_id)->count() > 0;
    }

    public function hasUserLogsOnYearMonth($user_id, $year, $month)
    {
      return $this->task_logs()->where('user_id', '=', $user_id)
                               ->where('log_date', '>=', $year.'-'.$month.'-01 00:00:00')
                               ->where('log_date', '<=', $year.'-'.$month.'-31 23:59:59')->count() > 0;
    }

    public function getCode(){
      return $this->project->code.'-'.$this->id;
    }

    public function getEstimatedTime(){
      return SecondsToTimeString($this->estimates);
    }

    public function parent_task(){
      return $this->belongsTo('App\Task', 'parent_task_id', 'id');
    }

    public function sub_tasks(){
      return $this->hasMany('App\Task', 'parent_task_id', 'id');
    }

    public function task_logs(){
      return $this->hasMany('App\TaskLog');
    }

    public function task_comments(){
      return $this->hasMany('App\TaskComment');
    }

    public function creator(){
      return $this->belongsTo('App\User', 'created_by', 'id');
    }

    public function owner(){
      return $this->belongsTo('App\User', 'owned_by', 'id');
    }

    public function epic()
    {
        return $this->belongsTo('App\Epic', 'epic_id', 'id');
    }

    public function attachments()
    {
        return $this->hasMany('App\TaskAttachment');
    }

    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id', 'id');
    }

    public function sprint()
    {
        return $this->belongsTo('App\Sprint', 'sprint_id', 'id');
    }

    public function task_type()
    {
      return $this->belongsTo('App\TaskType', 'task_type_id', 'id');
    }

    public function task_status()
    {
      return $this->belongsTo('App\TaskStatus', 'status_id', 'id');
    }

    public function priority()
    {
      return $this->belongsTo('App\Priority', 'priority_id', 'id');
    }

}
