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

class FeaturesController extends Controller
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
	 * INFO : This method is called when view project is clicked.
	 *
	 * @param   $project_uuid   Project UUID
	 *
	 * @return  features page   with respective project & feature details
	 */
	public function index($project_uuid)
	{
		# Fetch single project
		$project = (new Project())->arrayToJson($project_uuid);

		###
		##	FOR LANGUAGE : NODE JS (not required to show any features list)
		##	SUPPORTED FRAMEWORKS: EXPRESS_JS_MYSQL
		###
		if($project->programming_language === "NODE_JS") {
			# Create Default Tables & Attributes
			$this->createDefTabAtt($project->uuid);
			# redirect to database page - skip features
			return redirect('/databases/'.$project->uuid);
		}

		###
		##	FOR LANGUAGE : PHP  (we require to show the list of features)
		##  SUPPORTED FRAMEWORKS: CODEIGNITER
		###
		if($project->programming_language === "PHP")
		{
			# Fetch features for this project
			$features = (new Feature())->where('project_uuid', $project_uuid)->get();

			# If project framewor is codeigniter - go to codeigniter features view
			if($project->framework === "CODEIGNITER") {
				return view('features.codeigniter')->with('project', $project)->with('features', $features);
			}
		}

		# Bydefault redirect to home page
		return redirect()->route('projects');
	}

	/**
	 * NOTE : This method is called on adding a features to a project.
	 * Add features to a project
	 *
	 * @param  $request
	 */
	public function create(Request $request)
	{
		# validation
		$this->validate($request, [
			'project_uuid' => 'required',
			'features' => "required|array|min:8"
		]);

		# Delete existing features with this project
		$delete = (new Feature())->deleteFeatures($request->input('project_uuid'));
		if($delete) {
			# Foreach request body
			foreach($request->input('features') as $item)
			{
				# Create Features Object
				$feature = new Feature;

				# Create default tables when authentication is yes
				if($item['code'] === "AUTHENTICATION"  && $item['enable'] === "YES") {
					# Create Default Tables & Attributes
					$this->createDefTabAtt($request->input('project_uuid'));
				} else if($item['code'] === "AUTHENTICATION"  && $item['enable'] === "NO") {
					# Delete Default Tables & Attributes
					$this->deleteDefTabAtt($request->input('project_uuid'));
				}

				# Create Body
				$feature->uuid = (string) Str::uuid();
				$feature->project_uuid = $request->input('project_uuid');
				$feature->feature_code = $item['code'];
				$feature->enable = $item['enable'];
				$feature->status = 1;
				$feature->api_token = str_random(60);
				$feature->save();
			}
		}

		# Return to database
		return redirect('/databases/'.$request->input('project_uuid'));
	}

	/**
	 * NOTE : This method is called while creating features - when authentication is YES.
	 * Create Default Tables & Attributes
	 * Step 1 : Create default table - users
	 *
	 * @param  string   $project_uuid
	 *
	 * @return boolean  TRUE / FALSE
	 */
	public function createDefTabAtt(string $project_uuid)
	{
		# Check whether this project as same table code.
		$tableCheck = (new Table())->isExist($project_uuid, "users");

		# If there are no table exist for this project it returns true
		if($tableCheck) {
			# Create table object
			$tableObj = new Table;
			# Create Table Body
			$tableObj->uuid = (string) Str::uuid();
			$tableObj->project_uuid = $project_uuid;
			$tableObj->table_name = "Users";
			$tableObj->table_code = "users";
			$tableObj->status = 1;
			$tableObj->api_token = str_random(60);
			$tableObj->save();
		}

		# Get all tables for this project
		$getTables = (new Table())->where('project_uuid', $project_uuid)->get();

		# Create attributes for each table
		foreach($getTables as $getTable) {
			# Check for table code
			## If table code is users
			if($getTable['table_code'] === "users")
			{
				# Create body for users
				$attributes[0]['attribute_name'] = "id";
				$attributes[0]['attribute_code'] = "id";
				$attributes[0]['attribute_datatype'] = "INT";
				$attributes[0]['attribute_length'] = "11";
				$attributes[0]['attribute_default']['key'] = "NONE";
				$attributes[0]['attribute_attributes'] = "";
				$attributes[0]['attribute_index'] = "PRIMARY";
				$attributes[0]['attribute_autoincrement'] = "1";
				$attributes[0]['attribute_inputtype']['key'] = "HIDE";

				$attributes[1]['attribute_name'] = "uuid";
				$attributes[1]['attribute_code'] = "uuid";
				$attributes[1]['attribute_datatype'] = "VARCHAR";
				$attributes[1]['attribute_length'] = "48";
				$attributes[1]['attribute_default']['key'] = "NONE";
				$attributes[1]['attribute_attributes'] = "";
				$attributes[1]['attribute_index'] = "";
				$attributes[1]['attribute_inputtype']['key'] = "REFERENCE_KEY_UUID";

				$attributes[2]['attribute_name'] = "private_uuid";
				$attributes[2]['attribute_code'] = "private_uuid";
				$attributes[2]['attribute_datatype'] = "VARCHAR";
				$attributes[2]['attribute_length'] = "48";
				$attributes[2]['attribute_default']['key'] = "NONE";
				$attributes[2]['attribute_attributes'] = "";
				$attributes[2]['attribute_index'] = "";
				$attributes[2]['attribute_inputtype']['key'] = "HIDE";

				$attributes[3]['attribute_name'] = "user_name";
				$attributes[3]['attribute_code'] = "user_name";
				$attributes[3]['attribute_datatype'] = "VARCHAR";
				$attributes[3]['attribute_length'] = "255";
				$attributes[3]['attribute_default']['key'] = "NONE";
				$attributes[3]['attribute_attributes'] = "";
				$attributes[3]['attribute_index'] = "UNIQUE";
				$attributes[3]['attribute_inputtype']['key'] = "";

				$attributes[4]['attribute_name'] = "user_email";
				$attributes[4]['attribute_code'] = "user_email";
				$attributes[4]['attribute_datatype'] = "VARCHAR";
				$attributes[4]['attribute_length'] = "100";
				$attributes[4]['attribute_default']['key'] = "NONE";
				$attributes[4]['attribute_attributes'] = "";
				$attributes[4]['attribute_index'] = "UNIQUE";
				$attributes[4]['attribute_inputtype']['key'] = "";

				$attributes[5]['attribute_name'] = "user_mobile";
				$attributes[5]['attribute_code'] = "user_mobile";
				$attributes[5]['attribute_datatype'] = "VARCHAR";
				$attributes[5]['attribute_length'] = "128";
				$attributes[5]['attribute_default']['key'] = "NONE";
				$attributes[5]['attribute_attributes'] = "";
				$attributes[5]['attribute_index'] = "UNIQUE";
				$attributes[5]['attribute_inputtype']['key'] = "";

				$attributes[6]['attribute_name'] = "pw_seed";
				$attributes[6]['attribute_code'] = "pw_seed";
				$attributes[6]['attribute_datatype'] = "VARCHAR";
				$attributes[6]['attribute_length'] = "128";
				$attributes[6]['attribute_default']['key'] = "NONE";
				$attributes[6]['attribute_attributes'] = "";
				$attributes[6]['attribute_index'] = "";
				$attributes[6]['attribute_inputtype']['key'] = "HIDE";

				$attributes[7]['attribute_name'] = "pw_hash";
				$attributes[7]['attribute_code'] = "pw_hash";
				$attributes[7]['attribute_datatype'] = "VARCHAR";
				$attributes[7]['attribute_length'] = "128";
				$attributes[7]['attribute_default']['key'] = "NONE";
				$attributes[7]['attribute_attributes'] = "";
				$attributes[7]['attribute_index'] = "";
				$attributes[7]['attribute_inputtype']['key'] = "HIDE";

				$attributes[8]['attribute_name'] = "pw_algo";
				$attributes[8]['attribute_code'] = "pw_algo";
				$attributes[8]['attribute_datatype'] = "VARCHAR";
				$attributes[8]['attribute_length'] = "16";
				$attributes[8]['attribute_default']['key'] = "NONE";
				$attributes[8]['attribute_attributes'] = "";
				$attributes[8]['attribute_index'] = "";
				$attributes[8]['attribute_inputtype']['key'] = "HIDE";

				$attributes[9]['attribute_name'] = "created_dt";
				$attributes[9]['attribute_code'] = "created_dt";
				$attributes[9]['attribute_datatype'] = "DATETIME";
				$attributes[9]['attribute_length'] = "";
				$attributes[9]['attribute_default']['key'] = "NONE";
				$attributes[9]['attribute_attributes'] = "";
				$attributes[9]['attribute_index'] = "";
				$attributes[9]['attribute_inputtype']['key'] = "CURRENT_DATETIME";

				$attributes[10]['attribute_name'] = "modified_dt";
				$attributes[10]['attribute_code'] = "modified_dt";
				$attributes[10]['attribute_datatype'] = "DATETIME";
				$attributes[10]['attribute_length'] = "";
				$attributes[10]['attribute_default']['key'] = "NONE";
				$attributes[10]['attribute_attributes'] = "";
				$attributes[10]['attribute_index'] = "";
				$attributes[10]['attribute_inputtype']['key'] = "CURRENT_DATETIME";

				# delete attributes
				$delete = (new Attribute())->deleteAttributes($getTable['uuid']);
				if($delete) {
					# Foreach all attributes
					foreach($attributes as $item)
					{
						# Create Attribute object
						$attribute = new Attribute;

						# Create attributes body
						$attribute->uuid = (string) Str::uuid();
						$attribute->table_uuid = $getTable['uuid'];
						$attribute->attribute_name = $item['attribute_name'];
						$attribute->attribute_code = $item['attribute_name'];
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
				}
			}
		}

		# assume all okay
		return TRUE;
	}

	/**
	 * NOTE : This method is called while creating features - when authentication is NO.
	 * Delete Default Tables & Attributes
	 * Step 1 : Get default table - users & delete it only if there are no attributes.
	 * Step 2 : Get default attribues - of users table & delete it.
	 *
	 * @param  string   $project_uuid
	 *
	 * @return boolean  TRUE / FALSE
	 */
	public function deleteDefTabAtt(string $project_uuid)
	{
		# Get users table for this project
		$usersTable = [];
		$usersTables = (new Table())->where('project_uuid', $project_uuid)->where('table_code', "users")->get();
		if(count($usersTables)>0) {
			foreach($usersTables as $usersTable) {
				$usersTable = $usersTable;
			}
		}

		# Delete attributes if exist
		if(!empty($usersTable)) {
			# Delete id
			Attribute::where('table_uuid',$usersTable['uuid'])->where('attribute_code','id')->delete();
			# Delete uuid
			Attribute::where('table_uuid',$usersTable['uuid'])->where('attribute_code','uuid')->delete();
			# Delete private_uuid
			Attribute::where('table_uuid',$usersTable['uuid'])->where('attribute_code','private_uuid')->delete();
			# Delete user_name
			Attribute::where('table_uuid',$usersTable['uuid'])->where('attribute_code','user_name')->delete();
			# Delete user_email
			Attribute::where('table_uuid',$usersTable['uuid'])->where('attribute_code','user_email')->delete();
			# Delete user_mobile
			Attribute::where('table_uuid',$usersTable['uuid'])->where('attribute_code','user_mobile')->delete();
			# Delete pw_seed
			Attribute::where('table_uuid',$usersTable['uuid'])->where('attribute_code','pw_seed')->delete();
			# Delete pw_hash
			Attribute::where('table_uuid',$usersTable['uuid'])->where('attribute_code','pw_hash')->delete();
			# Delete pw_algo
			Attribute::where('table_uuid',$usersTable['uuid'])->where('attribute_code','pw_algo')->delete();
			# Delete created_date
			Attribute::where('table_uuid',$usersTable['uuid'])->where('attribute_code','created_date')->delete();
			# Delete modified_dt
			Attribute::where('table_uuid',$usersTable['uuid'])->where('attribute_code','modified_dt')->delete();

			# Get attributes for this table
			$attributes = Attribute::where('table_uuid',$usersTable['uuid'])->get();

			# Delete table - users if there are no attributes
			if(count($attributes) == 0) {
				Table::where('uuid',$usersTable['uuid'])->delete();
			}
		}

		# assume all okay
		return TRUE;
	}

}
