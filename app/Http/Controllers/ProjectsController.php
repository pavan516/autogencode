<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use App\Project;
use App\Database;
use App\Table;
use App\Attribute;
use App\Feature;

class ProjectsController extends Controller
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
     * INFO : This method is called when we click on projects icon.
     * 
     * Return list of projects of a user.
     * 
     */
    public function index()
    {
        $user = Auth::user();
        $projects =  Project::where('user_uuid', $user->uuid)->orderBy('id', 'DESC')->get();
        return view('projects')->with('projects', $projects);
    }

    /**
     * NOTE : This method is called on adding a new project.
     * 
     * Create a new project with unique code.
     *
     * @param  $request
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'project_name' => 'required',
            'programming_language' => 'required',
            'framework' => 'required',
            'local_protocol' => 'required',
            'local_domain_name' => 'required',
            'server_protocol' => 'required',
            'server_domain_name' => 'required'
        ]);

        # Get auth user
        $user = Auth::user();

        # Generate 6 letters key
        $key = mt_rand(100000, 999999);
        # Replace empty space when capital letter is found
        $replaceName = preg_replace('/\B([A-Z])/', '_$1', $request->input('project_name'));
        # Make capital letter after space
        $nameCapital = ucwords($replaceName);
        # Replace empty with '_'
        $name = str_replace(' ', '_', $nameCapital);

        # Create Post
        $project = new Project;
        $project->uuid = (string) Str::uuid();
        $project->user_uuid = $user->uuid;        
        $project->project_code = strtolower($name.'_'.$key);
        $project->project_name = $request->input('project_name');
        $project->programming_language = $request->input('programming_language');
        $project->framework = $request->input('framework');
        $project->local_protocol = $request->input('local_protocol');
        $project->local_portno = $request->input('local_portno');
        $project->local_domain_name = $request->input('local_domain_name');
        $project->server_protocol = $request->input('server_protocol');
        $project->server_portno = $request->input('server_portno');
        $project->server_domain_name = $request->input('server_domain_name');
        $project->status = 0;
        $project->api_token = str_random(60);
        $project->save();

        $user = Auth::user();
        $projects =  Project::where('user_uuid', $user->uuid)->orderBy('id', 'DESC')->get();
        
        return redirect('projects')->with('projects', $projects);
    }

    /**
     * NOTE : This method is called when user click on delete project.
     * 
     * Remove the specified project from database based on uuid.
     * TODO: Need to test.
     *
     * @param  string  $project_uuid
     */
    public function destroy($project_uuid)
    {
        # Delete features        
        $features =  Feature::where('project_uuid',$project_uuid)->delete();
        # Delete database credentials
        $database =  Database::where('project_uuid',$project_uuid)->delete();
        # Fetch all tables
        $tables = Table::where('project_uuid',$project_uuid)->get();
        foreach($tables as $table) {
            # Delete attributes based on table uuid
            $attributes = Attribute::where('table_uuid',$table['uuid'])->delete();
        }
        # Delete tables
        $deleteTables = Table::where('project_uuid',$project_uuid)->delete();
        # Finally delete project
        $project =  Project::where('uuid',$project_uuid)->delete();

        return redirect('projects');
    }
}
