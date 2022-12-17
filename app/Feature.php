<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Feature extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'user_uuid', 'project_uuid', 'feature_name', 'feature_code', 'enable', 'status','api_token'
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
     * Fetch all tables of a given "Database".
     *
     * @param  varchar  $database_uuid - database uuid
     */
    public function fetchTables($database_uuid)
    {
        $tables = Table::where('database_uuid', $database_uuid)->get();
        return $tables;
    }

    /**
     * 
     * @param  varchar  $database_uuid - database uuid
     * @param  varchar  $table_name - Table name
     * 
     * => Return true if record exist.
     * => Return false when no records found.
     */
    public function isExist($database_uuid,$table_code)
    {
        $table =  Table::where('database_uuid', $database_uuid)->where('table_code', $table_code)->get();
        if(count($table)>0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete all features for a given project uuid.
     *
     * @param  string  $project_uuid - Project UUID.
     */
    public function deleteFeatures($project_uuid)
    {
        $data = Feature::where('project_uuid', $project_uuid)->get();
        if(count($data)>0) {
            $features = Feature::where('project_uuid', $project_uuid)->delete();
            if($features) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return TRUE;
        }
        
    }

}
