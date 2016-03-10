<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskLog extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tasks_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['task_id', 'user_id', 'time_logged', 'log_description', 'log_date'];

    public function task(){
      return $this->belongsTo('App\Task', 'task_id', 'id');
    }

    public function user(){
      return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function getLoggedTime(){
      return SecondsToTimeString($this->time_logged);
    }

}
