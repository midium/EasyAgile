<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Epic extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'epics';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'project_id', 'color'];


    public function project()
    {
        return $this->hasOne('App\Project', 'id', 'project_id');
    }

}
