<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Project extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'user_uuid', 'project_name', 'project_code', 'status', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
    ];

    /**
     * Convert array to json object.
     *
     * @param  varchar  $uuid
     */
    public function arrayToJson($uuid)
    {
        $projects =  Project::where('uuid',$uuid)->get();
        foreach($projects as $project) {
            $project = $project; 
        }

        return $project;
    }
}
