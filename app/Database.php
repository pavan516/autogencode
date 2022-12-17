<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Database extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'user_uuid', 'project_uuid', 'database_connection', 'database_host', 'database_port', 'database_name', 'database_code', 'database_user_name', 'database_password', 'status', 'api_token'
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
     * @param  varchar  $project_uuid - project uuid
     */
    public function arrayToJson($project_uuid)
    {
        $databases = Database::where('project_uuid', $project_uuid)->get();
        foreach($databases as $database) { 
            $database = $database;
        }

        return $database ?? '';
    }

    /**
     * 
     * @param  int  $id - inserted id
     * 
     * => Return data.
     */
    public function fetchRecord($id)
    {
        $data = Database::find($id);
        return $data;
    }

    /**
     * Delete database record for a given project uuid if exist.
     *
     * @param  string  $project_uuid - Project UUID.
     */
    public function deleteDatabase($project_uuid)
    {
        $data = Database::where('project_uuid', $project_uuid)->get();
        if(count($data)>0) {
            $database = Database::where('project_uuid', $project_uuid)->delete();
            if($database) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return TRUE;
        }
        
    }

}
