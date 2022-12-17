<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use App\Project;
use App\Table;
use App\Database;
use App\Attribute;

class AttributesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * NOTE : Its a Ajax Call
     * NOTE : This method is used to add attributes for a table
     * 
     * Step 1 : It deletes all attributes for that table.
     * Step 2 : Insert all attributes for that table.
     *
     * @param  $request
     * 
     * @return generate view page
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'table_uuid' => 'required', 'string', 'max:255',
            'attributes' => "required|array|min:1"
        ]);

        # Delete existing attributes based on table uuid
        $delete = (new Attribute())->deleteAttributes($request->input('table_uuid'));
        if($delete) {
            # Foreach all table names
            foreach($request->input('attributes') as $item) {
                # Remove spaces, capital letters & replace with '_'
                $name = strtolower(str_replace(' ', '_', preg_replace('/\B([A-Z])/', '_$1', $item['attribute_name'])));
                
                # Create Attribute object
                $attribute = new Attribute;

                # Create attributes body
                $attribute->uuid = (string) Str::uuid();
                $attribute->table_uuid = $request->input('table_uuid');
                $attribute->attribute_name = $item['attribute_name'];
                $attribute->attribute_code = $name;
                $attribute->attribute_datatype = $item['attribute_datatype'];
                $attribute->attribute_length = $item['attribute_length'];
                $attribute->attribute_default = json_encode($item['attribute_default']);
                $attribute->attribute_attributes = $item['attribute_attributes'];
                if(array_key_exists("attribute_null",$item)) {
                    $attribute->attribute_null = $item['attribute_null'];
                } else {
                    $attribute->attribute_null = 0;
                }                
                $attribute->attribute_index = $item['attribute_index'];
                if(array_key_exists("attribute_autoincrement",$item)) {
                    $attribute->attribute_autoincrement = $item['attribute_autoincrement'];
                } else {
                    $attribute->attribute_autoincrement = 0;
                }
                $attribute->attribute_inputtype = json_encode($item['attribute_inputtype']);
                $attribute->api_token = str_random(60);
                $attribute->save();
            }
        } else {
            return response("Failed To Update!");
        }
                
        return response("Successfully Saved!");
    }
    
}
