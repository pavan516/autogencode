<?php

# Namespace
namespace App\Http\Controllers;

# Utilities
use Illuminate\Http\Request;
use Illuminate\Support\Str;

# Models
use App\Project;
use App\Table;
use App\Attribute;
use App\Feature;

/**
 * Tables Controller
 */
class TablesController extends Controller
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
   * NOTE : This method is called after saving database credentials.
   * Step 1 : Get project info based on project uuid.
   * Step 3 : Get list of tables & attributes based on project uuid.
   *
   * @args    string  $project_uuid - Project uuid
   *
   * @return  tables view     tables & attributes.
   */
  public function index($project_uuid)
  {
    # Fetch single project
    $project = (new Project())->arrayToJson($project_uuid);

    # For NODE-JS project, its not required to fetch features
    if($project->programming_language != "NODE_JS") {
      # Get Features for this project
      $features = (new Feature())->where('project_uuid', $project_uuid)->where('feature_code', "AUTHENTICATION")->get();
      foreach($features as $feature) $feature = $feature;
    }

    # Fetch single database for this project (single project will have only single database)
    $tables = (new Table())->where('project_uuid', $project_uuid)->get();

    # Fetch attributes for tables.
    $attributes = (new Attribute())->fetchAttributes($tables);

    # Features list not required for NODE-JS
    if($project->programming_language === "NODE_JS") {
      return view('tables')->with('project',$project)->with('tables', $tables)->with('attributes', $attributes);
    }

    # by default return features list too
    return view('tables')->with('project',$project)->with('tables', $tables)->with('attributes', $attributes)->with('feature', $feature);
  }

  /**
   * NOTE : This method is called when user click on add tables for a project.
   *
   * Step 1 : Adding database name in database table.
   *          -> 1 project should have 1 database.
   *          -> Step1 : Check whether project with same database exist or not.
   *          -> Step2 : If not-exist create.
   *          -> Step3 : Get inserted data.
   * Step 2 : Adding table names in Tables Table.
   *          -> Table name must be unique.
   * Step 3 : Get project info based on project uuid.
   * Step 4 : Get database info based on database uuid.
   * Step 5 : Get list of tables & attributes based on database uuid.
   *
   * @return Tables view - when there is a database.
   * @return project view - when there is no database exist to that project.
   *
   * @param  $request
   */
  public function create(Request $request)
  {
    # validate
    $this->validate($request, [
      'project_uuid' => 'required', 'string', 'max:255',
      'table_name' => "required|array|min:1",
      "table_name.*"  => "required|string"
    ]);

    # Insert each table in foreach
    foreach($request->input('table_name') as $tableName)
    {
      # Replace empty space before the letter, when capital letter is found
      $replaceTableName = preg_replace('/\B([A-Z])/', '_$1', $tableName);
      # Replace empty with '_'
      $code = strtolower(str_replace(' ', '_', $replaceTableName));

      # Check whether project as same table name.
      $tableCheck = (new Table())->isExist($request->input('project_uuid'), $code);
      # It returns true if there are no records found - else false
      if( ($tableCheck) &&  ($tableName!== "users") ) {
          # Create table object
          $table = new Table;
          # Create Tables body
          $table->uuid = (string) Str::uuid();
          $table->project_uuid = $request->input('project_uuid');
          $table->table_name = $tableName;
          $table->table_code = $code;
          $table->status = 1;
          $table->api_token = str_random(60);
          $table->save();
      }
    }

    # Return to tables controller index method
    return (new TablesController())->index($request->input('project_uuid'));
  }

  /**
   * NOTE : This method is a specific method which is called by ajax while creating attributes.
   * => Just show list of tables.
   *
   * @param   string  $project_uuid - Project uuid
   * @param   string  $tableUuid - Table uuid
   * @param   string  $count - count number - index value.
   *
   * @return  getTables view.
   */
  public function getTables($project_uuid, $tableUuid, $count)
  {
    # Fetch tables
    $tables = Table::where('project_uuid', $project_uuid)->get();

    # return to get tables list view
    return view('getTables')->with('tables', $tables)->with('tableUuid',$tableUuid)->with('count',$count);
  }

}
