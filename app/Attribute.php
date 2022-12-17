<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Attribute extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'table_uuid', 'attribute_name', 'attribute_code', 'attribute_datatype', 'attribute_length', 'attribute_default', 'attribute_attributes', 'attribute_null', 'attribute_index', 'attribute_autoincrement', 'attribute_inputtype', 'api_token'
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
     * Fetch all attributes for a given array of tables.
     *
     * @param  varchar  $tables - array of tables.
     */
    public function fetchAttributes($tables)
    {
        foreach($tables as $table) {
            $attributes = Attribute::where('table_uuid', $table->uuid)->get();
            $data[$table->uuid] = $attributes;
        }

        return $data ?? '';
    }

    /**
     * Fetch all attributes for a given array of tables.
     *
     * @param  varchar  $tables - array of tables.
     */
    public function deleteAttributes($table_uuid)
    {
        $data = Attribute::where('table_uuid', $table_uuid)->get();
        if(count($data)>0) {
            $attributes = Attribute::where('table_uuid', $table_uuid)->delete();
            if($attributes) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return TRUE;
        }
        
    }
}
