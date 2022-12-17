<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Table extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'project_uuid', 'table_name', 'table_code', 'status','api_token'
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
     * @param  varchar  $project_uuid - project uuid
     * @param  varchar  $table_name - Table name
     * 
     * => Return false if record exist.
     * => Return true when no record found.
     */
    public function isExist($project_uuid, $table_code)
    {
        $table =  Table::where('project_uuid', $project_uuid)->where('table_code', $table_code)->get();
        if(count($table)>0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
