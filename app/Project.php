<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Project extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'projects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'code', 'description', 'manager_id', 'icon', 'status_id'];

    public function getCurrentSprint()
    {
      return $this->sprints()->where('sprint_status_id', 1)->first();
    }

    public function getTotalOpenTasks(){
      return $this->tasks()->whereIn('status_id', array(1,2,4,6,9))->count();
    }

    public function getTotalClosedTasks(){
      return $this->tasks()->whereIn('status_id', array(3,5,7,8,10,11))->count();
    }

    public function getTotalLoggedTimeOnDate($date){
      $total_log = 0;

      if($this->tasks()->count()>0){
        foreach ($this->tasks()->get() as $task) {
          foreach ($task->task_logs()->where('log_date', '>=', $date.' 00:00:00')->where('log_date', '<=', $date.' 23:59:59')->get() as $log) {
            $total_log = $total_log + $log->time_logged;
          }
        }
      }

      return $total_log;
    }

    public function getTotalLoggedTimeOnDateForUser($date, $user_id){
      $total_log = 0;

      if($this->tasks()->count()>0){
        foreach ($this->tasks()->get() as $task) {
          foreach ($task->task_logs()->where('user_id', '=', $user_id)->where('log_date', '>=', $date.' 00:00:00')->where('log_date', '<=', $date.' 23:59:59')->get() as $log) {
            $total_log = $total_log + $log->time_logged;
          }
        }
      }

      return $total_log;
    }

    public function getTotalLoggedTimeForUser($user_id){
      $total_log = 0;

      if($this->tasks()->count()>0){

        foreach ($this->tasks()->get() as $task) {
          $total_log = $total_log + $task->getThisTaskLoggedTimeForUser($user_id);

          if($task->sub_tasks()->count()>0){
            foreach($task->sub_tasks() as $stask){
              $total_log = $total_log + $stask->getThisTaskLoggedTimeForUser($user_id);
            }
          }
        }
      }

      return $total_log;
    }

    public function getTotalLoggedTimeForUserOnYearMonth($user_id, $year, $month){
      $total_log = 0;

      if($this->tasks()->count()>0){

        foreach ($this->tasks()->get() as $task) {
          $total_log = $total_log + $task->getThisTaskLoggedTimeForUserOnYearMonth($user_id, $year, $month);

          if($task->sub_tasks()->count()>0){
            foreach($task->sub_tasks() as $stask){
              $total_log = $total_log + $stask->getThisTaskLoggedTimeForUserOnYearMonth($user_id, $year, $month);
            }
          }
        }
      }

      return $total_log;
    }

    public function getTotalLoggedTime(){
      $total_log = 0;

      if($this->tasks()->count()>0){

        foreach ($this->tasks()->get() as $task) {
          $total_log = $total_log + $task->getThisTaskLoggedTime();

          if($task->sub_tasks()->count()>0){
            foreach($task->sub_tasks() as $stask){
              $total_log = $total_log + $stask->getThisTaskLoggedTime();
            }
          }
        }
      }

      return $total_log;
    }

    public function hasUserLogs($user_id)
    {
      if($this->tasks()->count()>0){
        foreach ($this->tasks()->get() as $task) {
          if($task->hasUserLogs($user_id)){
            return true;
          }
        }
      }
      return false;
    }

    public function hasUserLogsOnYearMonth($user_id, $year, $month)
    {
      if($this->tasks()->count()>0){
        foreach ($this->tasks()->get() as $task) {
          if($task->hasUserLogsOnYearMonth($user_id, $year, $month)){
            return true;
          }
        }
      }
      return false;
    }

    public function getProjectIcon()
    {
      if(Storage::disk('local')->exists('/projects_icons/'.$this->id.'.png')){
        return asset('/storage/app/projects_icons/'.$this->id.'.png');
      } else {
        return asset('/storage/app/projects_icons/default.png');
      }
    }

    public function getBacklogTasks()
    {
      return $this->tasks()->whereNotIn('sprint_id', $this->sprints()->lists('id'))
                           ->where('parent_task_id', '=', 0)
                           ->orderByRaw('-order_number desc')->get();
    }

    public function sprints()
    {
      return $this->hasMany('App\Sprint', 'project_id', 'id');
    }

    public function manager()
    {
        return $this->hasOne('App\User', 'id', 'manager_id');
    }

    public function status(){
        return $this->belongsTo('App\ProjectStatus', 'status_id', 'id');
    }

    public function tasks(){
        return $this->hasMany('App\Task', 'project_id', 'id');
    }

    public function epics(){
        return $this->hasMany('App\Epic', 'project_id', 'id');
    }

    public function teams(){
        return $this->belongsToMany('App\Team', 'projects_teams');
    }

}
