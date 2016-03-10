<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'use_gravatar', 'theme'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function privileges(){
        return $this->belongsTo('App\Privilege', 'privilege_id', 'id');
    }

    public function role(){
        return $this->hasOne('App\Role', 'id', 'role_id');
    }

    public function teams(){
        return $this->belongsToMany('App\Team', 'teams_users');
    }

    public function task_logs(){
      return $this->hasMany('App\TaskLog');
    }

    public function owned_tasks(){
      return $this->hasMany('App\Task', 'owned_by', 'id');
    }

    public function created_tasks(){
      return $this->hasMany('App\Task', 'id', 'created_by');
    }

    public function getUserNotClosedTasks(){
      return $this->owned_tasks()->whereNotIn('status_id', array('3','5','7','8','10','11'));
    }

    public function getAvatarURI(){
      if($this->use_gravatar){
        return 'http://gravatar.com/avatar/'.md5( $this->email );
      } else {
        return asset( 'storage/app/users_avatars/'.$this->id.'.png' );
      }
    }

    public function getYearMonthLogs($year, $month){

      return $this->task_logs()->where('log_date', '>=', $year.'-'.$month.'-01 00:00:00')
                               ->where('log_date', '<=', $year.'-'.$month.'-31 23:59:59')
                               ->join('tasks', 'tasks_logs.task_id', '=', 'tasks.id')
                               ->join('projects', 'tasks.project_id', '=', 'projects.id')
                               ->orderBy('projects.id')->distinct()->get();

    }

    public function getYearMonthLoggedTasks($year, $month){

      return Task::select(DB::raw('tasks.*'))
                 ->join('tasks_logs', 'tasks_logs.task_id', '=', 'tasks.id')
                 ->join('projects', 'tasks.project_id', '=', 'projects.id')
                 ->where('tasks_logs.user_id', '=', $this->id)
                 ->where('tasks_logs.log_date', '>=', $year.'-'.$month.'-01 00:00:00')
                 ->where('tasks_logs.log_date', '<=', $year.'-'.$month.'-31 23:59:59')
                 ->orderBy('projects.id')->orderBy('tasks.parent_task_id')->orderBy('tasks.id')->distinct()->get();

    }

}
