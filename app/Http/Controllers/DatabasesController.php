<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use App\Project;
use App\Database;
use App\Table;
use App\Attribute;

class DatabasesController extends Controller
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
     * NOTE : This method is called after adding features on NEXT button.
     * 
     * Input : $project_uuid
     * 
     * Step 1 : Get databse info based on project_uuid.
     * Step 2 : Get project info based on project_uuid.
     * 
     * @return 'database' view page
     * 
     */
    public function index($project_uuid)
    {
        # Fetch single project
        $project = (new Project())->arrayToJson($project_uuid);
        
        # Fetch single database for this project (single project will have only single database)
        $database = (new Database())->arrayToJson($project->uuid);
        
        return view('database')->with('database', $database)->with('project', $project);
    }

    /**
     * NOTE : This method is called to update database info
     * 
     * Update database table with more info.
     *
     * @return 'features' view page
     * 
     * @param  $request
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'project_uuid' => 'required',
            'database_host' => 'required',
            'database_port' => 'required',
            'database_name' => 'required',
            'database_user_name' => 'required'
        ]);

        # Delete record if exist with this project
        $delete = (new Database())->deleteDatabase($request->input('project_uuid'));
        if($delete) {

            # Replace empty space before the letter, when capital letter is found
            $replaceDbName = preg_replace('/\B([A-Z])/', '_$1', $request->input('database_name'));
            # Replace empty with '_'
            $DbName = str_replace(' ', '_', $replaceDbName);

            # Create body
            $database = new Database;
            $database->uuid = (string) Str::uuid();
            $database->project_uuid = $request->input('project_uuid');            
            $database->database_code = strtolower($DbName);
            $database->database_connection = "mysql";
            $database->database_host = $request->input('database_host');
            $database->database_port = $request->input('database_port');
            $database->database_name = $request->input('database_name');
            $database->database_user_name = $request->input('database_user_name');
            $database->database_password = $request->input('database_password');
            $database->status = 1;
            $database->api_token = str_random(60);
            $database->save();
        }
         
        # Return to tables
        return redirect('/tables/'.$request->input('project_uuid'));
    }
    
}
