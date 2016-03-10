<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sprint extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sprints';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'from_date', 'to_date', 'project_id', 'sprint_status_id'];

    public function project(){
      return $this->belongsTo('App\Project', 'project_id', 'id');
    }

    public function status(){
        return $this->belongsTo('App\SprintStatus', 'sprint_status_id', 'id');
    }

    public function tasks(){
        return $this->hasMany('App\Task');
    }

}
