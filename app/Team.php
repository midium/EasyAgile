<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'teams';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

    public function projects(){
        return $this->belongsToMany('App\Project', 'projects_teams');
    }

    public function users(){
      return $this->belongsToMany('App\User', 'teams_users');
    }

}
