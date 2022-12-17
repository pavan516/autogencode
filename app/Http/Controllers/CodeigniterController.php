<?php

# Namespace
namespace App\Http\Controllers;

# Controllers
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use File;
use Auth;
use App\Project;
use App\Database;
use App\Table;
use App\Attribute;

/**
 * Codeigniter Controller
 */
class CodeigniterController extends Controller
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




















/* *************************************************************************************************************** */
/*  ###  Modify Config File ###                                                                                    */
/* *************************************************************************************************************** */

    /**
     * NOTE : Modify Config File (Change Base Url Of The Project)
     *
     * @param   string $configFilePath  - Config File Path
     * @param   string $localDomainUrl  - Local Domain Url
     * @param   string $serverDomainUrl - Server Domain Url
     * 
     * @return  Boolean     True/False
     */
    public function modifyConfigFile($configFilePath, $localDomainUrl, $serverDomainUrl)
    {
        # Initialize string
        $str = "";
        $str .= "$";
        $str .= "config";
        $str .= "['";
        $str .= "base_url";
        $str .= "'] = '";
        $str .= $localDomainUrl;
        $str .= "';".PHP_EOL;
        $str .= "// $";
        $str .= "config";
        $str .= "['";
        $str .= "base_url";
        $str .= "'] = '";
        $str .= $serverDomainUrl;
        $str .= "';".PHP_EOL;

        # Reads an array of lines
        $data = file($configFilePath);
        foreach($data as $item) {
            $temp[] = $str;
        }
        
        # map & replace content
        $data = array_map(function($data,$str) {
                    if(stristr($data,'base_url')) return $str; else return $data;
                }, $data, $temp);
        
        # Apply modified changes to the file
        $modify = file_put_contents($configFilePath, implode('', $data));
        if(!$modify) {
            return false;
        }
        
        return true;
    }




















/* *************************************************************************************************************** */
/*  ###  Generate Database File  ###                                                                               */
/* *************************************************************************************************************** */

    /**
     * NOTE : Generate Database File (Update File With Database Credentials)
     *
     * @param   JSON-OBJECT  $database - Database Info
     * 
     * @return  string with file content
     */
    public function createDatabaseFile($database)
    {
        # Initialize variable
        $var = "$";
        $var1 = '"';

        # Initialize String
        $str = "";
        $str .= "<?php".PHP_EOL;
        $str .= "defined('BASEPATH') OR exit('No direct script access allowed');".PHP_EOL.PHP_EOL;
        $str .= "/*".PHP_EOL;
        $str .= "| -------------------------------------------------------------------".PHP_EOL;
        $str .= "| DATABASE CONNECTIVITY SETTINGS".PHP_EOL;
        $str .= "| -------------------------------------------------------------------".PHP_EOL;
        $str .= "| This file will contain the settings needed to access your database.".PHP_EOL;
        $str .= "|".PHP_EOL;
        $str .= "| For complete instructions please consult the 'Database Connection'".PHP_EOL;
        $str .= "| page of the User Guide.".PHP_EOL;
        $str .= "|".PHP_EOL;
        $str .= "| -------------------------------------------------------------------".PHP_EOL;
        $str .= "| EXPLANATION OF VARIABLES".PHP_EOL;
        $str .= "| -------------------------------------------------------------------".PHP_EOL;
        $str .= "|".PHP_EOL;
        $str .= "|	['dsn']      The full DSN string describe a connection to the database.".PHP_EOL;
        $str .= "|	['hostname'] The hostname of your database server.".PHP_EOL;
        $str .= "|	['username'] The username used to connect to the database".PHP_EOL;
        $str .= "|	['password'] The password used to connect to the database".PHP_EOL;
        $str .= "|	['database'] The name of the database you want to connect to".PHP_EOL;
        $str .= "|	['dbdriver'] The database driver. e.g.: mysqli.".PHP_EOL;
        $str .= "|			Currently supported:".PHP_EOL;
        $str .= "|				 cubrid, ibase, mssql, mysql, mysqli, oci8,".PHP_EOL;
        $str .= "|				 odbc, pdo, postgre, sqlite, sqlite3, sqlsrv".PHP_EOL;
        $str .= "|	['dbprefix'] You can add an optional prefix, which will be added".PHP_EOL;
        $str .= "|				 to the table name when using the  Query Builder class".PHP_EOL;
        $str .= "|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection".PHP_EOL;
        $str .= "|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.".PHP_EOL;
        $str .= "|	['cache_on'] TRUE/FALSE - Enables/disables query caching".PHP_EOL;
        $str .= "|	['cachedir'] The path to the folder where cache files should be stored".PHP_EOL;
        $str .= "|	['char_set'] The character set used in communicating with the database".PHP_EOL;
        $str .= "|	['dbcollat'] The character collation used in communicating with the database".PHP_EOL;
        $str .= "|				 NOTE: For MySQL and MySQLi databases, this setting is only used".PHP_EOL;
        $str .= "| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7".PHP_EOL;
        $str .= "|				 (and in table creation queries made with DB Forge).".PHP_EOL;
        $str .= "| 				 There is an incompatibility in PHP with mysql_real_escape_string() which".PHP_EOL;
        $str .= "| 				 can make your site vulnerable to SQL injection if you are using a".PHP_EOL;
        $str .= "| 				 multi-byte character set and are running versions lower than these.".PHP_EOL;
        $str .= "| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.".PHP_EOL;
        $str .= "|	['swap_pre'] A default table prefix that should be swapped with the dbprefix".PHP_EOL;
        $str .= "|	['encrypt']  Whether or not to use an encrypted connection.".PHP_EOL;
        $str .= "|".PHP_EOL;
        $str .= "|			'mysql' (deprecated), 'sqlsrv' and 'pdo/sqlsrv' drivers accept TRUE/FALSE".PHP_EOL;
        $str .= "|			'mysqli' and 'pdo/mysql' drivers accept an array with the following options:".PHP_EOL;
        $str .= "|".PHP_EOL;
        $str .= "|				'ssl_key'    - Path to the private key file".PHP_EOL;
        $str .= "|				'ssl_cert'   - Path to the public key certificate file".PHP_EOL;
        $str .= "|				'ssl_ca'     - Path to the certificate authority file".PHP_EOL;
        $str .= "|				'ssl_capath' - Path to a directory containing trusted CA certificates in PEM format".PHP_EOL;
        $str .= "|				'ssl_cipher' - List of *allowed* ciphers to be used for the encryption, separated by colons (':')".PHP_EOL;
        $str .= "|				'ssl_verify' - TRUE/FALSE; Whether verify the server certificate or not".PHP_EOL;
        $str .= "|".PHP_EOL;
        $str .= "|	['compress'] Whether or not to use client compression (MySQL only)".PHP_EOL;
        $str .= "|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections".PHP_EOL;
        $str .= "|							- good for ensuring strict SQL while developing".PHP_EOL;
        $str .= "|	['ssl_options']	Used to set various SSL options that can be used when making SSL connections.".PHP_EOL;
        $str .= "|	['failover'] array - A array with 0 or more data for connections if the main should fail.".PHP_EOL;
        $str .= "|	['save_queries'] TRUE/FALSE - Whether to ".$var1."save".$var1." all executed queries.".PHP_EOL;
        $str .= "| 				NOTE: Disabling this will also effectively disable both".PHP_EOL;
        $str .= "| 				".$var."this->db->last_query() and profiling of DB queries.".PHP_EOL;
        $str .= "| 				When you run a query, with this setting set to TRUE (default),".PHP_EOL;
        $str .= "| 				CodeIgniter will store the SQL statement for debugging purposes.".PHP_EOL;
        $str .= "| 				However, this may cause high memory usage, especially if you run".PHP_EOL;
        $str .= "| 				a lot of SQL queries ... disable this to avoid that problem.".PHP_EOL;
        $str .= "|".PHP_EOL;
        $str .= "| The ".$var."active_group variable lets you choose which connection group to".PHP_EOL;
        $str .= "| make active.  By default there is only one group (the 'default' group).".PHP_EOL;
        $str .= "|".PHP_EOL;
        $str .= "| The ".$var."query_builder variables lets you determine whether or not to load".PHP_EOL;
        $str .= "| the query builder class.".PHP_EOL;
        $str .= "*/".PHP_EOL;
        $str .= $var."active_group = 'default';".PHP_EOL;
        $str .= $var."query_builder = TRUE;".PHP_EOL.PHP_EOL;
        $str .= $var."db['default'] = array(".PHP_EOL;
        $str .= "	'dsn'	=> '',".PHP_EOL;
        $str .= "	'hostname' => '".$database->database_host."',".PHP_EOL;
        $str .= "	'username' => '".$database->database_user_name."',".PHP_EOL;
        $str .= "	'password' => '".$database->database_password."',".PHP_EOL;
        $str .= "	'database' => '".$database->database_code."',".PHP_EOL;
        $str .= "	'dbdriver' => 'mysqli',".PHP_EOL;
        $str .= "	'dbprefix' => '',".PHP_EOL;
        $str .= "	'pconnect' => FALSE,".PHP_EOL;
        $str .= "	'db_debug' => (ENVIRONMENT !== 'production'),".PHP_EOL;
        $str .= "	'cache_on' => FALSE,".PHP_EOL;
        $str .= "	'cachedir' => '',".PHP_EOL;
        $str .= "	'char_set' => 'utf8',".PHP_EOL;
        $str .= "	'dbcollat' => 'utf8_general_ci',".PHP_EOL;
        $str .= "	'swap_pre' => '',".PHP_EOL;
        $str .= "	'encrypt' => FALSE,".PHP_EOL;
        $str .= "	'compress' => FALSE,".PHP_EOL;
        $str .= "	'stricton' => FALSE,".PHP_EOL;
        $str .= "	'failover' => array(),".PHP_EOL;
        $str .= "	'save_queries' => TRUE".PHP_EOL;
        $str .= ");";
        
        return $str;        
    }

    




















/* *************************************************************************************************************** */
/*  ###  Create Controllers For Project  ###                                                                       */
/* *************************************************************************************************************** */

    /**
     * NOTE : Create Controllers For Project
     *
     * @param   array     $tables - All Tables
     * 
     * @param   string    $controllersPath - Controllers Path
     *  
     * @param   string    $authControllerDirectory - Auth Controllers Path
     * 
     * @param   object    $controllersFeature - Authentication Feature Data
     *  
     * @param   object    $authenticationFeature - Authentication Feature Data
     *  
     * @param   string    $projectName - Project Name
     *  
     * @return  true/false
     */
    public function createControllers($tables, $controllersDirectory, $authControllerDirectory, object $controllersFeature, object $authenticationFeature, $projectName)
    {
        # Initialise Variables
        $var = "$";
        $var1 = '"';

        # Create Controllers For Each Table
        foreach($tables as $table) 
        {
            # Initialise Strings
            $controller = "";
            
            # Table Name
            $tableName = $this->convertToTableName($table->table_code);

            # Class Name / File Name
            $className = $tableName.'Controller';
            $fileName = $tableName.'Controller.php';

            # Controller File Path
            $controllerFilePath = $controllersDirectory.DIRECTORY_SEPARATOR.$fileName;

            # Get Attributes For Particular Table
            $attributes = Attribute::where('table_uuid',$table->uuid)->get();

            # Get Foreign Keys
            $foreignKeys = $this->getForeignKeyAttributes($table);

            # Get Primary Key
            $primaryKey = $this->getPrimaryKey($table);

            # Get Reference Key
            $referenceKey = $this->getReferenceKey($table);

            # Get Input Attributes Filled By Users
            $userFilledAttributes = $this->userFilledAttributes($table);

            # Get Mandatory Fields
            $mandatoryAttributes = $this->getMandatoryAttributes($table);

            /* ********************* */
            /*    CONTROLLERS Task   */
            /* ********************* */

            if($table->table_code === "users") {
                # If Authentication feature is enabled
                if($authenticationFeature->enable === "YES") {
                    # Controller File Path
                    $authControllerFilePath = $authControllerDirectory.DIRECTORY_SEPARATOR.$fileName;

                    # Get User Table Attributes To Update
                    $userUpdateFilledAttributes = $this->userUpdateFilledAttributes($table);

                    # Open Php File
                    $controller .= "<?php".PHP_EOL;
                    $controller .= "/** ".PHP_EOL;
                    $controller .= " * ".$tableName."Controller.php".PHP_EOL;
                    $controller .= " *".PHP_EOL;
                    $controller .= " * Generated with AutoGenCode v1.0.0".PHP_EOL;
                    $controller .= " *".PHP_EOL;
                    $controller .= " * @author      Pavan Kumar".PHP_EOL;
                    $controller .= " * @contact     8520872771".PHP_EOL;
                    $controller .= " * @mailId      en.pavankumar@gmail.com".PHP_EOL;
                    $controller .= " *".PHP_EOL;
                    $controller .= " * @createdAt   ".date("Y-m-d h:i:s").PHP_EOL;
                    $controller .= " * @project     ".$projectName.PHP_EOL;
                    $controller .= " */".PHP_EOL;
                    $controller .= "#                                                                                                                 #".PHP_EOL;
                    $controller .= "##################################################################################################################".PHP_EOL;
                    $controller .= "#                                                                                                                  #".PHP_EOL.PHP_EOL;
                    $controller .= "".PHP_EOL;
                    $controller .= "# No direct script access allowed".PHP_EOL;
                    $controller .= "defined('BASEPATH') OR exit('No direct script access allowed');".PHP_EOL.PHP_EOL;
                    $controller .= "# This can be removed if you use __autoload() in config.php OR use Modular Extensions".PHP_EOL;
                    $controller .= "require APPPATH . 'libraries/REST_Controller.php';".PHP_EOL.PHP_EOL;
                    # Class Start
                    $controller .= "/**".PHP_EOL;
                    $controller .= " * ".$tableName." Controller".PHP_EOL;
                    $controller .= " */".PHP_EOL;
                    $controller .= "class ".$tableName."Controller extends REST_Controller".PHP_EOL;
                    $controller .= "{".PHP_EOL;
                    $controller .= "  # Construct the parent class".PHP_EOL;
                    $controller .= "  public function __construct() {".PHP_EOL;
                    $controller .= "    parent::__construct();".PHP_EOL;
                    $controller .= "    # Load model".PHP_EOL;
                    $controller .= "    ".$var."this->load->model('".$tableName."Model');".PHP_EOL;
                    $controller .= "    ".$var."this->load->model('LibraryModel');".PHP_EOL;
                    $controller .= "  }".PHP_EOL.PHP_EOL;
                    $controller .= "#                                                                                                                  #".PHP_EOL;
                    $controller .= "####################################################################################################################".PHP_EOL;
                    $controller .= "#                                                                                                                  #".PHP_EOL.PHP_EOL;
                    # Method 1 : Get Method - To Fetch All Users
                    $controller .= "  /**".PHP_EOL;
                    $controller .= "   * Method : GET".PHP_EOL;
                    $controller .= "   * Method Name : fetch".PHP_EOL;
                    $controller .= "   * Description : fetch all records based on params".PHP_EOL;
                    $controller .= "   * ".PHP_EOL;
                    $controller .= "   * @param   array List of params".PHP_EOL;
                    $controller .= "   * ".PHP_EOL;
                    $controller .= "   * NOTE : PAGINATION INFORMATION".PHP_EOL;
                    $controller .= "   * @param   string    limit - no of records to show".PHP_EOL;
                    $controller .= "   * @param   string    start - from where to show (starting point)".PHP_EOL;
                    $controller .= "   * ".PHP_EOL;
                    $controller .= "   * @return  array response".PHP_EOL;
                    $controller .= "   */".PHP_EOL;
                    $controller .= "  public function fetch_get()".PHP_EOL;
                    $controller .= "  {".PHP_EOL;
                    $controller .= "    # Header Check - Content-Type : Application / Json".PHP_EOL;
                    $controller .= "    if (!preg_match('/application\/json/i',(".$var."this->input->get_request_header('Content-Type') ?? ''))) {".PHP_EOL;
                    $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'Content-Type must be application-json'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
                    $controller .= "    }".PHP_EOL.PHP_EOL;
                    $controller .= "    # Get Authorization Key & Token".PHP_EOL;
                    $controller .= "    ".$var."authorization = ".$var."this->input->get_request_header('Authorization') ?? '';".PHP_EOL;
                    $controller .= "    if(empty(".$var."authorization)) {".PHP_EOL;
                    $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'data'=>'Authorization Token Is Missing'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
                    $controller .= "    }".PHP_EOL.PHP_EOL;  
                    $controller .= "    # Verify Authentication".PHP_EOL;
                    $controller .= "    ".$var."verify = (new LibraryModel())->verifyAuthentication(".$var."authorization);".PHP_EOL;
                    $controller .= "    if(isset(".$var."verify['error'])) { // Code - 2 Indicates Authentication Failed".PHP_EOL;
                    $controller .= "      # BAD_REQUEST (400) being the HTTP response code".PHP_EOL;
                    $controller .= "      return ".$var."this->set_response(['status' => 'fail', 'code'=>'2', 'message'=>'Bad Request', 'data' => ".$var."verify['error']], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL; 
                    $controller .= "    }".PHP_EOL.PHP_EOL;
                    $controller .= "    # Get Params".PHP_EOL;
                    $controller .= "    ".$var."params = [".PHP_EOL;
                    if(!empty($referenceKey)) {
                        $controller .= "      '".$referenceKey->attribute_code."'=>".$var."this->get('".$referenceKey->attribute_code."') ?? '',".PHP_EOL;
                    } else {
                        if(!empty($primaryKey)) {
                            $controller .= "      '".$primaryKey->attribute_code."'=>".$var."this->get('".$primaryKey->attribute_code."') ?? '',".PHP_EOL;
                        }
                    }
                    $controller .= "      'limit'=>".$var."this->get('limit') ?? '',".PHP_EOL;
                    $controller .= "      'start'=>".$var."this->get('start') ?? ''".PHP_EOL;
                    $controller .= "    ];".PHP_EOL.PHP_EOL;
                    $controller .= "    # Send request to model - returns an array".PHP_EOL;
                    $controller .= "    ".$var."result=".$var."this->".$tableName."Model->fetch(".$var."params);".PHP_EOL.PHP_EOL;
                    $controller .= "    # Set error message if found".PHP_EOL;
                    $controller .= "    if(isset(".$var."result['error'])) {".PHP_EOL;
                    $controller .= "      # NOT_FOUND (404) being the HTTP response code".PHP_EOL;
                    $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Failed To Fetch Data!', 'data'=>".$var."result['message']], REST_Controller::HTTP_NOT_FOUND);".PHP_EOL;
                    $controller .= "    }".PHP_EOL.PHP_EOL;
                    $controller .= "    # Set (200) OK being the HTTP response code & return an array".PHP_EOL;
                    $controller .= "    ".$var."this->set_response(['status'=>'success', 'code'=>'1', 'message'=>'Successfully Fetched Records!', 'data'=>".$var."result], REST_Controller::HTTP_OK);".PHP_EOL;
                    $controller .= "  }".PHP_EOL.PHP_EOL;
                    $controller .= "#                                                                                                                 #".PHP_EOL;
                    $controller .= "###################################################################################################################".PHP_EOL;
                    $controller .= "#                                                                                                                  #".PHP_EOL.PHP_EOL;
                    # Method 2 : Update Method
                    $controller .= "  /**".PHP_EOL;
                    $controller .= "   * Method : PUT".PHP_EOL;
                    $controller .= "   * Method Name : update".PHP_EOL;
                    $controller .= "   * Description : update a existing record".PHP_EOL;
                    $controller .= "   * ".PHP_EOL;
                    $controller .= "   * POST BODY : Json Body".PHP_EOL;
                    $controller .= "   * {".PHP_EOL;
                    if(!empty($userUpdateFilledAttributes)) {
                        foreach($userUpdateFilledAttributes as $userUpdateFilledAttribute) {
                            $controller .= '   *    "'.$userUpdateFilledAttribute->attribute_code.'":"",'.PHP_EOL;                        
                        }
                        $controller = substr($controller, 0, -3);                        
                    }
                    $controller .= PHP_EOL;
                    $controller .= "   * }".PHP_EOL;
                    $controller .= "   * ".PHP_EOL;
                    $controller .= "   * @return  array   response".PHP_EOL;
                    $controller .= "   */".PHP_EOL;
                    $controller .= "  public function update_put()".PHP_EOL;
                    $controller .= "  {".PHP_EOL;
                    $controller .= "    # Header Check - Content-Type : Application / Json".PHP_EOL;
                    $controller .= "    if (!preg_match('/application\/json/i',(".$var."this->input->get_request_header('Content-Type') ?? ''))) {".PHP_EOL;
                    $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'Content-Type must be application-json'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
                    $controller .= "    }".PHP_EOL.PHP_EOL;
                    $controller .= "    # Get Authorization Key & Token".PHP_EOL;
                    $controller .= "    ".$var."authorization = ".$var."this->input->get_request_header('Authorization') ?? '';".PHP_EOL;
                    $controller .= "    if(empty(".$var."authorization)) {".PHP_EOL;
                    $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'data'=>'Authorization Token Is Missing'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
                    $controller .= "    }".PHP_EOL.PHP_EOL;  
                    $controller .= "    # Verify Authentication".PHP_EOL;
                    $controller .= "    ".$var."verify = (new LibraryModel())->verifyAuthentication(".$var."authorization);".PHP_EOL;
                    $controller .= "    if(isset(".$var."verify['error'])) { // Code - 2 Indicates Authentication Failed".PHP_EOL;
                    $controller .= "      # BAD_REQUEST (400) being the HTTP response code".PHP_EOL;
                    $controller .= "      return ".$var."this->set_response(['status' => 'fail', 'code'=>'2', 'message'=>'Bad Request', 'data' => ".$var."verify['error']], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL; 
                    $controller .= "    }".PHP_EOL.PHP_EOL;
                    $controller .= "    # Get Auth User".PHP_EOL;
                    $controller .= "    ".$var."user = (new LibraryModel())->getAuthUser(".$var."authorization);".PHP_EOL;
                    $controller .= "    if(isset(".$var."user['error'])) { // Code - 3 Invalid Token".PHP_EOL;
                    $controller .= "      # BAD_REQUEST (400) being the HTTP response code".PHP_EOL;
                    $controller .= "      return ".$var."this->set_response(['status' => 'fail', 'code'=>'3', 'message'=>'Bad Request', 'data' => ".$var."user['error']], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
                    $controller .= "    }".PHP_EOL.PHP_EOL;
                    $controller .= "    # Decode payload to array - get post body".PHP_EOL;
                    $controller .= "    ".$var."input = (json_decode(file_get_contents('php://input'),true) ?? []);".PHP_EOL;
                    $controller .= "    if (empty(".$var."input)) {".PHP_EOL;
                    $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'data'=>'Invalid post body'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
                    $controller .= "    }".PHP_EOL.PHP_EOL;
                    $controller .= "    # Send request to model - returns an array".PHP_EOL;
                    $controller .= "    ".$var."result=".$var."this->".$tableName."Model->update(".$var."input, ".$var."user);".PHP_EOL.PHP_EOL;
                    $controller .= "    # Set error message if found".PHP_EOL;
                    $controller .= "    if(isset(".$var."result['error'])) {".PHP_EOL;
                    $controller .= "      # NOT_FOUND (404) being the HTTP response code".PHP_EOL;
                    $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>".$var1."Something Went Wrong!".$var1.", 'data'=>".$var."result['error']], REST_Controller::HTTP_NOT_FOUND);".PHP_EOL;
                    $controller .= "    }".PHP_EOL.PHP_EOL;
                    $controller .= "    # Set (200) OK being the HTTP response code & return an array".PHP_EOL;
                    $controller .= "    ".$var."this->set_response(['status'=>'success', 'code'=>'1', 'message'=>".$var1."Successfully Updated!".$var1.", 'data'=>".$var."result], REST_Controller::HTTP_CREATED);".PHP_EOL;
                    $controller .= "  }".PHP_EOL.PHP_EOL;
                    $controller .= "#                                                                                                                 #".PHP_EOL;
                    $controller .= "###################################################################################################################".PHP_EOL;
                    $controller .= "#                                                                                                                 #".PHP_EOL.PHP_EOL;
                    # Method 4 : Delete Method
                    $controller .= "  /**".PHP_EOL;
                    $controller .= "   * Method : DELETE".PHP_EOL;
                    $controller .= "   * Method Name : delete".PHP_EOL; 
                    $controller .= "   * Description : Delete a record".PHP_EOL; 
                    $controller .= "   * ".PHP_EOL;
                    $controller .= "   * @return  boolean response".PHP_EOL; 
                    $controller .= "   */".PHP_EOL; 
                    $controller .= "  public function delete_delete()".PHP_EOL;
                    $controller .= "  {".PHP_EOL; 
                    $controller .= "    # Validate HTTP Request 'Content-type'".PHP_EOL; 
                    $controller .= "    if (!preg_match('/application\/json/i',(".$var."this->input->get_request_header('Content-Type') ?? ''))) {".PHP_EOL; 
                    $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'Content-Type must be application-json'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL; 
                    $controller .= "    }".PHP_EOL.PHP_EOL;            
                    $controller .= "    # Get Authorization Key & Token".PHP_EOL;
                    $controller .= "    ".$var."authorization = ".$var."this->input->get_request_header('Authorization') ?? '';".PHP_EOL;
                    $controller .= "    if(empty(".$var."authorization)) {".PHP_EOL;
                    $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'data'=>'Authorization Token Is Missing'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
                    $controller .= "    }".PHP_EOL.PHP_EOL;  
                    $controller .= "    # Verify Authentication".PHP_EOL;
                    $controller .= "    ".$var."verify = (new LibraryModel())->verifyAuthentication(".$var."authorization);".PHP_EOL;
                    $controller .= "    if(isset(".$var."verify['error'])) { // Code - 2 Indicates Authentication Failed".PHP_EOL;
                    $controller .= "      # BAD_REQUEST (400) being the HTTP response code".PHP_EOL;
                    $controller .= "      return ".$var."this->set_response(['status' => 'fail', 'code'=>'2', 'message'=>'Bad Request', 'data' => ".$var."verify['error']], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL; 
                    $controller .= "    }".PHP_EOL.PHP_EOL;    
                    $controller .= "    # Get Auth User".PHP_EOL;
                    $controller .= "    ".$var."user = (new LibraryModel())->getAuthUser(".$var."authorization);".PHP_EOL;
                    $controller .= "    if(isset(".$var."user['error'])) { // Code - 3 Invalid Token".PHP_EOL;
                    $controller .= "      # BAD_REQUEST (400) being the HTTP response code".PHP_EOL;
                    $controller .= "      return ".$var."this->set_response(['status' => 'fail', 'code'=>'3', 'message'=>'Bad Request', 'data' => ".$var."user['error']], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
                    $controller .= "    }".PHP_EOL.PHP_EOL;        
                    $controller .= "    # Send request to model - returns a boolean (true/false)".PHP_EOL;
                    $controller .= "    ".$var."result = ".$var."this->".$tableName."Model->delete(".$var."user);".PHP_EOL.PHP_EOL;
                    $controller .= "    # Set error message if found".PHP_EOL;
                    $controller .= "    if(!".$var."result) {".PHP_EOL;
                    $controller .= "      # NOT_FOUND (404) being the HTTP response code".PHP_EOL;
                    $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>".$var1."Something Went Wrong!".$var1.", 'data'=>".$var1."Failed To Delete Record!".$var1."], REST_Controller::HTTP_NOT_FOUND);".PHP_EOL;
                    $controller .= "    }".PHP_EOL.PHP_EOL;
                    $controller .= "    # NO_CONTENT (204) being the HTTP response code".PHP_EOL;
                    $controller .= "    ".$var."this->set_response(['status'=>'success', 'code'=>'1', 'message'=>".$var1."Successfully Deleted!".$var1.", 'data'=>".$var1."Successfully Deleted!".$var1."], REST_Controller::HTTP_NO_CONTENT);".PHP_EOL;
                    $controller .= "  }".PHP_EOL.PHP_EOL;
                    
                    # End Class
                    $controller .= "}".PHP_EOL.PHP_EOL;

                    # Create Controllers File & Copy Content
                    file_put_contents($authControllerFilePath, $controller, FILE_APPEND | LOCK_EX);
                    unset($controllerFilePath);
                    unset($controller);

                    continue;
                }
            }

            if($controllersFeature->enable === "YES") 
            {
                #
                # Open Php File & Brand Promotion
                #
                $controller .= "<?php".PHP_EOL;
                $controller .= "/** ".PHP_EOL;
                $controller .= " * ".$tableName."Controller.php".PHP_EOL;
                $controller .= " *".PHP_EOL;
                $controller .= " * Generated with AutoGenCode v1.0.0".PHP_EOL;
                $controller .= " *".PHP_EOL;
                $controller .= " * @author      Pavan Kumar".PHP_EOL;
                $controller .= " * @contact     8520872771".PHP_EOL;
                $controller .= " * @mailId      en.pavankumar@gmail.com".PHP_EOL;
                $controller .= " *".PHP_EOL;
                $controller .= " * @createdAt   ".date("Y-m-d h:i:s").PHP_EOL;
                $controller .= " * @project     ".$projectName.PHP_EOL;
                $controller .= " */".PHP_EOL;
                $controller .= "#########################################################################################".PHP_EOL;
                $controller .= "".PHP_EOL;
                $controller .= "# No direct script access allowed".PHP_EOL;
                $controller .= "defined('BASEPATH') OR exit('No direct script access allowed');".PHP_EOL.PHP_EOL;
                $controller .= "# This can be removed if you use __autoload() in config.php OR use Modular Extensions".PHP_EOL;
                $controller .= "require APPPATH . 'libraries/REST_Controller.php';".PHP_EOL.PHP_EOL;
                #
                # Class Start
                #
                $controller .= "/**".PHP_EOL;
                $controller .= " * ".$tableName." Controller".PHP_EOL;
                $controller .= " */".PHP_EOL;
                $controller .= "class ".$tableName."Controller extends REST_Controller".PHP_EOL;
                $controller .= "{".PHP_EOL;
                $controller .= "  # Construct the parent class".PHP_EOL;
                $controller .= "  public function __construct() {".PHP_EOL;
                $controller .= "    parent::__construct();".PHP_EOL;
                $controller .= "    # Load model".PHP_EOL;
                $controller .= "    ".$var."this->load->model('".$tableName."Model');".PHP_EOL;
                $controller .= "    ".$var."this->load->model('LibraryModel');".PHP_EOL;
                $controller .= "  }".PHP_EOL.PHP_EOL;
                $controller .= "#                                                                                                                 #".PHP_EOL;
                $controller .= "###################################################################################################################".PHP_EOL;
                $controller .= "#                                                                                                                 #".PHP_EOL.PHP_EOL;
                #
                # Method 1 : Get Method
                #
                $controller .= "  /**".PHP_EOL;
                $controller .= "   * Method : GET".PHP_EOL;
                $controller .= "   * Method Name : fetch".PHP_EOL;
                $controller .= "   * Description : fetch all records based on params".PHP_EOL;
                $controller .= "   * ".PHP_EOL;
                $controller .= "   * @param   array List of params".PHP_EOL;
                $controller .= "   * ".PHP_EOL;
                $controller .= "   * NOTE : PAGINATION INFORMATION".PHP_EOL;
                $controller .= "   * @param   string    limit - no of records to show".PHP_EOL;
                $controller .= "   * @param   string    start - from where to show (starting point)".PHP_EOL;
                $controller .= "   * ".PHP_EOL;
                $controller .= "   * @return  array response".PHP_EOL;
                $controller .= "   */".PHP_EOL;
                $controller .= "  public function fetch_get()".PHP_EOL;
                $controller .= "  {".PHP_EOL;
                # Header Check
                $controller .= "    # Header Check - Content-Type : Application / Json".PHP_EOL;
                $controller .= "    if (!preg_match('/application\/json/i',(".$var."this->input->get_request_header('Content-Type') ?? ''))) {".PHP_EOL;
                $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'Content-Type must be application-json'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
                $controller .= "    }".PHP_EOL.PHP_EOL;
                # If Authentication Is Yes - Validate Token
                if($authenticationFeature->enable === "YES") {
                    $controller .= "    # Get Authorization Key & Token".PHP_EOL;
                    $controller .= "    ".$var."authorization = ".$var."this->input->get_request_header('Authorization') ?? '';".PHP_EOL;
                    $controller .= "    if(empty(".$var."authorization)) {".PHP_EOL;
                    $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Un Authorized access!', 'data'=>'Authorization Token Is Missing!'], REST_Controller::HTTP_UNAUTHORIZED);".PHP_EOL;
                    $controller .= "    }".PHP_EOL.PHP_EOL;  
                    $controller .= "    # Verify Authentication".PHP_EOL;
                    $controller .= "    ".$var."verify = (new LibraryModel())->verifyAuthentication(".$var."authorization);".PHP_EOL;
                    $controller .= "    if(isset(".$var."verify['error'])) { // Code - 2 Indicates Authentication Failed".PHP_EOL;
                    $controller .= "      # HTTP_UNAUTHORIZED (401) being the HTTP response code".PHP_EOL;
                    $controller .= "      return ".$var."this->set_response(['status' => 'fail', 'code'=>'2', 'message'=>'Un Authorized access!', 'data' => ".$var."verify['error']], REST_Controller::HTTP_UNAUTHORIZED);".PHP_EOL; 
                    $controller .= "    }".PHP_EOL.PHP_EOL;
                }
                # Get Params
                $controller .= "    # Get Params".PHP_EOL;
                $controller .= "    ".$var."params = [".PHP_EOL;
                if(!empty($primaryKey)) {
                    if(json_decode($primaryKey->attribute_inputtype)->key !== "HIDE") {
                        $controller .= "      '".$primaryKey->attribute_code."'=>".$var."this->get('".$primaryKey->attribute_code."') ?? '',".PHP_EOL;
                    }
                }
                if(!empty($referenceKey) && ($referenceKey->attribute_code !== $primaryKey->attribute_code) ) {
                    $controller .= "      '".$referenceKey->attribute_code."'=>".$var."this->get('".$referenceKey->attribute_code."') ?? '',".PHP_EOL;
                }
                if(count($foreignKeys) > 0) {
                    foreach($foreignKeys as $foreignKey) {
                        $controller .= "      '".$foreignKey->attribute_code."'=>".$var."this->get('".$foreignKey->attribute_code."') ?? '',".PHP_EOL;
                    }
                }            
                $controller .= "      'limit'=>".$var."this->get('limit') ?? '',".PHP_EOL;
                $controller .= "      'start'=>".$var."this->get('start') ?? ''".PHP_EOL;
                $controller .= "    ];".PHP_EOL.PHP_EOL;
                # Send Request To Model & Set Error Message
                $controller .= "    # Send request to model - returns an array".PHP_EOL;
                $controller .= "    ".$var."result=".$var."this->".$tableName."Model->fetch(".$var."params);".PHP_EOL.PHP_EOL;
                $controller .= "    # Set error message if found".PHP_EOL;
                $controller .= "    if(isset(".$var."result['error'])) {".PHP_EOL;
                $controller .= "      # NOT_FOUND (404) being the HTTP response code".PHP_EOL;
                $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Failed To Fetch Data!', 'data'=>".$var."result['message']], REST_Controller::HTTP_NOT_FOUND);".PHP_EOL;
                $controller .= "    }".PHP_EOL.PHP_EOL;
                # Return Response
                $controller .= "    # Set (200) OK being the HTTP response code & return an array".PHP_EOL;
                $controller .= "    ".$var."this->set_response(['status'=>'success', 'code'=>'1', 'message'=>'Successfully Fetched Records!', 'data'=>".$var."result], REST_Controller::HTTP_OK);".PHP_EOL;
                $controller .= "  }".PHP_EOL.PHP_EOL;
                $controller .= "#                                                                                                                 #".PHP_EOL;
                $controller .= "###################################################################################################################".PHP_EOL;
                $controller .= "#                                                                                                                 #".PHP_EOL.PHP_EOL;
                #
                # Method 2 : Post Method
                #
                $controller .= "  /**".PHP_EOL;
                $controller .= "   * Method : POST".PHP_EOL;
                $controller .= "   * Method Name : create".PHP_EOL;
                $controller .= "   * Description : create a new record".PHP_EOL;
                $controller .= "   * ".PHP_EOL;
                $controller .= "   * POST BODY : Json Body".PHP_EOL;
                $controller .= "   * {".PHP_EOL;
                if(!empty($userFilledAttributes)) {
                    foreach($userFilledAttributes as $userFilledAttribute) {
                        if (next($userFilledAttributes)==true) {
                            $controller .= '   *    "'.$userFilledAttribute->attribute_code.'":"",'.PHP_EOL;                        
                        } else {
                            $controller .= '   *    "'.$userFilledAttribute->attribute_code.'":""'.PHP_EOL;
                        }                    
                    }                
                }
                $controller .= "   * }".PHP_EOL;
                $controller .= "   * ".PHP_EOL;
                $controller .= "   * @return  array response".PHP_EOL;
                $controller .= "   */".PHP_EOL;
                $controller .= "  public function create_post()".PHP_EOL;
                $controller .= "  {".PHP_EOL;
                # Header Check
                $controller .= "    # Header Check - Content-Type : Application / Json".PHP_EOL;
                $controller .= "    if (!preg_match('/application\/json/i',(".$var."this->input->get_request_header('Content-Type') ?? ''))) {".PHP_EOL;
                $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'Content-Type must be application-json'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
                $controller .= "    }".PHP_EOL.PHP_EOL;
                # If Authentication Is Yes - Validate Token
                if($authenticationFeature->enable === "YES") {
                    $controller .= "    # Get Authorization Key & Token".PHP_EOL;
                    $controller .= "    ".$var."authorization = ".$var."this->input->get_request_header('Authorization') ?? '';".PHP_EOL;
                    $controller .= "    if(empty(".$var."authorization)) {".PHP_EOL;
                    $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Un Authorized access!', 'data'=>'Authorization Token Is Missing!'], REST_Controller::HTTP_UNAUTHORIZED);".PHP_EOL;
                    $controller .= "    }".PHP_EOL.PHP_EOL;  
                    $controller .= "    # Verify Authentication".PHP_EOL;
                    $controller .= "    ".$var."verify = (new LibraryModel())->verifyAuthentication(".$var."authorization);".PHP_EOL;
                    $controller .= "    if(isset(".$var."verify['error'])) { // Code - 2 Indicates Authentication Failed".PHP_EOL;
                    $controller .= "      # HTTP_UNAUTHORIZED (401) being the HTTP response code".PHP_EOL;
                    $controller .= "      return ".$var."this->set_response(['status' => 'fail', 'code'=>'2', 'message'=>'Un Authorized access!', 'data' => ".$var."verify['error']], REST_Controller::HTTP_UNAUTHORIZED);".PHP_EOL; 
                    $controller .= "    }".PHP_EOL.PHP_EOL;
                }
                # Verify All Fields Exist In Post Body
                // $controller .= "    # verify all fields exist in post body".PHP_EOL;
                // $controller .= "    ".$var."verifyFields = (new LibraryModel())->verifyFields(".$var."input);".PHP_EOL;
                // $controller .= "    if(isset(".$var."verifyFields['error'])) {".PHP_EOL;
                // $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'data'=>".$var."verifyFields['error']], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
                // $controller .= "    }".PHP_EOL.PHP_EOL;
                # Decode Json Post Body To An Array
                $controller .= "    # Decode payload to array - get post body".PHP_EOL;
                $controller .= "    ".$var."input = (json_decode(file_get_contents('php://input'),true) ?? []);".PHP_EOL;
                $controller .= "    if (empty(".$var."input)) {".PHP_EOL;
                $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'data'=>'Invalid post body'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
                $controller .= "    }".PHP_EOL.PHP_EOL;
                # Mandatory Fields Exist Check
                if(count($mandatoryAttributes) > 0) {
                    foreach($mandatoryAttributes as $mandatoryAttribute) {
                        $controller .= "    # ".$mandatoryAttribute->attribute_name." exist check".PHP_EOL;
                        $controller .= "    if(strlen(".$var."input['".$mandatoryAttribute->attribute_code."']) == 0) {".PHP_EOL;
                        $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'data'=>'".$mandatoryAttribute->attribute_code." is a mandatory field'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
                        $controller .= "    }".PHP_EOL.PHP_EOL;
                    }
                }
                # Send Request To Model & Set error message
                $controller .= "    # Send request to model - returns an array".PHP_EOL;
                $controller .= "    ".$var."result=".$var."this->".$tableName."Model->create(".$var."input);".PHP_EOL.PHP_EOL;
                $controller .= "    # Set error message if found".PHP_EOL;
                $controller .= "    if(isset(".$var."result['error'])) {".PHP_EOL;
                $controller .= "      # NOT_FOUND (404) being the HTTP response code".PHP_EOL;
                $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>".$var1."Something Went Wrong!".$var1.", 'data'=>".$var."result['error']], REST_Controller::HTTP_NOT_FOUND);".PHP_EOL;
                $controller .= "    }".PHP_EOL.PHP_EOL;
                # Return Response
                $controller .= "    # Set (200) OK being the HTTP response code & return an array".PHP_EOL;
                $controller .= "    ".$var."this->set_response(['status'=>'success', 'code'=>'1', 'message'=>".$var1."Successfully Created!".$var1.", 'data'=>".$var."result], REST_Controller::HTTP_CREATED);".PHP_EOL;
                $controller .= "  }".PHP_EOL.PHP_EOL;
                $controller .= "#                                                                                                                 #".PHP_EOL;
                $controller .= "###################################################################################################################".PHP_EOL;
                $controller .= "#                                                                                                                 #".PHP_EOL.PHP_EOL;
                #
                # Method 3 : Update Method
                #
                $controller .= "  /**".PHP_EOL;
                $controller .= "   * Method : PUT".PHP_EOL;
                $controller .= "   * Method Name : update".PHP_EOL;
                $controller .= "   * Description : update a existing record".PHP_EOL;
                $controller .= "   * ".PHP_EOL;
                $controller .= "   * NOTE : update single field / multi fields".PHP_EOL;
                $controller .= "   * POST BODY : Json Body".PHP_EOL;
                $controller .= "   * {".PHP_EOL;
                if(!empty($userFilledAttributes)) {
                    foreach($userFilledAttributes as $userFilledAttribute) {
                        if (next($userFilledAttributes)==true) {
                            $controller .= '   *    "'.$userFilledAttribute->attribute_code.'":"",'.PHP_EOL;                        
                        } else {
                            $controller .= '   *    "'.$userFilledAttribute->attribute_code.'":""'.PHP_EOL;
                        }                    
                    }                
                }
                $controller .= "   * }".PHP_EOL;
                $controller .= "   * ".PHP_EOL;
                if(!empty($referenceKey)) {
                    $controller .= "   * @param   string  ".$var.$referenceKey->attribute_code.PHP_EOL;
                } else {
                    if(!empty($primaryKey)) {
                        $controller .= "   * @param   string  ".$primaryKey->attribute_code.PHP_EOL;
                    }
                }
                $controller .= "   * ".PHP_EOL;
                $controller .= "   * @return  array   response".PHP_EOL;
                $controller .= "   */".PHP_EOL;
                # Method Start
                if(!empty($referenceKey)) {
                    $controller .= "  public function update_put(".$var.$referenceKey->attribute_code.")".PHP_EOL;
                } else {
                    if(!empty($primaryKey)) {
                        $controller .= "  public function update_put(".$var.$primaryKey->attribute_code.")".PHP_EOL;
                    }
                }            
                $controller .= "  {".PHP_EOL;
                # Header Check
                $controller .= "    # Header Check - Content-Type : Application / Json".PHP_EOL;
                $controller .= "    if (!preg_match('/application\/json/i',(".$var."this->input->get_request_header('Content-Type') ?? ''))) {".PHP_EOL;
                $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'Content-Type must be application-json'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
                $controller .= "    }".PHP_EOL.PHP_EOL;
                # If Authentication Is Yes - Validate Token
                if($authenticationFeature->enable === "YES") {
                    $controller .= "    # Get Authorization Key & Token".PHP_EOL;
                    $controller .= "    ".$var."authorization = ".$var."this->input->get_request_header('Authorization') ?? '';".PHP_EOL;
                    $controller .= "    if(empty(".$var."authorization)) {".PHP_EOL;
                    $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Un Authorized access!', 'data'=>'Authorization Token Is Missing!'], REST_Controller::HTTP_UNAUTHORIZED);".PHP_EOL;
                    $controller .= "    }".PHP_EOL.PHP_EOL;  
                    $controller .= "    # Verify Authentication".PHP_EOL;
                    $controller .= "    ".$var."verify = (new LibraryModel())->verifyAuthentication(".$var."authorization);".PHP_EOL;
                    $controller .= "    if(isset(".$var."verify['error'])) { // Code - 2 Indicates Authentication Failed".PHP_EOL;
                    $controller .= "      # HTTP_UNAUTHORIZED (401) being the HTTP response code".PHP_EOL;
                    $controller .= "      return ".$var."this->set_response(['status' => 'fail', 'code'=>'2', 'message'=>'Un Authorized access!', 'data' => ".$var."verify['error']], REST_Controller::HTTP_UNAUTHORIZED);".PHP_EOL; 
                    $controller .= "    }".PHP_EOL.PHP_EOL;
                }
                # Decode Post Json Body To An Array
                $controller .= "    # Decode payload to array - get post body".PHP_EOL;
                $controller .= "    ".$var."input = (json_decode(file_get_contents('php://input'),true) ?? []);".PHP_EOL;
                $controller .= "    if (empty(".$var."input)) {".PHP_EOL;
                $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'data'=>'Invalid post body'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
                $controller .= "    }".PHP_EOL.PHP_EOL;
                if(!empty($referenceKey)) {
                    $controller .= "    # ".$referenceKey->attribute_code." exist check".PHP_EOL;
                    $controller .= "    if(strlen(".$var.$referenceKey->attribute_code.") == 0) {".PHP_EOL;
                    $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'".$referenceKey->attribute_code." is a mandatory field'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
                    $controller .= "    }".PHP_EOL.PHP_EOL;
                } else {
                    if(!empty($primaryKey)) {
                        $controller .= "    # ".$primaryKey->attribute_code." exist check".PHP_EOL;
                        $controller .= "    if(strlen(".$var.$primaryKey->attribute_code.") == 0) {".PHP_EOL;
                        $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'".$primaryKey->attribute_code." is a mandatory field'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
                        $controller .= "    }".PHP_EOL.PHP_EOL;
                    }
                }
                # Send Request To Model & Set Error Message
                $controller .= "    # Send request to model - returns an array".PHP_EOL;
                if(!empty($referenceKey)) {
                    $controller .= "    ".$var."result=".$var."this->".$tableName."Model->update(".$var.$referenceKey->attribute_code.", ".$var."input);".PHP_EOL.PHP_EOL;
                } else {
                    if(!empty($primaryKey)) {
                        $controller .= "    ".$var."result=".$var."this->".$tableName."Model->update(".$var.$primaryKey->attribute_code.", ".$var."input);".PHP_EOL.PHP_EOL;
                    }
                }
                $controller .= "    # Set error message if found".PHP_EOL;
                $controller .= "    if(isset(".$var."result['error'])) {".PHP_EOL;
                $controller .= "      # NOT_FOUND (404) being the HTTP response code".PHP_EOL;
                $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>".$var1."Something Went Wrong!".$var1.", 'data'=>".$var."result['error']], REST_Controller::HTTP_NOT_FOUND);".PHP_EOL;
                $controller .= "    }".PHP_EOL.PHP_EOL;
                # Return Response
                $controller .= "    # Set (200) OK being the HTTP response code & return an array".PHP_EOL;
                $controller .= "    ".$var."this->set_response(['status'=>'success', 'code'=>'1', 'message'=>".$var1."Successfully Updated!".$var1.", 'data'=>".$var."result], REST_Controller::HTTP_CREATED);".PHP_EOL;
                $controller .= "  }".PHP_EOL.PHP_EOL;
                $controller .= "#                                                                                                                 #".PHP_EOL;
                $controller .= "###################################################################################################################".PHP_EOL;
                $controller .= "#                                                                                                                 #".PHP_EOL.PHP_EOL;
                #
                # Method 4 : Delete Method
                #
                $controller .= "  /**".PHP_EOL;
                $controller .= "   * Method : DELETE".PHP_EOL;
                $controller .= "   * Method Name : delete".PHP_EOL; 
                $controller .= "   * Description : Delete a record".PHP_EOL; 
                $controller .= "   * ".PHP_EOL; 
                if(!empty($referenceKey)) {
                    $controller .= "   * @param   string  ".$var.$referenceKey->attribute_code.PHP_EOL;
                } else {
                    if(!empty($primaryKey)) {
                        $controller .= "   * @param   string  ".$primaryKey->attribute_code.PHP_EOL;
                    }
                }
                $controller .= "   * ".PHP_EOL; 
                $controller .= "   * @return  array response".PHP_EOL; 
                $controller .= "   */".PHP_EOL; 
                # Method start
                if(!empty($referenceKey)) {
                    $controller .= "  public function delete_delete(".$var.$referenceKey->attribute_code.")".PHP_EOL;
                } else {
                    if(!empty($primaryKey)) {
                        $controller .= "  public function delete_delete(".$var.$primaryKey->attribute_code.")".PHP_EOL;
                    }
                } 
                $controller .= "  {".PHP_EOL; 
                # Header Check
                $controller .= "    # Validate HTTP Request 'Content-type'".PHP_EOL; 
                $controller .= "    if (!preg_match('/application\/json/i',(".$var."this->input->get_request_header('Content-Type') ?? ''))) {".PHP_EOL; 
                $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'Content-Type must be application-json'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL; 
                $controller .= "    }".PHP_EOL.PHP_EOL;
                # If Authentication Is Yes - Validate Token
                if($authenticationFeature->enable === "YES") {
                    $controller .= "    # Get Authorization Key & Token".PHP_EOL;
                    $controller .= "    ".$var."authorization = ".$var."this->input->get_request_header('Authorization') ?? '';".PHP_EOL;
                    $controller .= "    if(empty(".$var."authorization)) {".PHP_EOL;
                    $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Un Authorized access!', 'data'=>'Authorization Token Is Missing!'], REST_Controller::HTTP_UNAUTHORIZED);".PHP_EOL;
                    $controller .= "    }".PHP_EOL.PHP_EOL;  
                    $controller .= "    # Verify Authentication".PHP_EOL;
                    $controller .= "    ".$var."verify = (new LibraryModel())->verifyAuthentication(".$var."authorization);".PHP_EOL;
                    $controller .= "    if(isset(".$var."verify['error'])) { // Code - 2 Indicates Authentication Failed".PHP_EOL;
                    $controller .= "      # HTTP_UNAUTHORIZED (401) being the HTTP response code".PHP_EOL;
                    $controller .= "      return ".$var."this->set_response(['status' => 'fail', 'code'=>'2', 'message'=>'Un Authorized access!', 'data' => ".$var."verify['error']], REST_Controller::HTTP_UNAUTHORIZED);".PHP_EOL; 
                    $controller .= "    }".PHP_EOL.PHP_EOL;
                }
                # Mandatory Fields
                if(!empty($referenceKey)) {
                    $controller .= "    # ".$referenceKey->attribute_code." exist check".PHP_EOL;
                    $controller .= "    if(strlen(".$var.$referenceKey->attribute_code.") == 0) {".PHP_EOL;
                    $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'".$referenceKey->attribute_code." is a mandatory field'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
                    $controller .= "    }".PHP_EOL.PHP_EOL;
                } else {
                    if(!empty($primaryKey)) {
                        $controller .= "    # ".$primaryKey->attribute_code." exist check".PHP_EOL;
                        $controller .= "    if(strlen(".$var.$primaryKey->attribute_code.") == 0) {".PHP_EOL;
                        $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'".$primaryKey->attribute_code." is a mandatory field'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
                        $controller .= "    }".PHP_EOL.PHP_EOL;
                    }
                }
                # Send Request To Model & Set Error message
                $controller .= "    # Send request to model - returns an boolean (true/false)".PHP_EOL;
                if(!empty($referenceKey)) {
                    $controller .= "    ".$var."result = ".$var."this->".$tableName."Model->delete(".$var.$referenceKey->attribute_code.");".PHP_EOL.PHP_EOL;
                } else {
                    if(!empty($primaryKey)) {
                        $controller .= "    ".$var."result = ".$var."this->".$tableName."Model->delete(".$var.$primaryKey->attribute_code.");".PHP_EOL.PHP_EOL;
                    }
                }            
                $controller .= "    # Set error message if found".PHP_EOL;
                $controller .= "    if(!".$var."result) {".PHP_EOL;
                $controller .= "      # NOT_FOUND (404) being the HTTP response code".PHP_EOL;
                $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>".$var1."Something Went Wrong!".$var1.", 'data'=>".$var1."Failed To Delete Record!".$var1."], REST_Controller::HTTP_NOT_FOUND);".PHP_EOL;
                $controller .= "    }".PHP_EOL.PHP_EOL;
                # Return Response
                $controller .= "    # NO_CONTENT (204) being the HTTP response code".PHP_EOL;
                if(!empty($referenceKey)) {
                    $controller .= "    ".$var."this->set_response(['".$referenceKey->attribute_code."' => ".$var.$referenceKey->attribute_code.", 'message' => 'Deleted the resource'], REST_Controller::HTTP_NO_CONTENT);".PHP_EOL;
                } else {
                    if(!empty($primaryKey)) {
                        $controller .= "    ".$var."this->set_response(['".$primaryKey->attribute_code."' => ".$var.$primaryKey->attribute_code.", 'message' => 'Deleted the resource'], REST_Controller::HTTP_NO_CONTENT);".PHP_EOL;
                    }
                }
                $controller .= "  }".PHP_EOL.PHP_EOL;
                $controller .= "#                                                                                                                 #".PHP_EOL;
                $controller .= "###################################################################################################################".PHP_EOL;
                $controller .= "#                                                                                                                 #".PHP_EOL.PHP_EOL;
                #
                # Method 5 : Search Method
                #
                $controller .= "  /**".PHP_EOL;
                $controller .= "   * Method : GET".PHP_EOL;
                $controller .= "   * Method Name : search".PHP_EOL;
                $controller .= "   * Description : fetch all records based on given search".PHP_EOL;
                $controller .= "   * ".PHP_EOL;
                $controller .= "   * @param  string search key word".PHP_EOL;
                $controller .= "   * ".PHP_EOL;
                $controller .= "   * @return  array response".PHP_EOL;
                $controller .= "   */".PHP_EOL;
                # Method Start
                $controller .= "  public function search_get()".PHP_EOL;
                $controller .= "  {".PHP_EOL;
                # Header Check
                $controller .= "    # Header Check - Content-Type : Application / Json".PHP_EOL;
                $controller .= "    if (!preg_match('/application\/json/i',(".$var."this->input->get_request_header('Content-Type') ?? ''))) {".PHP_EOL;
                $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'Content-Type must be application-json'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
                $controller .= "    }".PHP_EOL.PHP_EOL;
                # If Authentication Is Yes - Validate Token
                if($authenticationFeature->enable === "YES") {
                    $controller .= "    # Get Authorization Key & Token".PHP_EOL;
                    $controller .= "    ".$var."authorization = ".$var."this->input->get_request_header('Authorization') ?? '';".PHP_EOL;
                    $controller .= "    if(empty(".$var."authorization)) {".PHP_EOL;
                    $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Un Authorized access!', 'data'=>'Authorization Token Is Missing!'], REST_Controller::HTTP_UNAUTHORIZED);".PHP_EOL;
                    $controller .= "    }".PHP_EOL.PHP_EOL;  
                    $controller .= "    # Verify Authentication".PHP_EOL;
                    $controller .= "    ".$var."verify = (new LibraryModel())->verifyAuthentication(".$var."authorization);".PHP_EOL;
                    $controller .= "    if(isset(".$var."verify['error'])) { // Code - 2 Indicates Authentication Failed".PHP_EOL;
                    $controller .= "      # HTTP_UNAUTHORIZED (401) being the HTTP response code".PHP_EOL;
                    $controller .= "      return ".$var."this->set_response(['status' => 'fail', 'code'=>'2', 'message'=>'Un Authorized access!', 'data' => ".$var."verify['error']], REST_Controller::HTTP_UNAUTHORIZED);".PHP_EOL; 
                    $controller .= "    }".PHP_EOL.PHP_EOL;
                }
                # Get Params
                $controller .= "    # Get params".PHP_EOL;
                $controller .= "    ".$var."search =  ".$var."this->get('search') ?? '';".PHP_EOL.PHP_EOL;
                $controller .= "    # Search exist check".PHP_EOL;
                $controller .= "    if(empty(".$var."this->get('search'))) {".PHP_EOL;
                $controller .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'search is a mandatory field'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
                $controller .= "    }".PHP_EOL.PHP_EOL;
                # Send Request To Model & Set Error Message
                $controller .= "    # Send request to model - returns an array".PHP_EOL;
                $controller .= "    ".$var."result = ".$var."this->".$tableName."Model->search(".$var."search);".PHP_EOL.PHP_EOL;
                $controller .= "    # Set error message if found".PHP_EOL;
                $controller .= "    if(isset(".$var."result['message'])) {".PHP_EOL;
                $controller .= "      # NOT_FOUND (404) being the HTTP response code".PHP_EOL;
                $controller .= "      return ".$var."this->set_response(['status' => FALSE, 'code' => '0', 'message' => ".$var."result['message']], REST_Controller::HTTP_NOT_FOUND);".PHP_EOL;
                $controller .= "    }".PHP_EOL.PHP_EOL;
                # Return Response
                $controller .= "    # Set (200) OK being the HTTP response code & return an array".PHP_EOL;
                $controller .= "    ".$var."this->set_response(['status'=>'success', 'code'=>'1', 'message'=>'Successfully Fetched Records!', 'data'=>".$var."result], REST_Controller::HTTP_OK);".PHP_EOL;
                $controller .= "  }".PHP_EOL.PHP_EOL;
                # End Class
                $controller .= "}".PHP_EOL.PHP_EOL;

                # Create Controllers File & Copy Content
                file_put_contents($controllerFilePath, $controller, FILE_APPEND | LOCK_EX);
                unset($controllerFilePath);
                unset($controller);
            }
        }

        return true;
    }

    


    















/* *************************************************************************************************************** */
/*  ###  Generate Migration Controller For Project ###                                                             */
/* *************************************************************************************************************** */

    /**
     * NOTE : Generate Migrations For Given Tables
     *
     * @param   string    $migrationCtrlFilePath - Migration Controller
     * 
     * @return  Success / Failure
     */
    public function createMigrationCtrl($migrationCtrlFilePath)
    {
        # Initialize string
        $migrate = "";

        # Initialise Variables
        $var = "$";
        $var1 = '"';

        # Migration Code
        $migrate .= "<?php defined('BASEPATH') OR exit('No direct script access allowed');".PHP_EOL.PHP_EOL;
        $migrate .= "class MigrationController extends CI_Controller".PHP_EOL;
        $migrate .= "{".PHP_EOL;
        $migrate .= "  public function index()".PHP_EOL;
        $migrate .= "  {".PHP_EOL;
        $migrate .= "    if (ENVIRONMENT == 'development') {".PHP_EOL;
        $migrate .= "      ".$var."this->load->library('migration');".PHP_EOL;
        $migrate .= "      if ( ! ".$var."this->migration->current()) {".PHP_EOL;
        $migrate .= "        show_error(".$var."this->migration->error_string());".PHP_EOL;
        $migrate .= "      } else {".PHP_EOL;
        $migrate .= "        echo ".$var1."success".$var1.";".PHP_EOL;
        $migrate .= "      }".PHP_EOL;
        $migrate .= "    } else {".PHP_EOL;
        $migrate .= "      echo ".$var1."go away".$var1.";".PHP_EOL;
        $migrate .= "    }".PHP_EOL;
        $migrate .= "  }".PHP_EOL;
        $migrate .= "}".PHP_EOL;

        # Create Migration File & Copy Content
        file_put_contents($migrationCtrlFilePath, $migrate , FILE_APPEND | LOCK_EX);

        return TRUE;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
/* *************************************************************************************************************** */
/*  ###  Create Register Controller File For Project  ###                                                                            */
/* *************************************************************************************************************** */

    /**
     * NOTE : Create Register Controller File
     *
     * @param   array       $tables - All Tables
     * 
     * @param   string      $filePath - File Path
     * 
     * @param   string      $projectName - Project Name
     * 
     * @return  true/false
     */
    public function createRegisterController($tables, $filePath, $projectName)
    {
        # Initialise Variables
        $var = "$";
        $var1 = '"';

        # Migrate for each table
        foreach($tables as $table) {

            # Register Controller Only For Users
            if($table->table_code === "users") {
                
                # Get Attributes For Particular Table
                $attributes = Attribute::where('table_uuid',$table->uuid)->get();

                # Initialise Strings
                $registerC = "";

                $registerC .= "<?php".PHP_EOL;
                $registerC .= "/**".PHP_EOL;
                $registerC .= " * RegisterController.php".PHP_EOL;
                $registerC .= " *".PHP_EOL;
                $registerC .= " * Register Controller".PHP_EOL;
                $registerC .= " *".PHP_EOL;
                $registerC .= " * Generated with AutoGenCode v1.0.0".PHP_EOL;
                $registerC .= " *".PHP_EOL;
                $registerC .= " * @author      Pavan Kumar".PHP_EOL;
                $registerC .= " * @contact     8520872771".PHP_EOL;
                $registerC .= " * @mailId      en.pavankumar@gmail.com".PHP_EOL;
                $registerC .= " *".PHP_EOL;
                $registerC .= " * @createdAt   ".date("Y-m-d h:i:s").PHP_EOL;
                $registerC .= " * @project     ".$projectName.PHP_EOL;
                $registerC .= " */".PHP_EOL;
                $registerC .= "#########################################################################################".PHP_EOL.PHP_EOL;
                $registerC .= "# No direct script access allowed".PHP_EOL;
                $registerC .= "defined('BASEPATH') OR exit('No direct script access allowed');".PHP_EOL.PHP_EOL;
                $registerC .= "# This can be removed if you use __autoload() in config.php OR use Modular Extensions".PHP_EOL;
                $registerC .= "require APPPATH . 'libraries/REST_Controller.php';".PHP_EOL.PHP_EOL;
                $registerC .= "/**".PHP_EOL;
                $registerC .= " * Register Controller".PHP_EOL;
                $registerC .= " */".PHP_EOL;
                $registerC .= "class RegisterController extends REST_Controller".PHP_EOL;
                $registerC .= "{".PHP_EOL;
                $registerC .= "  # Construct the parent class".PHP_EOL;
                $registerC .= "  public function __construct() {".PHP_EOL;
                $registerC .= "    parent::__construct();".PHP_EOL;
                $registerC .= "    # Load model".PHP_EOL;
                $registerC .= "    ".$var."this->load->model('auth/RegisterModel');".PHP_EOL;
                $registerC .= "  }".PHP_EOL.PHP_EOL;
                $registerC .= "  /**".PHP_EOL;
                $registerC .= "   * Method : POST".PHP_EOL;
                $registerC .= "   * Method Name : register".PHP_EOL;
                $registerC .= "   * Description : Register a new user".PHP_EOL;
                $registerC .= "   * ".PHP_EOL;
                $registerC .= "   * POST BODY : Json Body".PHP_EOL;
                $registerC .= "   * {".PHP_EOL;
                foreach($attributes as $attribute) {
                    if( ($attribute->attribute_code === "id") || ($attribute->attribute_code === "uuid") || ($attribute->attribute_code === "private_uuid") || ($attribute->attribute_code === "pw_seed") || ($attribute->attribute_code === "pw_hash") || ($attribute->attribute_code === "pw_algo") || json_decode($attribute->attribute_inputtype)->key === "CURRENT_DATE" || json_decode($attribute->attribute_inputtype)->key === "CURRENT_DATETIME" || json_decode($attribute->attribute_inputtype)->key === "CURRENT_TIMESTAMP" ) {
                        continue;
                    } else {
                        $registerC .= "   *    ".$var1.$attribute->attribute_code.$var1.":".$var1.$var1.",".PHP_EOL;
                    }
                }
                $registerC .= "   *    ".$var1."user_password".$var1.":".$var1.$var1.PHP_EOL;
                $registerC .= "   * }".PHP_EOL;
                $registerC .= "   *".PHP_EOL;
                $registerC .= "   * @return  string  TOKEN".PHP_EOL;
                $registerC .= "   */".PHP_EOL;
                $registerC .= "  public function register_post()".PHP_EOL;
                $registerC .= "  {".PHP_EOL;
                $registerC .= "    # Validate HTTP request header has 'Content-type':'Application/Json'".PHP_EOL;
                $registerC .= "    if (!preg_match('/application\/json/i',(".$var."this->input->get_request_header('Content-Type') ?? ''))) {".PHP_EOL;
                $registerC .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'Content-Type must be application-json'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
                $registerC .= "    }".PHP_EOL.PHP_EOL;
                $registerC .= "    # Decode payload - get post body as array".PHP_EOL;
                $registerC .= "    ".$var."input = (json_decode(file_get_contents('php://input'),true) ?? []);".PHP_EOL;
                $registerC .= "    if (empty(".$var."input)) {".PHP_EOL;
                $registerC .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'Invalid post body'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
                $registerC .= "    }".PHP_EOL.PHP_EOL;
                $registerC .= "    # user_password exist check".PHP_EOL;
                $registerC .= "    if(empty(".$var."input['user_password'])) {".PHP_EOL;
                $registerC .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'user_password is a mandatory field'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
                $registerC .= "    }".PHP_EOL.PHP_EOL;
                # Required Fields For registration
                foreach($attributes as $attribute) {
                    if(
                        $attribute->attribute_code === "private_uuid" ||
                        $attribute->attribute_code === "pw_seed" ||
                        $attribute->attribute_code === "pw_hash" ||
                        $attribute->attribute_code === "pw_algo" ||
                        $attribute->attribute_null === "on" ||
                        $attribute->attribute_null === "1" ||
                        $attribute->attribute_index === "PRIMARY" || 
                        $attribute->attribute_autoincrement === "on" ||
                        $attribute->attribute_autoincrement === "1" ||
                        json_decode($attribute->attribute_inputtype)->key === "REFERENCE_KEY_UUID" || 
                        json_decode($attribute->attribute_inputtype)->key === "UUID" ||                
                        json_decode($attribute->attribute_inputtype)->key === "CURRENT_DATE" ||
                        json_decode($attribute->attribute_inputtype)->key === "CURRENT_DATETIME" ||
                        json_decode($attribute->attribute_inputtype)->key === "CURRENT_TIMESTAMP"
                    ) {
                        continue;
                    } else {
                        $registerC .= "    # ".$attribute->attribute_code." exist check".PHP_EOL;
                        $registerC .= "    if(strlen(".$var."input['".$attribute->attribute_code."']) == 0) {".PHP_EOL;
                        $registerC .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'".$attribute->attribute_code." is a mandatory field'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
                        $registerC .= "    }".PHP_EOL.PHP_EOL;
                    }
                }
                $registerC .= "    # Send request to model - returns an array".PHP_EOL;
                $registerC .= "    ".$var."result=".$var."this->RegisterModel->register(".$var."input);".PHP_EOL.PHP_EOL;
                $registerC .= "    # Set error message if found".PHP_EOL;
                $registerC .= "    if(isset(".$var."result['error'])) {".PHP_EOL;
                $registerC .= "      # NOT_FOUND (404) being the HTTP response code".PHP_EOL;
                $registerC .= "      return ".$var."this->set_response(['status' => 'fail', 'code' => '0', 'message' => ".$var."result['message']], REST_Controller::HTTP_NOT_FOUND);".PHP_EOL;
                $registerC .= "    }".PHP_EOL.PHP_EOL;
                $registerC .= "    # Set (200) OK being the HTTP response code & return an array".PHP_EOL;
                $registerC .= "    ".$var."this->set_response(['status' => 'success', 'code' => '1', 'message'=>'Successfully Created', 'data' => ".$var."result], REST_Controller::HTTP_CREATED);".PHP_EOL;
                $registerC .= "  }".PHP_EOL.PHP_EOL;
                $registerC .= "}".PHP_EOL;
                $registerC .= "?>".PHP_EOL;

                # Create Register Controller File & Copy Content
                file_put_contents($filePath, $registerC.PHP_EOL, FILE_APPEND | LOCK_EX);  

                break;
            }
        }

        return TRUE;
    }




















/* *************************************************************************************************************** */
/*  ###  Create Login Controller File For Project  ###                                                                            */
/* *************************************************************************************************************** */

    /**
     * NOTE : Create Login Controller File
     *
     * @param   array       $tables - All Tables
     * 
     * @param   string      $filePath - File Path
     * 
     * @param   string      $projectName - Project Name
     * 
     * @return  true/false
     */
    public function createLoginController($tables, $filePath, $projectName)
    {
        # Initialise Variables
        $var = "$";
        $var1 = '"';

        # Migrate for each table
        foreach($tables as $table) {

            # Register Controller Only For Users
            if($table->table_code === "users") {
                
                # Get Attributes For Particular Table
                $attributes = Attribute::where('table_uuid',$table->uuid)->get();

                # Initialise Strings
                $loginC = "";

                $loginC .= "<?php".PHP_EOL;
                $loginC .= "/**".PHP_EOL;
                $loginC .= " * LoginController.php".PHP_EOL;
                $loginC .= " *".PHP_EOL;
                $loginC .= " * Generated with AutoGenCode v1.0.0".PHP_EOL;
                $loginC .= " *".PHP_EOL;
                $loginC .= " * @author      Pavan Kumar".PHP_EOL;
                $loginC .= " * @contact     8520872771".PHP_EOL;
                $loginC .= " * @mailId      en.pavankumar@gmail.com".PHP_EOL;
                $loginC .= " *".PHP_EOL;
                $loginC .= " * @createdAt   ".date("Y-m-d h:i:s").PHP_EOL;
                $loginC .= " * @project     ".$projectName.PHP_EOL;
                $loginC .= " */".PHP_EOL;
                $loginC .= "#########################################################################################".PHP_EOL.PHP_EOL;
                $loginC .= "# No direct script access allowed".PHP_EOL;
                $loginC .= "defined('BASEPATH') OR exit('No direct script access allowed');".PHP_EOL.PHP_EOL;
                $loginC .= "# This can be removed if you use __autoload() in config.php OR use Modular Extensions".PHP_EOL;
                $loginC .= "require APPPATH . 'libraries/REST_Controller.php';".PHP_EOL.PHP_EOL;
                $loginC .= "/**".PHP_EOL;
                $loginC .= " * Login Controller".PHP_EOL;
                $loginC .= " */".PHP_EOL;
                $loginC .= "class LoginController extends REST_Controller".PHP_EOL;
                $loginC .= "{".PHP_EOL;
                $loginC .= "  # Construct the parent class".PHP_EOL;
                $loginC .= "  public function __construct() {".PHP_EOL;
                $loginC .= "    parent::__construct();".PHP_EOL;
                $loginC .= "    # Load model".PHP_EOL;
                $loginC .= "    ".$var."this->load->model('auth/LoginModel');".PHP_EOL;
                $loginC .= "  }".PHP_EOL.PHP_EOL;
                foreach($attributes as $attribute) {
                    if( ( ($attribute->attribute_code === "user_name") || ($attribute->attribute_code === "user_email") || ($attribute->attribute_code === "user_mobile") ) && ($attribute->attribute_index === "UNIQUE") ) {
                        
                        $loginC .= "#".PHP_EOL;
                        $loginC .= "########################################################################################################".PHP_EOL;
                        $loginC .= "#".PHP_EOL.PHP_EOL;
                        $loginC .= "  /**".PHP_EOL;
                        $loginC .= "   * Method : POST".PHP_EOL;
                        if($attribute->attribute_code === "user_name") {
                            $loginC .= "   * Method Name : NameLogin".PHP_EOL;
                            $loginC .= "   * Description : Login with Name & password".PHP_EOL;
                        } else if($attribute->attribute_code === "user_email") {
                            $loginC .= "   * Method Name : EmailLogin".PHP_EOL;
                            $loginC .= "   * Description : Login with Email & password".PHP_EOL;
                        } else if($attribute->attribute_code === "user_mobile") {
                            $loginC .= "   * Method Name : MobileLogin".PHP_EOL;
                            $loginC .= "   * Description : Login with mobileNo & password".PHP_EOL;
                        }
                        $loginC .= "   * ".PHP_EOL;
                        $loginC .= "   * POST BODY : Json Body".PHP_EOL;
                        $loginC .= "   * {".PHP_EOL;
                        if($attribute->attribute_code === "user_name") {
                            $loginC .= "   *    ".$var1."user_name".$var1.":".$var1.$var1.",".PHP_EOL;
                        } else if($attribute->attribute_code === "user_email") {
                            $loginC .= "   *    ".$var1."user_email".$var1.":".$var1.$var1.",".PHP_EOL;
                        } else if($attribute->attribute_code === "user_mobile") {
                            $loginC .= "   *    ".$var1."user_mobile".$var1.":".$var1.$var1.",".PHP_EOL;
                        }
                        $loginC .= "   *    ".$var1."user_password".$var1.":".$var1.$var1.PHP_EOL;
                        $loginC .= "   * }".PHP_EOL;
                        $loginC .= "   *".PHP_EOL;
                        $loginC .= "   * @return  string Authorization_Token".PHP_EOL;
                        $loginC .= "   */".PHP_EOL;
                        if($attribute->attribute_code === "user_name") {
                            $loginC .= "  public function nameLogin_post()".PHP_EOL;
                        } else if($attribute->attribute_code === "user_email") {
                            $loginC .= "  public function emailLogin_post()".PHP_EOL;
                        } else if($attribute->attribute_code === "user_mobile") {
                            $loginC .= "  public function mobileLogin_post()".PHP_EOL;
                        }
                        $loginC .= "  {".PHP_EOL;
                        $loginC .= "    # Validate HTTP Request ".$var1."Content-type".$var1."".PHP_EOL;
                        $loginC .= "    if (!preg_match('/application\/json/i',(".$var."this->input->get_request_header('Content-Type') ?? ''))) {".PHP_EOL;
                        $loginC .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'Content-Type must be application-json'], REST_Controller::HTTP_BAD_REQUEST); ".PHP_EOL;
                        $loginC .= "    }".PHP_EOL.PHP_EOL;
                        $loginC .= "    # Decode payload to array - get post body ".PHP_EOL;
                        $loginC .= "    ".$var."input = (json_decode(file_get_contents('php://input'),true) ?? []);".PHP_EOL;
                        $loginC .= "    if (empty(".$var."input)) {".PHP_EOL;
                        $loginC .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'Invalid post body'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
                        $loginC .= "    }".PHP_EOL.PHP_EOL;
                        if($attribute->attribute_code === "user_name") {
                            $loginC .= "    # user_name exist check".PHP_EOL;
                            $loginC .= "    if(empty(".$var."input['user_name'])) {".PHP_EOL;
                            $loginC .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'user_name is a mandatory field'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
                            $loginC .= "    }".PHP_EOL.PHP_EOL;
                        } else if($attribute->attribute_code === "user_email") {
                            $loginC .= "    # user_email exist check".PHP_EOL;
                            $loginC .= "    if(empty(".$var."input['user_email'])) {".PHP_EOL;
                            $loginC .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'user_email is a mandatory field'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
                            $loginC .= "    }".PHP_EOL.PHP_EOL;
                        } else if($attribute->attribute_code === "user_mobile") {
                            $loginC .= "    # user_mobile exist check".PHP_EOL;
                            $loginC .= "    if(empty(".$var."input['user_mobile'])) {".PHP_EOL;
                            $loginC .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'user_mobile is a mandatory field'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
                            $loginC .= "    }".PHP_EOL.PHP_EOL;
                        }
                        $loginC .= "    # user_password exist check".PHP_EOL;
                        $loginC .= "    if(empty(".$var."input['user_password'])) {".PHP_EOL;
                        $loginC .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'user_password is a mandatory field'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
                        $loginC .= "    }".PHP_EOL.PHP_EOL;
                        $loginC .= "    # Send request to model - returns an array".PHP_EOL;
                        if($attribute->attribute_code === "user_name") {
                            $loginC .= "    ".$var."result=".$var."this->LoginModel->nameLogin(".$var."input);".PHP_EOL.PHP_EOL;
                        } else if($attribute->attribute_code === "user_email") {
                            $loginC .= "    ".$var."result=".$var."this->LoginModel->emailLogin(".$var."input);".PHP_EOL.PHP_EOL;
                        } else if($attribute->attribute_code === "user_mobile") {
                            $loginC .= "    ".$var."result=".$var."this->LoginModel->mobileLogin(".$var."input);".PHP_EOL.PHP_EOL;
                        }
                        $loginC .= "    # Set error message if found".PHP_EOL;
                        $loginC .= "    if(isset(".$var."result['error'])) {".PHP_EOL;
                        $loginC .= "      # NOT_FOUND (404) being the HTTP response code".PHP_EOL;
                        $loginC .= "      ".$var."this->set_response(['status' => 'fail', 'code' => '0', 'message' => '', 'details'=>".$var."result['error']], REST_Controller::HTTP_NOT_FOUND); ".PHP_EOL;
                        $loginC .= "    }".PHP_EOL.PHP_EOL;
                        $loginC .= "    # Set (200) OK being the HTTP response code & return an array".PHP_EOL;
                        $loginC .= "    ".$var."this->set_response(['status' => 'success', 'code' => '1', 'message' => 'Successfully LoggedIn', 'data'=>".$var."result], REST_Controller::HTTP_CREATED);".PHP_EOL;
                        $loginC .= "  }".PHP_EOL.PHP_EOL;
                    
                    }
                }
                
                $loginC .= "}".PHP_EOL;

                # Create Login Controller File & Copy Content
                file_put_contents($filePath, $loginC.PHP_EOL, FILE_APPEND | LOCK_EX);  

                break;
            }
        }

        return TRUE;
    }




















/* *************************************************************************************************************** */
/*  ###  Create Change Password Controller File For Project  ###                                                                            */
/* *************************************************************************************************************** */

    /**
     * NOTE : Create Change Password Controller File
     *
     * @param   string      $filePath - File Path
     * 
     * @param   string      $projectName - Project Name
     * 
     * @return  true/false
     */
    public function createChangePasswordController($filePath, $projectName)
    {
        # Initialise Variables
        $var = "$";
        $var1 = '"';

        # Initialise Strings
        $changePassC = "";

        $changePassC .= "<?php".PHP_EOL;
        $changePassC .= "/** ".PHP_EOL;
        $changePassC .= " * ChangePasswordController.php".PHP_EOL;
        $changePassC .= " *".PHP_EOL;
        $changePassC .= " * Generated with AutoGenCode v1.0.0".PHP_EOL;
        $changePassC .= " *".PHP_EOL;
        $changePassC .= " * @author      Pavan Kumar".PHP_EOL;
        $changePassC .= " * @contact     8520872771".PHP_EOL;
        $changePassC .= " * @mailId      en.pavankumar@gmail.com".PHP_EOL;
        $changePassC .= " * ".PHP_EOL;
        $changePassC .= " * @createdAt   ".date("Y-m-d h:i:s").PHP_EOL;
        $changePassC .= " * @project     ".$projectName.PHP_EOL;
        $changePassC .= " */".PHP_EOL;
        $changePassC .= "#########################################################################################".PHP_EOL.PHP_EOL;
        $changePassC .= "# No direct script access allowed".PHP_EOL;
        $changePassC .= "defined('BASEPATH') OR exit('No direct script access allowed');".PHP_EOL.PHP_EOL;
        $changePassC .= "# This can be removed if you use __autoload() in config.php OR use Modular Extensions".PHP_EOL;
        $changePassC .= "require APPPATH . 'libraries/REST_Controller.php';".PHP_EOL.PHP_EOL;
        $changePassC .= "/**".PHP_EOL;
        $changePassC .= " * Register Controller".PHP_EOL;
        $changePassC .= " */".PHP_EOL;
        $changePassC .= "class ChangePasswordController extends REST_Controller".PHP_EOL;
        $changePassC .= "{".PHP_EOL;
        $changePassC .= "  # Construct the parent class".PHP_EOL;
        $changePassC .= "  public function __construct() {".PHP_EOL;
        $changePassC .= "    parent::__construct();".PHP_EOL;
        $changePassC .= "    # Load model".PHP_EOL;
        $changePassC .= "    ".$var."this->load->model('auth/ChangePasswordModel');".PHP_EOL;
        $changePassC .= "  }".PHP_EOL.PHP_EOL;
        $changePassC .= "  /**".PHP_EOL;
        $changePassC .= "   * Method : POST".PHP_EOL;
        $changePassC .= "   * Method Name : changePassword".PHP_EOL;
        $changePassC .= "   * Description : Change Password".PHP_EOL;
        $changePassC .= "   * ".PHP_EOL;
        $changePassC .= "   * POST BODY : Json Body".PHP_EOL;
        $changePassC .= "   * {".PHP_EOL;
        $changePassC .= "   *    ".$var1."old_password".$var1.":".$var1.$var1.",".PHP_EOL;
        $changePassC .= "   *    ".$var1."new_password".$var1.":".$var1.$var1.",".PHP_EOL;
        $changePassC .= "   *    ".$var1."repeat_password".$var1.":".$var1.$var1.PHP_EOL;
        $changePassC .= "   * }".PHP_EOL;
        $changePassC .= "   * ".PHP_EOL;
        $changePassC .= "   * @return  array response".PHP_EOL;
        $changePassC .= "   */".PHP_EOL;
        $changePassC .= "  public function changePassword_post()".PHP_EOL;
        $changePassC .= "  {".PHP_EOL;
        $changePassC .= "    # Header Check - Content-Type : Application / Json".PHP_EOL;
        $changePassC .= "    if (!preg_match('/application\/json/i',(".$var."this->input->get_request_header('Content-Type') ?? ''))) {".PHP_EOL;
        $changePassC .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'Content-Type must be application-json'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
        $changePassC .= "    }".PHP_EOL.PHP_EOL;
        $changePassC .= "    # Decode payload to array - get post body ".PHP_EOL;
        $changePassC .= "    ".$var."input = (json_decode(file_get_contents('php://input'),true) ?? []);".PHP_EOL;
        $changePassC .= "    if (empty(".$var."input)) {".PHP_EOL;
        $changePassC .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'Invalid post body'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
        $changePassC .= "    }".PHP_EOL.PHP_EOL;
        $changePassC .= "    # Get Authorization Key & Token".PHP_EOL;
        $changePassC .= "    ".$var."authorization = ".$var."this->input->get_request_header('Authorization') ?? '';".PHP_EOL;
        $changePassC .= "    if(empty(".$var."authorization)) {".PHP_EOL;
        $changePassC .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Un Authorized access!', 'data'=>'Authorization Token Is Missing!'], REST_Controller::HTTP_UNAUTHORIZED);".PHP_EOL;
        $changePassC .= "    }".PHP_EOL.PHP_EOL;  
        $changePassC .= "    # Verify Authentication & return only jwt-token".PHP_EOL;
        $changePassC .= "    ".$var."verify = (new LibraryModel())->verifyAuthentication(".$var."authorization);".PHP_EOL;
        $changePassC .= "    if(isset(".$var."verify['error'])) { // Code - 2 Indicates Authentication Failed".PHP_EOL;
        $changePassC .= "      # HTTP_UNAUTHORIZED (401) being the HTTP response code".PHP_EOL;
        $changePassC .= "      return ".$var."this->set_response(['status' => 'fail', 'code'=>'2', 'message'=>'Un Authorized access!', 'data' => ".$var."verify['error']], REST_Controller::HTTP_UNAUTHORIZED);".PHP_EOL; 
        $changePassC .= "    }".PHP_EOL.PHP_EOL;
        $changePassC .= "    # old_password exist check".PHP_EOL;
        $changePassC .= "    if(empty(".$var."input['old_password'])) {".PHP_EOL;
        $changePassC .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'old_password is a mandatory field'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
        $changePassC .= "    }".PHP_EOL.PHP_EOL;
        $changePassC .= "    # new_password exist check".PHP_EOL;
        $changePassC .= "    if(empty(".$var."input['new_password'])) {".PHP_EOL;
        $changePassC .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'new_password is a mandatory field'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
        $changePassC .= "    }".PHP_EOL.PHP_EOL;
        $changePassC .= "    # repeat_password exist check".PHP_EOL;
        $changePassC .= "    if(empty(".$var."input['repeat_password'])) {".PHP_EOL;
        $changePassC .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'repeat_password is a mandatory field'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
        $changePassC .= "    }".PHP_EOL.PHP_EOL;  
        $changePassC .= "    # make sure new_password & repeat_password match".PHP_EOL;
        $changePassC .= "    if(".$var."input['new_password'] !== ".$var."input['repeat_password']) {".PHP_EOL;
        $changePassC .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'Password Does Not Match!'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
        $changePassC .= "    }".PHP_EOL.PHP_EOL;
        $changePassC .= "    # Send request to model - returns an array".PHP_EOL;
        $changePassC .= "    ".$var."result=".$var."this->ChangePasswordModel->changePassword(".$var."input, ".$var."verify['jwt_token']);".PHP_EOL.PHP_EOL;
        $changePassC .= "    # Set error message if found".PHP_EOL;
        $changePassC .= "    if(isset(".$var."result['error'])) {".PHP_EOL;
        $changePassC .= "      # NOT_FOUND (404) being the HTTP response code".PHP_EOL;
        $changePassC .= "      ".$var."this->set_response(['status' => 'fail', 'code' => '0', 'message' => 'Failed To Change Password!', 'details' => ".$var."result['error']], REST_Controller::HTTP_NOT_FOUND);".PHP_EOL; 
        $changePassC .= "    }".PHP_EOL.PHP_EOL;
        $changePassC .= "    # Set (200) OK being the HTTP response code & return an array".PHP_EOL;
        $changePassC .= "    ".$var."this->set_response(['status' => 'success', 'code' => '1', 'message' => 'Successfully Changed Password!', 'data' => ".$var."result], REST_Controller::HTTP_CREATED);".PHP_EOL;
        $changePassC .= "  }".PHP_EOL.PHP_EOL;
        $changePassC .= "}";

        # Create Change Password Controller File & Copy Content
        file_put_contents($filePath, $changePassC, FILE_APPEND | LOCK_EX);  

        return TRUE;
    }




















/* *************************************************************************************************************** */
/*  ###  Create Forgot Password Controller File For Project  ###                                                                            */
/* *************************************************************************************************************** */

    /**
     * NOTE : Create Forgot Password Controller File
     *
     * @param   string      $filePath - File Path
     * 
     * @param   string      $projectName - Project Name
     * 
     * @return  true/false
     */
    public function createForgotPasswordController($filePath, $projectName)
    {
        # Initialise Variables
        $var = "$";
        $var1 = '"';

        # Initialise Strings
        $forgotPassC = "";

        $forgotPassC .= "<?php".PHP_EOL;
        $forgotPassC .= "/** ".PHP_EOL;
        $forgotPassC .= " * ForgotPasswordController.php".PHP_EOL;
        $forgotPassC .= " * ".PHP_EOL;
        $forgotPassC .= " * Generated with AutoGenCode v1.0.0".PHP_EOL;
        $forgotPassC .= " * ".PHP_EOL;
        $forgotPassC .= " * @author      Pavan Kumar".PHP_EOL;
        $forgotPassC .= " * @contact     8520872771".PHP_EOL;
        $forgotPassC .= " * @mailId      en.pavankumar@gmail.com".PHP_EOL;
        $forgotPassC .= " * ".PHP_EOL;
        $forgotPassC .= " * @createdAt   ".date("Y-m-d h:i:s").PHP_EOL;
        $forgotPassC .= " * @project     ".$projectName.PHP_EOL;
        $forgotPassC .= " */".PHP_EOL;
        $forgotPassC .= "#########################################################################################".PHP_EOL;
        $forgotPassC .= "".PHP_EOL;
        $forgotPassC .= "# No direct script access allowed".PHP_EOL;
        $forgotPassC .= "defined('BASEPATH') OR exit('No direct script access allowed');".PHP_EOL;
        $forgotPassC .= "".PHP_EOL;
        $forgotPassC .= "# This can be removed if you use __autoload() in config.php OR use Modular Extensions".PHP_EOL;
        $forgotPassC .= "require APPPATH . 'libraries/REST_Controller.php';".PHP_EOL;
        $forgotPassC .= "".PHP_EOL;
        $forgotPassC .= "/**".PHP_EOL;
        $forgotPassC .= " * Forgot Password Controller".PHP_EOL;
        $forgotPassC .= " */".PHP_EOL;
        $forgotPassC .= "class ForgotPasswordController extends REST_Controller".PHP_EOL;
        $forgotPassC .= "{".PHP_EOL;
        $forgotPassC .= "  # Construct the parent class".PHP_EOL;
        $forgotPassC .= "  public function __construct() {".PHP_EOL;
        $forgotPassC .= "    parent::__construct();".PHP_EOL;
        $forgotPassC .= "    # Load model".PHP_EOL;
        $forgotPassC .= "    ".$var."this->load->model('auth/ForgotPasswordModel');".PHP_EOL;
        $forgotPassC .= "  }".PHP_EOL.PHP_EOL;
        $forgotPassC .= "#".PHP_EOL;
        $forgotPassC .= "########################################################################################################".PHP_EOL;
        $forgotPassC .= "#".PHP_EOL.PHP_EOL;
        $forgotPassC .= "  /**".PHP_EOL;
        $forgotPassC .= "   * Method : POST".PHP_EOL;
        $forgotPassC .= "   * Method Name : forgotPassword".PHP_EOL;
        $forgotPassC .= "   * Description : Forgot Password".PHP_EOL;
        $forgotPassC .= "   * ".PHP_EOL;
        $forgotPassC .= "   * POST BODY : Json Body".PHP_EOL;
        $forgotPassC .= "   * {".PHP_EOL;
        $forgotPassC .= "   *    ".$var1."user_email".$var1.":".$var1."".$var1.",".PHP_EOL;
        $forgotPassC .= "   *    ".$var1."url".$var1.":".$var1."".$var1."".PHP_EOL;
        $forgotPassC .= "   * }".PHP_EOL;
        $forgotPassC .= "   * ".PHP_EOL;
        $forgotPassC .= "   * @return  array response".PHP_EOL;
        $forgotPassC .= "   */".PHP_EOL;
        $forgotPassC .= "  public function forgotPassword_post()".PHP_EOL;
        $forgotPassC .= "  {".PHP_EOL;
        $forgotPassC .= "    # Header Check - Content-Type : Application / Json".PHP_EOL;
        $forgotPassC .= "    if (!preg_match('/application\/json/i',(".$var."this->input->get_request_header('Content-Type') ?? ''))) {".PHP_EOL;
        $forgotPassC .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'Content-Type must be application-json'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
        $forgotPassC .= "    }".PHP_EOL.PHP_EOL;
        $forgotPassC .= "    # Decode payload to array - get post body ".PHP_EOL;
        $forgotPassC .= "    ".$var."input = (json_decode(file_get_contents('php://input'),true) ?? []);".PHP_EOL;
        $forgotPassC .= "    if (empty(".$var."input)) {".PHP_EOL;
        $forgotPassC .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'Invalid post body'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
        $forgotPassC .= "    }".PHP_EOL.PHP_EOL;
        $forgotPassC .= "    # user_email exist check".PHP_EOL;
        $forgotPassC .= "    if(empty(".$var."input['user_email'])) {".PHP_EOL;
        $forgotPassC .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'user_email is a mandatory field'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
        $forgotPassC .= "    }".PHP_EOL.PHP_EOL;
        $forgotPassC .= "    # url exist check".PHP_EOL;
        $forgotPassC .= "    if(empty(".$var."input['url'])) {".PHP_EOL;
        $forgotPassC .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'url is a mandatory field'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
        $forgotPassC .= "    }".PHP_EOL.PHP_EOL;
        $forgotPassC .= "    # Send request to model - returns an boolean (true/false)".PHP_EOL;
        $forgotPassC .= "    ".$var."result = ".$var."this->ForgotPasswordModel->forgotPassword(".$var."input);".PHP_EOL.PHP_EOL;
        $forgotPassC .= "    # Set error message if found".PHP_EOL;
        $forgotPassC .= "    if(isset(".$var."result['error'])) {".PHP_EOL;
        $forgotPassC .= "      # NOT_FOUND (404) being the HTTP response code".PHP_EOL;
        $forgotPassC .= "      ".$var."this->set_response(['status' => 'fail', 'code' => '0', 'message' => 'Failed To Send Mail!', 'details' => ".$var."result['error']], REST_Controller::HTTP_NOT_FOUND);".PHP_EOL;
        $forgotPassC .= "    }".PHP_EOL.PHP_EOL;
        $forgotPassC .= "    # Set (200) OK being the HTTP response code & return an array".PHP_EOL;
        $forgotPassC .= "    ".$var."this->set_response(['status' => 'success', 'code' => '1', 'message' => 'Reset Link Sent To Mail!', 'data' => ".$var."result['message']], REST_Controller::HTTP_CREATED);".PHP_EOL;
        $forgotPassC .= "  }".PHP_EOL.PHP_EOL;
        $forgotPassC .= "}";

        # Create Forgot Password Controller File & Copy Content
        file_put_contents($filePath, $forgotPassC, FILE_APPEND | LOCK_EX);  

        return TRUE;
    }




















/* *************************************************************************************************************** */
/*  ###  Create Forgot Password Controller File For Project  ###                                                                            */
/* *************************************************************************************************************** */

    /**
     * NOTE : Create Forgot Password Controller File
     *
     * @param   string      $filePath - File Path
     * 
     * @param   string      $projectName - Project Name
     * 
     * @return  true/false
     */
    public function createResetPasswordController($filePath, $projectName)
    {
        # Initialise Variables
        $var = "$";
        $var1 = '"';

        # Initialise Strings
        $resetPassC = "";

        $resetPassC .= "<?php".PHP_EOL;
        $resetPassC .= "/** ".PHP_EOL;
        $resetPassC .= " * ResetPasswordController.php".PHP_EOL;
        $resetPassC .= " *".PHP_EOL;
        $resetPassC .= " * Generated with AutoGenCode v1.0.0".PHP_EOL;
        $resetPassC .= " *".PHP_EOL;
        $resetPassC .= " * @author      Pavan Kumar".PHP_EOL;
        $resetPassC .= " * @contact     8520872771".PHP_EOL;
        $resetPassC .= " * @mailId      en.pavankumar@gmail.com".PHP_EOL;
        $resetPassC .= " * ".PHP_EOL;
        $resetPassC .= " * @createdAt   ".date("Y-m-d h:i:s").PHP_EOL;
        $resetPassC .= " * @project     ".$projectName.PHP_EOL;
        $resetPassC .= " */".PHP_EOL;
        $resetPassC .= "#########################################################################################".PHP_EOL.PHP_EOL;
        $resetPassC .= "# No direct script access allowed".PHP_EOL;
        $resetPassC .= "defined('BASEPATH') OR exit('No direct script access allowed');".PHP_EOL.PHP_EOL;
        $resetPassC .= "# This can be removed if you use __autoload() in config.php OR use Modular Extensions".PHP_EOL;
        $resetPassC .= "require APPPATH . 'libraries/REST_Controller.php';".PHP_EOL.PHP_EOL;
        $resetPassC .= "/**".PHP_EOL;
        $resetPassC .= " * Reset Password Controller".PHP_EOL;
        $resetPassC .= " */".PHP_EOL;
        $resetPassC .= "class ResetPasswordController extends REST_Controller".PHP_EOL;
        $resetPassC .= "{".PHP_EOL;
        $resetPassC .= "  # Construct the parent class".PHP_EOL;
        $resetPassC .= "  public function __construct() {".PHP_EOL;
        $resetPassC .= "    parent::__construct();".PHP_EOL;
        $resetPassC .= "    # Load model".PHP_EOL;
        $resetPassC .= "    ".$var."this->load->model('auth/ResetPasswordModel');".PHP_EOL;
        $resetPassC .= "  }".PHP_EOL.PHP_EOL;
        $resetPassC .= "#########################################################################################".PHP_EOL;
        $resetPassC .= "#".PHP_EOL;
        $resetPassC .= "# NOTE: If You are using reset password with - user_mobile (Please integrate sms service)".PHP_EOL;
        $resetPassC .= "#".PHP_EOL;
        $resetPassC .= "#########################################################################################".PHP_EOL;
        $resetPassC .= "".PHP_EOL;
        $resetPassC .= "  /**".PHP_EOL;
        $resetPassC .= "   * Method : POST".PHP_EOL;
        $resetPassC .= "   * Method Name : resetPassword".PHP_EOL;
        $resetPassC .= "   * Description : Reset Password".PHP_EOL;
        $resetPassC .= "   * ".PHP_EOL;
        $resetPassC .= "   * POST BODY : Json Body".PHP_EOL;
        $resetPassC .= "   * {".PHP_EOL;
        $resetPassC .= "   *    ".$var1."user_email".$var1.":".$var1."".$var1.",".PHP_EOL;
        $resetPassC .= "   *    ".$var1."new_password".$var1.":".$var1."".$var1.",".PHP_EOL;
        $resetPassC .= "   *    ".$var1."repeat_password".$var1.":".$var1."".$var1."".PHP_EOL;
        $resetPassC .= "   * }".PHP_EOL;
        $resetPassC .= "   * ".PHP_EOL;
        $resetPassC .= "   * @return  array response".PHP_EOL;
        $resetPassC .= "   */".PHP_EOL;
        $resetPassC .= "  public function resetPassword_post()".PHP_EOL;
        $resetPassC .= "  {".PHP_EOL;
        $resetPassC .= "    # Header Check - Content-Type : Application / Json".PHP_EOL;
        $resetPassC .= "    if (!preg_match('/application\/json/i',(".$var."this->input->get_request_header('Content-Type') ?? ''))) {".PHP_EOL;
        $resetPassC .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'Content-Type must be application-json'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
        $resetPassC .= "    }".PHP_EOL.PHP_EOL;
        $resetPassC .= "    # user_email exist check".PHP_EOL;
        $resetPassC .= "    if(empty(".$var."input['user_email'])) {".PHP_EOL;
        $resetPassC .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'user_email is a mandatory field'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
        $resetPassC .= "    }".PHP_EOL.PHP_EOL;
        $resetPassC .= "    # new_password exist check".PHP_EOL;
        $resetPassC .= "    if(empty(".$var."input['new_password'])) {".PHP_EOL;
        $resetPassC .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'new_password is a mandatory field'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
        $resetPassC .= "    }".PHP_EOL.PHP_EOL;
        $resetPassC .= "    # repeat_password exist check".PHP_EOL;
        $resetPassC .= "    if(empty(".$var."input['repeat_password'])) {".PHP_EOL;
        $resetPassC .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'repeat_password is a mandatory field'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
        $resetPassC .= "    }".PHP_EOL.PHP_EOL;
        $resetPassC .= "    # make sure new_password & repeat_password are same".PHP_EOL;
        $resetPassC .= "      if(".$var."input['new_password'] !== ".$var."input['repeat_password']) {".PHP_EOL;
        $resetPassC .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'passwords do not match'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
        $resetPassC .= "    }".PHP_EOL.PHP_EOL;
        $resetPassC .= "    # Send request to model - returns an array".PHP_EOL;
        $resetPassC .= "    ".$var."result = ".$var."this->ResetPasswordModel->resetPassword(".$var."input);".PHP_EOL.PHP_EOL;
        $resetPassC .= "    # Set error message if found".PHP_EOL;
        $resetPassC .= "    if(isset(".$var."result['error'])) {".PHP_EOL;
        $resetPassC .= "      # NOT_FOUND (404) being the HTTP response code".PHP_EOL;
        $resetPassC .= "      ".$var."this->set_response(['status' => 'fail', 'code' => '0', 'message' => 'Failed To Reset Password!', 'details' => ".$var."result['error']], REST_Controller::HTTP_NOT_FOUND);".PHP_EOL;
        $resetPassC .= "    }".PHP_EOL.PHP_EOL;
        $resetPassC .= "    # Set (200) OK being the HTTP response code & return an array".PHP_EOL;
        $resetPassC .= "    ".$var."this->set_response(['status' => 'success', 'code' => '1', 'message' => 'Successfully password reset!', 'data' => ".$var."result['message']], REST_Controller::HTTP_CREATED);".PHP_EOL;
        $resetPassC .= "  }".PHP_EOL.PHP_EOL;
        $resetPassC .= "}";


        # Create Forgot Password Controller File & Copy Content
        file_put_contents($filePath, $resetPassC, FILE_APPEND | LOCK_EX);  

        return TRUE;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
/* *************************************************************************************************************** */
/*  ###  Create Logout Controller File For Project  ###                                                                            */
/* *************************************************************************************************************** */

    /**
     * NOTE : Create Logout Controller File
     *
     * @param   string      $filePath - File Path
     * 
     * @param   string      $projectName - Project Name
     * 
     * @return  true/false
     */
    public function createLogoutController($filePath, $projectName)
    {
        # Initialise Variables
        $var = "$";
        $var1 = '"';

        # Initialise Strings
        $logoutC = "";

        $logoutC .= "<?php".PHP_EOL;
        $logoutC .= "/** ".PHP_EOL;
        $logoutC .= " * LogoutController.php".PHP_EOL;
        $logoutC .= " *".PHP_EOL;
        $logoutC .= " * Generated with AutoGenCode v1.0.0".PHP_EOL;
        $logoutC .= " *".PHP_EOL;
        $logoutC .= " * @author      Pavan Kumar".PHP_EOL;
        $logoutC .= " * @contact     8520872771".PHP_EOL;
        $logoutC .= " * @mailId      en.pavankumar@gmail.com".PHP_EOL;
        $logoutC .= " * ".PHP_EOL;
        $logoutC .= " * @createdAt   ".date("Y-m-d h:i:s").PHP_EOL;
        $logoutC .= " * @project     ".$projectName.PHP_EOL;
        $logoutC .= " */".PHP_EOL;
        $logoutC .= "#########################################################################################".PHP_EOL.PHP_EOL;
        $logoutC .= "# No direct script access allowed".PHP_EOL;
        $logoutC .= "defined('BASEPATH') OR exit('No direct script access allowed');".PHP_EOL.PHP_EOL;
        $logoutC .= "# This can be removed if you use __autoload() in config.php OR use Modular Extensions".PHP_EOL;
        $logoutC .= "require APPPATH . 'libraries/REST_Controller.php';".PHP_EOL.PHP_EOL;
        $logoutC .= "/**".PHP_EOL;
        $logoutC .= " * Logout Controller".PHP_EOL;
        $logoutC .= " */".PHP_EOL;
        $logoutC .= "class LogoutController extends REST_Controller".PHP_EOL;
        $logoutC .= "{".PHP_EOL;
        $logoutC .= "  # Construct the parent class".PHP_EOL;
        $logoutC .= "  public function __construct() {".PHP_EOL;
        $logoutC .= "    parent::__construct();".PHP_EOL;
        $logoutC .= "    # Load model".PHP_EOL;
        $logoutC .= "    ".$var."this->load->model('auth/LogoutModel');".PHP_EOL;
        $logoutC .= "  }".PHP_EOL.PHP_EOL;
        $logoutC .= "  /**".PHP_EOL;
        $logoutC .= "   * Method : POST".PHP_EOL;
        $logoutC .= "   * Method Name : Logout".PHP_EOL;
        $logoutC .= "   * Description : Logout".PHP_EOL;
        $logoutC .= "   *  ".PHP_EOL;
        $logoutC .= "   * @return  array response".PHP_EOL;
        $logoutC .= "   */".PHP_EOL;
        $logoutC .= "  public function logout_get()".PHP_EOL;
        $logoutC .= "  {".PHP_EOL;
        $logoutC .= "    # Header Check - Content-Type : Application / Json".PHP_EOL;
        $logoutC .= "    if (!preg_match('/application\/json/i',(".$var."this->input->get_request_header('Content-Type') ?? ''))) {".PHP_EOL;
        $logoutC .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Bad Request', 'details'=>'Content-Type must be application-json'], REST_Controller::HTTP_BAD_REQUEST);".PHP_EOL;
        $logoutC .= "    }".PHP_EOL.PHP_EOL;
        $logoutC .= "    # Get Authorization Key & Token".PHP_EOL;
        $logoutC .= "    ".$var."authorization = ".$var."this->input->get_request_header('Authorization') ?? '';".PHP_EOL;
        $logoutC .= "    if(empty(".$var."authorization)) {".PHP_EOL;
        $logoutC .= "      return ".$var."this->set_response(['status'=>'fail', 'code'=>'0', 'message'=>'Un Authorized access!', 'data'=>'Authorization Token Is Missing!'], REST_Controller::HTTP_UNAUTHORIZED);".PHP_EOL;
        $logoutC .= "    }".PHP_EOL.PHP_EOL;  
        $logoutC .= "    # Verify Authentication & return only jwt-token".PHP_EOL;
        $logoutC .= "    ".$var."verify = (new LibraryModel())->verifyAuthentication(".$var."authorization);".PHP_EOL;
        $logoutC .= "    if(isset(".$var."verify['error'])) { // Code - 2 Indicates Authentication Failed".PHP_EOL;
        $logoutC .= "      # HTTP_UNAUTHORIZED (401) being the HTTP response code".PHP_EOL;
        $logoutC .= "      return ".$var."this->set_response(['status' => 'fail', 'code'=>'2', 'message'=>'Un Authorized access!', 'data' => ".$var."verify['error']], REST_Controller::HTTP_UNAUTHORIZED);".PHP_EOL; 
        $logoutC .= "    }".PHP_EOL.PHP_EOL;
        $logoutC .= "    # Send request to model - returns an array".PHP_EOL;
        $logoutC .= "    ".$var."result=".$var."this->LogoutModel->logout(".$var."verify['jwt_token']);".PHP_EOL.PHP_EOL;
        $logoutC .= "    # Set error message if found".PHP_EOL;
        $logoutC .= "    if(isset(".$var."result['error'])) {".PHP_EOL;
        $logoutC .= "      # NOT_FOUND (404) being the HTTP response code".PHP_EOL;
        $logoutC .= "      ".$var."this->set_response(['status' => 'fail', 'code' => '0', 'message' => ".$var."result['error']], REST_Controller::HTTP_NOT_FOUND);".PHP_EOL; 
        $logoutC .= "    }".PHP_EOL.PHP_EOL;
        $logoutC .= "    # Set (200) OK being the HTTP response code & return an array".PHP_EOL;
        $logoutC .= "    ".$var."this->set_response(['status' => 'success', 'code' => '1', 'message' => 'Successfully Logout!', 'data' => ".$var."result['message']], REST_Controller::HTTP_CREATED);".PHP_EOL;
        $logoutC .= "  }".PHP_EOL.PHP_EOL;
        $logoutC .= "}".PHP_EOL;

        # Create Logout Controller File & Copy Content
        file_put_contents($filePath, $logoutC.PHP_EOL, FILE_APPEND | LOCK_EX);

        return TRUE;
    }




















/* *************************************************************************************************************** */
/*  ###  Create Models For Each Table  ###                                                                       */
/* *************************************************************************************************************** */

    /**
     * NOTE : Create Models For Each Table
     *
     * @param   array     $tables - All Tables
     * 
     * @param   string    $modelsPath - Model Path
     * 
     * @param   object    $modelsFeature - Model Feature Data
     * 
     * @param   object    $authenticationFeature - Authentication Feature Data
     * 
     * @return  Boolean   True / False
     */
    public function createModels($tables, $modelsDirectory, $authModelsDirectory, object $modelsFeature, object $authenticationFeature, $projectName)
    {
        # Initialise Variables
        $var = "$";
        $var1 = '"';

        # Create models for each table
        foreach($tables as $table) {

            # Initialise String
            $model = "";

            # Initialize Variable
            $var = "$";

            # Table Name / Class Name
            $tableName = $this->convertToModelName($table->table_code);

            # Class Name / File Name / File Path
            $className = $tableName.'Model';
            $fileName = $tableName."Model.php";
            $filePath = $modelsDirectory.DIRECTORY_SEPARATOR.$fileName;
            
            # Models File Path
            $modelsFilePath = $modelsDirectory.DIRECTORY_SEPARATOR.$fileName;

            # Get Attributes For Particular Table
            $attributes =  Attribute::where('table_uuid',$table->uuid)->get();

            # Get Foreign Keys
            $foreignKeys = $this->getForeignKeyAttributes($table);

            # Get Primary Key
            $primaryKey = $this->getPrimaryKey($table);

            # Get Reference Key
            $referenceKey = $this->getReferenceKey($table);

            # Get Showable Columns
            $unHideAttributes = $this->getUnHideAttributes($table);

            /* ********************* */
            /*       MODELS Task     */
            /* ********************* */

            if($table->table_code === "users") {
                # If Authentication feature is enabled
                if($authenticationFeature->enable === "YES") {
                    # Model File Path
                    $authModelFilePath = $authModelsDirectory.DIRECTORY_SEPARATOR.$fileName;

                    # Open Php File
                    $model .= "<?php".PHP_EOL;
                    $model .= "/** ".PHP_EOL;
                    $model .= " * ".$fileName.PHP_EOL;
                    $model .= " *".PHP_EOL;
                    $model .= " * Generated with AutoGenCode v1.0.0".PHP_EOL;
                    $model .= " *".PHP_EOL;
                    $model .= " * @author      Pavan Kumar".PHP_EOL;
                    $model .= " * @contact     8520872771".PHP_EOL;
                    $model .= " * @mailId      en.pavankumar@gmail.com".PHP_EOL;
                    $model .= " *".PHP_EOL;
                    $model .= " * @createdAt   ".date("Y-m-d h:i:s").PHP_EOL;
                    $model .= " * @project     ".$projectName.PHP_EOL;
                    $model .= " */".PHP_EOL;
                    $model .= "#                                                                                                                 #".PHP_EOL;
                    $model .= "###################################################################################################################".PHP_EOL;
                    $model .= "#                                                                                                                 #".PHP_EOL.PHP_EOL;
                    $model .= "# No direct script access allowed".PHP_EOL;
                    $model .= "if(! defined('BASEPATH')) exit ('No direct script access allowed');".PHP_EOL.PHP_EOL;
                    # Open Class
                    $model .= "class ".$className." extends CI_Model".PHP_EOL;
                    $model .= "{".PHP_EOL;
                    $model .= "  # Construct the parent class".PHP_EOL;
                    $model .= "  public function __construct(){".PHP_EOL;
                    $model .= "      parent::__construct();".PHP_EOL;
                    $model .= "      ".$var."this->table = '".$table->table_code."';".PHP_EOL;
                    $model .= "      ".$var."this->load->model('LibraryModel');".PHP_EOL;
                    $model .= "  }".PHP_EOL.PHP_EOL;
                    $model .= "#                                                                                                                 #".PHP_EOL;
                    $model .= "###################################################################################################################".PHP_EOL;
                    $model .= "#                                                                                                                 #".PHP_EOL.PHP_EOL;
                    #
                    # Method 1 : Get Method
                    #
                    $model .= "  /**".PHP_EOL;
                    $model .= "   * Method Name : fetch".PHP_EOL;
                    $model .= "   * Description : fetch all records based on params".PHP_EOL;
                    $model .= "   * ".PHP_EOL;
                    $model .= "   * @param   array ".$var."params List of params".PHP_EOL;
                    $model .= "   * ".PHP_EOL;
                    $model .= "   * @"."return  array response".PHP_EOL;
                    $model .= "   */".PHP_EOL;
                    $model .= "  public function fetch(".$var."params)".PHP_EOL;
                    $model .= "  {".PHP_EOL;
                    if(count($foreignKeys) == 0) {
                        $model .= "    # Initialize array".PHP_EOL;
                        $model .= "    ".$var."result = [];".PHP_EOL.PHP_EOL;
                    }
                    # Query Builder
                    $model .= "    # Query builder".PHP_EOL;
                    $model .= "    ".$var."this->db->select('";
                    if(!empty($unHideAttributes)) {
                        foreach($unHideAttributes as $unHideAttribute) {
                            $model .= $unHideAttribute->attribute_code.",";
                        }
                        $model = substr($model, 0, -1);
                    } else {
                        $model .= "*";
                    }
                    $model .= "')->from(".$var."this->table);".PHP_EOL.PHP_EOL;
                    if(!empty($referenceKey)) {
                        $model .= "    # ".$referenceKey->attribute_code.PHP_EOL;
                        $model .= "    if(isset(".$var."params['".$referenceKey->attribute_code."']) && strlen(".$var."params['".$referenceKey->attribute_code."']) > 0) ".$var."this->db->where('".$referenceKey->attribute_code."', ".$var."params['".$referenceKey->attribute_code."']);".PHP_EOL.PHP_EOL;
                    } else {
                        if(!empty($primaryKey)) {
                            $model .= "    # ".$primaryKey->attribute_code.PHP_EOL;
                            $model .= "    if(isset(".$var."params['".$primaryKey->attribute_code."']) && strlen(".$var."params['".$primaryKey->attribute_code."']) > 0) ".$var."this->db->where('".$primaryKey->attribute_code."', ".$var."params['".$primaryKey->attribute_code."']);".PHP_EOL.PHP_EOL;
                        }
                    }
                    $model .= "    # Pagination".PHP_EOL;
                    $model .= "    if(isset(".$var."params['limit']) && isset(".$var."params['start']) && strlen(".$var."params['limit']) > 0 && strlen(".$var."params['start']) > 0) ".$var."this->db->limit(".$var."params['limit'], ".$var."params['start']);".PHP_EOL.PHP_EOL;
                    if(count($foreignKeys) > 0) {
                        $model .= "    # result query".PHP_EOL;
                        $model .= "    ".$var."query = ".$var."this->db->get()->result_array();".PHP_EOL.PHP_EOL;
                        $model .= "    # Initialize array".PHP_EOL;
                        $model .= "    ".$var."data = [];".PHP_EOL.PHP_EOL;
                        $model .= "    # foreach all records".PHP_EOL;
                        $model .= "    foreach(".$var."query as ".$var."item) {".PHP_EOL;
                        foreach($foreignKeys as $foreignKey) {
                            $thisTablePrimaryKey = $this->getPrimaryKey($foreignKey->table_info);
                            $thisTableReferenceKey = $this->getReferenceKey($foreignKey->table_info);
                            $thisUnHideAttributes = $this->getUnHideAttributes($foreignKey->table_info);
                            if(empty($thisTableReferenceKey)) {
                                $model .= "      # fetch ".$foreignKey->table_info->table_code." data".PHP_EOL;
                                $model .= "      if(strlen(".$var."item['".$foreignKey->attribute_code."']) > 0)".PHP_EOL;
                                $model .= "        ".$var."item['".$foreignKey->table_info->table_code."'] = ".$var."this->db->select('";
                                if(!empty($thisUnHideAttributes)) {
                                    foreach($thisUnHideAttributes as $thisUnHideAttribute) {
                                        $model .= $thisUnHideAttribute->attribute_code.",";
                                    }
                                    $model = substr($model, 0, -1);
                                } else {
                                    $model .= "*";
                                }
                                $model .= "')->from('".$foreignKey->table_info->table_code."')->where('".$thisTablePrimaryKey->attribute_code."', ".$var."item['".$foreignKey->attribute_code."'])->get()->row_array() ?? [];".PHP_EOL.PHP_EOL;
                            } else {
                                $model .= "      # fetch ".$foreignKey->table_info->table_code." data".PHP_EOL;
                                $model .= "      if(strlen(".$var."item['".$foreignKey->attribute_code."']) > 0)".PHP_EOL;
                                $model .= "        ".$var."item['".$foreignKey->table_info->table_code."'] = ".$var."this->db->select('";
                                if(!empty($thisUnHideAttributes)) {
                                    foreach($thisUnHideAttributes as $thisUnHideAttribute) {
                                        $model .= $thisUnHideAttribute->attribute_code.",";
                                    }
                                    $model = substr($model, 0, -1);
                                } else {
                                    $model .= "*";
                                }
                                $model .= "')->from('".$foreignKey->table_info->table_code."')->where('".$thisTableReferenceKey->attribute_code."', ".$var."item['".$foreignKey->attribute_code."'])->get()->row_array() ?? [];".PHP_EOL.PHP_EOL;
                            }
                        }
                        $model .= "      ".$var."data[] = ".$var."item;".PHP_EOL;
                        $model .= "    }".PHP_EOL.PHP_EOL;
                        $model .= "    # Return result".PHP_EOL;
                        $model .= "    return ".$var."data;".PHP_EOL;
                    } else {
                        $model .= "    # result".PHP_EOL;
                        $model .= "    ".$var."result = ".$var."this->db->get()->result_array();".PHP_EOL.PHP_EOL;
                        $model .= "    # Return result".PHP_EOL;
                        $model .= "    return ".$var."result;".PHP_EOL;
                    }
                    $model .= "  }".PHP_EOL.PHP_EOL;
                    $model .= "#                                                                                                                 #".PHP_EOL;
                    $model .= "###################################################################################################################".PHP_EOL;
                    $model .= "#                                                                                                                 #".PHP_EOL.PHP_EOL;
                    #
                    # Method 2 : Update Method
                    #
                    $model .= "  /**".PHP_EOL;
                    $model .= "   * Method Name : update".PHP_EOL;
                    $model .= "   * Description : update a existing record".PHP_EOL;
                    $model .= "   * ".PHP_EOL;
                    $model .= "   * @param  array  ".$var."input".PHP_EOL;
                    $model .= "   * ".PHP_EOL;
                    $model .= "   * @param  array  ".$var."user".PHP_EOL;
                    $model .= "   * ".PHP_EOL;
                    $model .= "   * @"."return  array response".PHP_EOL;
                    $model .= "   */".PHP_EOL;
                    $model .= "  public function update(array ".$var."input, array ".$var."user)".PHP_EOL;
                    $model .= "  {".PHP_EOL;
                    $model .= "    # Initialize array".PHP_EOL;
                    $model .= "    ".$var."result = [];".PHP_EOL.PHP_EOL;
                    $model .= "    # Create array".PHP_EOL;
                    $model .= "    ".$var."data=array(".PHP_EOL;
                    if(!empty($attributes)) {
                        foreach($attributes as $attribute) {
                            if($attribute->attribute_index === "PRIMARY" || $attribute->attribute_autoincrement === "1" || $attribute->attribute_autoincrement === "on" || json_decode($attribute->attribute_inputtype)->key === "HIDE") {
                                continue;
                            } else {
                                # UUID
                                if(json_decode($attribute->attribute_inputtype)->key === "REFERENCE_KEY_UUID" || json_decode($attribute->attribute_inputtype)->key === "REFERENCE_KEY" || json_decode($attribute->attribute_inputtype)->key === "UUID") {
                                    continue;
                                }
                                # Current Date
                                if(json_decode($attribute->attribute_inputtype)->key === "CURRENT_DATE") {
                                    continue;
                                }
                                # Current Date Time
                                if(json_decode($attribute->attribute_inputtype)->key === "CURRENT_DATETIME") {
                                    continue;
                                }
                                # Current Date Time
                                if(json_decode($attribute->attribute_inputtype)->key === "CURRENT_DATE") {
                                    continue;
                                }
                                $model .= "      '".$attribute->attribute_code."'=>".$var."input['".$attribute->attribute_code."'],".PHP_EOL;
                            }
                        }
                        $model = substr($model, 0, -3);
                    }
                    $model .= PHP_EOL;
                    $model .= "    );".PHP_EOL.PHP_EOL;
                    $model .= "    # Update data".PHP_EOL;
                    if(!empty($referenceKey)) {
                        $model .= "    ".$var."update = ".$var."this->db->where('".$referenceKey->attribute_code."',".$var."user['".$referenceKey->attribute_code."'])->update('".$table->table_code."',".$var."data);".PHP_EOL;
                    } else {
                        if(!empty($primaryKey)) {
                            $model .= "    ".$var."update = ".$var."this->db->where('".$primaryKey->attribute_code."',".$var."user['".$primaryKey->attribute_code."'])->update('".$table->table_code."',".$var."data);".PHP_EOL;
                        }
                    }
                    $model .= "    if(!".$var."update) {".PHP_EOL;
                    $model .= "      ".$var."result['error'] = ".$var1."Failed To Update Record".$var1.";".PHP_EOL;
                    $model .= "      return ".$var."result;".PHP_EOL;
                    $model .= "    }".PHP_EOL.PHP_EOL;
                    $model .= "    # Get updated Data".PHP_EOL;
                    if(!empty($referenceKey)) {
                        $model .= "    ".$var."result = ".$var."this->fetch(['".$var.$referenceKey->attribute_code."'=>".$var."user['".$referenceKey->attribute_code."']]);".PHP_EOL.PHP_EOL;
                    } else {
                        if(!empty($primaryKey)) {
                            $model .= "    ".$var."result = ".$var."this->fetch(['".$var.$primaryKey->attribute_code."'=>".$var."user['".$primaryKey->attribute_code."']]);".PHP_EOL.PHP_EOL;
                        }
                    }
                    $model .= "    # Return result".PHP_EOL;
                    $model .= "    return ".$var."result;".PHP_EOL;
                    $model .= "  }".PHP_EOL.PHP_EOL;
                    $model .= "#                                                                                                                 #".PHP_EOL;
                    $model .= "###################################################################################################################".PHP_EOL;
                    $model .= "#                                                                                                                 #".PHP_EOL.PHP_EOL;
                    # Method 3 : Delete Method
                    $model .= "  /**".PHP_EOL;
                    $model .= "   * Method Name : delete".PHP_EOL;
                    $model .= "   * Description : delete a record".PHP_EOL;
                    $model .= "   * ".PHP_EOL;
                    $model .= "   * @param  array  ".$var."user".PHP_EOL;
                    $model .= "   * ".PHP_EOL;
                    $model .= "   * @"."return  boolean True / False".PHP_EOL;
                    $model .= "   */".PHP_EOL;
                    $model .= "  public function delete(array ".$var."user)".PHP_EOL;
                    $model .= "  {".PHP_EOL;
                    $model .= "    # Initialize variable with false result".PHP_EOL;
                    $model .= "    ".$var."result = FALSE;".PHP_EOL.PHP_EOL;
                    $model .= "    # Delete data".PHP_EOL;
                    if(!empty($referenceKey)) {
                        $model .= "    ".$var."delete = ".$var."this->db->delete('".$table->table_code."', ['".$referenceKey->attribute_code."' => ".$var."user['".$referenceKey->attribute_code."']]);".PHP_EOL;
                    } else {
                        if(!empty($primaryKey)) {
                            $model .= "    ".$var."delete = ".$var."this->db->delete('".$table->table_code."', ['".$primaryKey->attribute_code."' => ".$var."user['".$primaryKey->attribute_code."']]);".PHP_EOL;
                        }
                    }
                    $model .= "    if(!".$var."delete) {".PHP_EOL;
                    $model .= "      ".$var."result = FALSE;".PHP_EOL;
                    $model .= "    } else {".PHP_EOL;
                    $model .= "      ".$var."result = TRUE;".PHP_EOL;
                    $model .= "    }".PHP_EOL.PHP_EOL;
                    $model .= "    # return result;".PHP_EOL;
                    $model .= "    return ".$var."result;".PHP_EOL;
                    $model .= "  }".PHP_EOL.PHP_EOL;
                    $model .= "}".PHP_EOL;
                    $model .= "?>".PHP_EOL;

                    # Create Controllers File & Copy Content
                    file_put_contents($authModelFilePath, $model, FILE_APPEND | LOCK_EX);
                    unset($authModelFilePath);
                    unset($model);

                    continue;
                }
            }

            if($modelsFeature->enable === "YES") 
            {
                # Open Php File
                $model .= "<?php".PHP_EOL;
                $model .= "/** ".PHP_EOL;
                $model .= " * ".$fileName.PHP_EOL;
                $model .= " *".PHP_EOL;
                $model .= " * Generated with AutoGenCode v1.0.0".PHP_EOL;
                $model .= " *".PHP_EOL;
                $model .= " * @author      Pavan Kumar".PHP_EOL;
                $model .= " * @contact     8520872771".PHP_EOL;
                $model .= " * @mailId      en.pavankumar@gmail.com".PHP_EOL;
                $model .= " *".PHP_EOL;
                $model .= " * @createdAt   ".date("Y-m-d h:i:s").PHP_EOL;
                $model .= " * @project     ".$projectName.PHP_EOL;
                $model .= " */".PHP_EOL;
                $model .= "#                                                                                                                 #".PHP_EOL;
                $model .= "###################################################################################################################".PHP_EOL;
                $model .= "#                                                                                                                 #".PHP_EOL.PHP_EOL;
                $model .= "/** ".PHP_EOL;
                $model .= " * Table Name / Column Name & Their DataTypes".PHP_EOL;
                $model .= " *".PHP_EOL;
                $model .= " * Table Name : ".$table->table_code.PHP_EOL;
                $model .= " *".PHP_EOL;
                foreach($attributes as $attribute) {
                    $model .= " * ".$attribute->attribute_code." (".$attribute->attribute_datatype.")".PHP_EOL;
                }
                $model .= " */".PHP_EOL;
                $model .= "#                                                                                                                 #".PHP_EOL;
                $model .= "###################################################################################################################".PHP_EOL;
                $model .= "#                                                                                                                 #".PHP_EOL.PHP_EOL;
                $model .= "# No direct script access allowed".PHP_EOL;
                $model .= "if(! defined('BASEPATH')) exit ('No direct script access allowed');".PHP_EOL.PHP_EOL;
                # Open Class
                $model .= "class ".$className." extends CI_Model".PHP_EOL;
                $model .= "{".PHP_EOL;
                $model .= "  # Construct the parent class".PHP_EOL;
                $model .= "  public function __construct(){".PHP_EOL;
                $model .= "      parent::__construct();".PHP_EOL;
                $model .= "      ".$var."this->table = '".$table->table_code."';".PHP_EOL;
                foreach($foreignKeys as $foreignKey) {
                    # Table Name / Class Name
                    $foreignKeyModel = $this->convertToModelName($foreignKey->table_info->table_code);
                    $model .= "      ".$var."this->load->model('".$foreignKeyModel."Model');".PHP_EOL;
                }
                $model .= "      ".$var."this->load->model('LibraryModel');".PHP_EOL;
                $model .= "  }".PHP_EOL.PHP_EOL;
                $model .= "#                                                                                                                 #".PHP_EOL;
                $model .= "###################################################################################################################".PHP_EOL;
                $model .= "#                                                                                                                 #".PHP_EOL.PHP_EOL;
                #
                # Method 1 : Get Method
                #
                $model .= "  /**".PHP_EOL;
                $model .= "   * Method Name : fetch".PHP_EOL;
                $model .= "   * Description : fetch all records based on params".PHP_EOL;
                $model .= "   * ".PHP_EOL;
                $model .= "   * @param   array ".$var."params List of params".PHP_EOL;
                $model .= "   * ".PHP_EOL;
                $model .= "   * @"."return  array response".PHP_EOL;
                $model .= "   */".PHP_EOL;
                $model .= "  public function fetch(".$var."params)".PHP_EOL;
                $model .= "  {".PHP_EOL;
                if(count($foreignKeys) == 0) {
                    $model .= "    # Initialize array".PHP_EOL;
                    $model .= "    ".$var."result = [];".PHP_EOL.PHP_EOL;
                }
                # Query Builder
                $model .= "    # Query builder".PHP_EOL;
                $model .= "    ".$var."this->db->select('";
                if(!empty($unHideAttributes)) {
                    foreach($unHideAttributes as $unHideAttribute) {
                        $model .= $unHideAttribute->attribute_code.",";
                    }
                    $model = substr($model, 0, -1);
                } else {
                    $model .= "*";
                }
                $model .= "')->from(".$var."this->table);".PHP_EOL.PHP_EOL;
                if(!empty($primaryKey)) {
                    $model .= "    # ".$primaryKey->attribute_code.PHP_EOL;
                    $model .= "    if(isset(".$var."params['".$primaryKey->attribute_code."']) && strlen(".$var."params['".$primaryKey->attribute_code."']) > 0) ".$var."this->db->where('".$primaryKey->attribute_code."', ".$var."params['".$primaryKey->attribute_code."']);".PHP_EOL.PHP_EOL;
                }
                if(!empty($referenceKey)) {
                    $model .= "    # ".$referenceKey->attribute_code.PHP_EOL;
                    $model .= "    if(isset(".$var."params['".$referenceKey->attribute_code."']) && strlen(".$var."params['".$referenceKey->attribute_code."']) > 0) ".$var."this->db->where('".$referenceKey->attribute_code."', ".$var."params['".$referenceKey->attribute_code."']);".PHP_EOL.PHP_EOL;
                }
                if(count($foreignKeys) > 0) {
                    foreach($foreignKeys as $foreignKey) {
                        $model .= "    # ".$foreignKey->attribute_code.PHP_EOL;
                        $model .= "    if(isset(".$var."params['".$foreignKey->attribute_code."']) && strlen(".$var."params['".$foreignKey->attribute_code."']) > 0) ".$var."this->db->where('".$foreignKey->attribute_code."', ".$var."params['".$foreignKey->attribute_code."']);".PHP_EOL.PHP_EOL;
                    }
                }
                $model .= "    # Pagination".PHP_EOL;
                $model .= "    if(isset(".$var."params['limit']) && isset(".$var."params['start']) && strlen(".$var."params['limit']) > 0 && strlen(".$var."params['start']) > 0) ".$var."this->db->limit(".$var."params['limit'], ".$var."params['start']);".PHP_EOL.PHP_EOL;
                if(count($foreignKeys) > 0) {
                    $model .= "    # result query".PHP_EOL;
                    $model .= "    ".$var."query = ".$var."this->db->get()->result_array();".PHP_EOL.PHP_EOL;
                    $model .= "    # Initialize array".PHP_EOL;
                    $model .= "    ".$var."data = [];".PHP_EOL.PHP_EOL;
                    $model .= "    # foreach all records".PHP_EOL;
                    $model .= "    foreach(".$var."query as ".$var."item) {".PHP_EOL;
                    foreach($foreignKeys as $foreignKey) {
                        $thisTablePrimaryKey = $this->getPrimaryKey($foreignKey->table_info);
                        $thisTableReferenceKey = $this->getReferenceKey($foreignKey->table_info);
                        $thisUnHideAttributes = $this->getUnHideAttributes($foreignKey->table_info);
                        if(empty($thisTableReferenceKey)) {
                            $model .= "      # fetch ".$foreignKey->table_info->table_code." data".PHP_EOL;
                            $model .= "      if(strlen(".$var."item['".$foreignKey->attribute_code."']) > 0)".PHP_EOL;
                            # Table Name / Class Name
                            $foreignKeyModel = $this->convertToModelName($foreignKey->table_info->table_code);
                            $model .= "        ".$var."item['".$foreignKey->table_info->table_code."'] = (new ".$foreignKeyModel."Model())->fetch(['".$thisTablePrimaryKey->attribute_code."'=>".$var."item['".$foreignKey->attribute_code."']]) ?? [];".PHP_EOL.PHP_EOL;
                        } else {
                            $model .= "      # fetch ".$foreignKey->table_info->table_code." data".PHP_EOL;
                            $model .= "      if(strlen(".$var."item['_".$foreignKey->attribute_code."']) > 0)".PHP_EOL;
                            # Table Name / Class Name
                            $foreignKeyModel = $this->convertToModelName($foreignKey->table_info->table_code);
                            $model .= "        ".$var."item['".$foreignKey->table_info->table_code."'] = (new ".$foreignKeyModel."Model())->fetch(['".$thisTableReferenceKey->attribute_code."'=>".$var."item['".$foreignKey->attribute_code."']]) ?? [];".PHP_EOL.PHP_EOL;
                        }
                    }
                    $model .= "      ".$var."data[] = ".$var."item;".PHP_EOL;
                    $model .= "    }".PHP_EOL.PHP_EOL;
                    $model .= "    # Return result".PHP_EOL;
                    $model .= "    return ".$var."data;".PHP_EOL;
                } else {
                    $model .= "    # result".PHP_EOL;
                    $model .= "    ".$var."result = ".$var."this->db->get()->result_array();".PHP_EOL.PHP_EOL;
                    $model .= "    # Return result".PHP_EOL;
                    $model .= "    return ".$var."result;".PHP_EOL;
                }
                $model .= "  }".PHP_EOL.PHP_EOL;
                $model .= "#                                                                                                                 #".PHP_EOL;
                $model .= "###################################################################################################################".PHP_EOL;
                $model .= "#                                                                                                                 #".PHP_EOL.PHP_EOL;
                # Method 2 : Post Method
                $model .= "  /**".PHP_EOL;
                $model .= "   * Method Name : create".PHP_EOL;
                $model .= "   * Description : create a new record".PHP_EOL;
                $model .= "   * ".PHP_EOL;
                $model .= "   * @param   array ".$var."input post body".PHP_EOL;
                $model .= "   * ".PHP_EOL;
                $model .= "   * @"."return  array response".PHP_EOL;
                $model .= "   */".PHP_EOL;
                $model .= "  public function create(array ".$var."input)".PHP_EOL;
                $model .= "  {".PHP_EOL;
                $model .= "    # Create array".PHP_EOL;
                $model .= "    ".$var."data=array(".PHP_EOL;
                if(!empty($attributes)) {
                    foreach($attributes as $attribute) {
                        if($attribute->attribute_index === "PRIMARY" || $attribute->attribute_autoincrement === "1" || $attribute->attribute_autoincrement === "on") {
                            continue;
                        } else {
                            # UUID
                            if(json_decode($attribute->attribute_inputtype)->key === "REFERENCE_KEY_UUID" || json_decode($attribute->attribute_inputtype)->key === "UUID") {
                                $model .= "      '".$attribute->attribute_code."'=>".$var."this->LibraryModel->UUID(),".PHP_EOL;
                                continue;
                            }
                            # Current Date
                            if(json_decode($attribute->attribute_inputtype)->key === "CURRENT_DATE") {
                                $model .= "      '".$attribute->attribute_code."'=>".$var."date('Y-m-d'),".PHP_EOL;
                                continue;
                            }
                            # Current Date Time
                            if(json_decode($attribute->attribute_inputtype)->key === "CURRENT_DATETIME") {
                                $model .= "      '".$attribute->attribute_code."'=>date('Y-m-d H:i:s'),".PHP_EOL;
                                continue;
                            }
                            # Current Date Time
                            if(json_decode($attribute->attribute_inputtype)->key === "CURRENT_DATE") {
                                $model .= "      '".$attribute->attribute_code."'=>date(".$var1."Y-m-d H:i:s A".$var1.", time()),".PHP_EOL;
                                continue;
                            }
                            $model .= "      '".$attribute->attribute_code."'=>".$var."input['".$attribute->attribute_code."'],".PHP_EOL;
                        }
                    }
                    $model = substr($model, 0, -3);
                }
                $model .= PHP_EOL;
                $model .= "    );".PHP_EOL.PHP_EOL;
                $model .= "    # Initialize array".PHP_EOL;
                $model .= "    ".$var."result = [];".PHP_EOL.PHP_EOL;
                $model .= "    # Insert record".PHP_EOL;
                $model .= "    ".$var."insert = ".$var."this->db->insert('".$table->table_code."',".$var."data);".PHP_EOL;
                $model .= "    if(".$var."insert) {".PHP_EOL;
                $model .= "      ".$var."insertedId = ".$var."this->db->insert_id();".PHP_EOL;
                if(!empty($primaryKey)) {
                    $model .= "      ".$var."result = ".$var."this->fetch(['".$primaryKey->attribute_code."' => ".$var."insertedId]);".PHP_EOL;
                } else {
                    $model .= "      ".$var."result = 'Successfully Added A New Record';".PHP_EOL;
                    $model .= "      return ".$var."result;".PHP_EOL;
                }
                $model .= "    } else {".PHP_EOL;
                $model .= "      ".$var."result['error'] = 'Failed To Add New Record';".PHP_EOL;
                $model .= "      return ".$var."result;".PHP_EOL;
                $model .= "    }".PHP_EOL.PHP_EOL;
                $model .= "    # Return result".PHP_EOL;
                $model .= "    return ".$var."result;".PHP_EOL;
                $model .= "  }".PHP_EOL.PHP_EOL;
                $model .= "#                                                                                                                 #".PHP_EOL;
                $model .= "###################################################################################################################".PHP_EOL;
                $model .= "#                                                                                                                 #".PHP_EOL.PHP_EOL;
                # Method 3 : Update Method
                $model .= "  /**".PHP_EOL;
                $model .= "   * Method Name : update".PHP_EOL;
                $model .= "   * Description : update a existing record".PHP_EOL;
                $model .= "   * ".PHP_EOL;
                if(!empty($referenceKey)) {
                    $datatype = "";
                    if($referenceKey->attribute_datatype === "VARCHAR") $datatype = "string";
                    if($referenceKey->attribute_datatype === "INT") $datatype = "int";
                    $model .= "   * @"."param  ".$datatype." ( ".$var.$referenceKey->attribute_code." )".PHP_EOL;
                } else {
                    if(!empty($primaryKey)) {
                        $datatype = "";
                        if($primaryKey->attribute_datatype === "VARCHAR") $datatype = "string";
                        if($primaryKey->attribute_datatype === "INT") $datatype = "int";
                        $model .= "   * @"."param  ".$datatype." ( ".$var.$primaryKey->attribute_code." )".PHP_EOL;
                    }
                }
                $model .= "   * ".PHP_EOL;
                $model .= "   * @param  array  ".$var."input post body".PHP_EOL;
                $model .= "   * ".PHP_EOL;
                $model .= "   * @"."return  array response".PHP_EOL;
                $model .= "   */".PHP_EOL;
                if(!empty($referenceKey)) {
                    $datatype = "";
                    if($referenceKey->attribute_datatype === "VARCHAR") $datatype = "string";
                    if($referenceKey->attribute_datatype === "INT") $datatype = "int";
                    $model .= "  public function update(".$datatype." ".$var.$referenceKey->attribute_code.", array ".$var."input)".PHP_EOL;
                } else {
                    if(!empty($primaryKey)) {
                        $datatype = "";
                        if($primaryKey->attribute_datatype === "VARCHAR") $datatype = "string";
                        if($primaryKey->attribute_datatype === "INT") $datatype = "int";
                        $model .= "  public function update(".$datatype." ".$var.$primaryKey->attribute_code.", array ".$var."input)".PHP_EOL;
                    }
                }
                $model .= "  {".PHP_EOL;
                $model .= "    # Initialize array".PHP_EOL;
                $model .= "    ".$var."result = [];".PHP_EOL.PHP_EOL;
                $model .= "    # Get entity".PHP_EOL;
                if(!empty($referenceKey)) {
                    $model .= "    ".$var."entity = ".$var."this->fetch(['".$referenceKey->attribute_code."'=>".$var.$referenceKey->attribute_code."]);".PHP_EOL;
                } else {
                    if(!empty($primaryKey)) {
                        $model .= "    ".$var."entity = ".$var."this->fetch(['".$primaryKey->attribute_code."'=>".$var.$primaryKey->attribute_code."]);".PHP_EOL;
                    }
                }
                $model .= "    if(empty(".$var."entity)) {".PHP_EOL;
                if(!empty($referenceKey)) {
                    $model .= "      ".$var."result['error'] = ".$var1."No Record Found With This ".$referenceKey->attribute_code.$var1.";".PHP_EOL;
                } else {
                    if(!empty($primaryKey)) {
                        $model .= "      ".$var."result['error'] = ".$var1."No Record Found With This ".$primaryKey->attribute_code.$var1.";".PHP_EOL;
                    }
                }
                $model .= "    }".PHP_EOL.PHP_EOL;
                $model .= "    # Create array".PHP_EOL;
                $model .= "    ".$var."data=array(".PHP_EOL;
                if(!empty($attributes)) {
                    foreach($attributes as $attribute) {
                        if($attribute->attribute_index === "PRIMARY" || $attribute->attribute_autoincrement === "1" || $attribute->attribute_autoincrement === "on") {
                            continue;
                        } else {
                            # UUID
                            if(json_decode($attribute->attribute_inputtype)->key === "REFERENCE_KEY_UUID" || json_decode($attribute->attribute_inputtype)->key === "UUID") {
                                continue;
                            }
                            # Current Date
                            if(json_decode($attribute->attribute_inputtype)->key === "CURRENT_DATE") {
                                continue;
                            }
                            # Current Date Time
                            if(json_decode($attribute->attribute_inputtype)->key === "CURRENT_DATETIME") {
                                continue;
                            }
                            # Current Date Time
                            if(json_decode($attribute->attribute_inputtype)->key === "CURRENT_DATE") {
                                continue;
                            }
                            $model .= "      '".$attribute->attribute_code."'=>".$var."input['".$attribute->attribute_code."'],".PHP_EOL;
                        }
                    }
                    $model = substr($model, 0, -3);
                }
                $model .= PHP_EOL;
                $model .= "    );".PHP_EOL.PHP_EOL;
                $model .= "    # Update data".PHP_EOL;
                if(!empty($referenceKey)) {
                    $model .= "    ".$var."update = ".$var."this->db->where('".$referenceKey->attribute_code."',".$var.$referenceKey->attribute_code.")->update('".$table->table_code."',".$var."data);".PHP_EOL;
                } else {
                    if(!empty($primaryKey)) {
                        $model .= "    ".$var."update = ".$var."this->db->where('".$primaryKey->attribute_code."',".$var.$primaryKey->attribute_code.")->update('".$table->table_code."',".$var."data);".PHP_EOL;
                    }
                }
                $model .= "    if(!".$var."update) {".PHP_EOL;
                $model .= "      ".$var."result['error'] = ".$var1."Failed To Update Record".$var1.";".PHP_EOL;
                $model .= "      return ".$var."result;".PHP_EOL;
                $model .= "    }".PHP_EOL.PHP_EOL;
                $model .= "    # Get updated Data".PHP_EOL;
                if(!empty($referenceKey)) {
                    $model .= "    ".$var."result = ".$var."this->fetch(['".$referenceKey->attribute_code."'=>".$var.$referenceKey->attribute_code."]);".PHP_EOL.PHP_EOL;
                } else {
                    if(!empty($primaryKey)) {
                        $model .= "    ".$var."result = ".$var."this->fetch(['".$primaryKey->attribute_code."'=>".$var.$primaryKey->attribute_code."]);".PHP_EOL.PHP_EOL;
                    }
                }
                $model .= "    return ".$var."result;".PHP_EOL;
                $model .= "  }".PHP_EOL.PHP_EOL;
                $model .= "#                                                                                                                 #".PHP_EOL;
                $model .= "###################################################################################################################".PHP_EOL;
                $model .= "#                                                                                                                 #".PHP_EOL.PHP_EOL;
                # Method 4 : Delete Method
                $model .= "  /**".PHP_EOL;
                $model .= "   * Method Name : delete".PHP_EOL;
                $model .= "   * Description : delete a record".PHP_EOL;
                $model .= "   * ".PHP_EOL;
                if(!empty($referenceKey)) {
                    $datatype = "";
                    if($referenceKey->attribute_datatype === "VARCHAR") $datatype = "string";
                    if($referenceKey->attribute_datatype === "INT") $datatype = "int";
                    $model .= "   * @"."param  ".$datatype." ( ".$var.$referenceKey->attribute_code." )".PHP_EOL;
                } else {
                    if(!empty($primaryKey)) {
                        $datatype = "";
                        if($primaryKey->attribute_datatype === "VARCHAR") $datatype = "string";
                        if($primaryKey->attribute_datatype === "INT") $datatype = "int";
                        $model .= "   * @"."param  ".$datatype." ( ".$var.$primaryKey->attribute_code." )".PHP_EOL;
                    }
                }
                $model .= "   * ".PHP_EOL;
                $model .= "   * @"."return  boolean True / False".PHP_EOL;
                $model .= "   */".PHP_EOL;
                if(!empty($referenceKey)) {
                    $datatype = "";
                    if($referenceKey->attribute_datatype === "VARCHAR") $datatype = "string";
                    if($referenceKey->attribute_datatype === "INT") $datatype = "int";
                    $model .= "  public function delete(".$datatype." ".$var.$referenceKey->attribute_code.")".PHP_EOL;
                } else {
                    if(!empty($primaryKey)) {
                        $datatype = "";
                        if($primaryKey->attribute_datatype === "VARCHAR") $datatype = "string";
                        if($primaryKey->attribute_datatype === "INT") $datatype = "int";
                        $model .= "  public function delete(".$datatype." ".$var.$primaryKey->attribute_code.")".PHP_EOL;
                    }
                }
                $model .= "  {".PHP_EOL;
                if(!empty($referenceKey)) {
                    $model .= "    # Check ".$referenceKey->attribute_code." exist".PHP_EOL;
                    $model .= "    ".$var."fetchId = ".$var."this->fetch(['".$referenceKey->attribute_code."', ".$var.$referenceKey->attribute_code."]);".PHP_EOL;
                } else {
                    if(!empty($primaryKey)) {
                        $model .= "    # Check ".$primaryKey->attribute_code." exist".PHP_EOL;
                        $model .= "    ".$var."fetchId = ".$var."this->fetch(['".$primaryKey->attribute_code."', ".$var.$primaryKey->attribute_code."]);".PHP_EOL;
                    }
                }
                $model .= "    if(empty(".$var."fetchId)) {".PHP_EOL;
                if(!empty($referenceKey)) {
                    $model .= "      ".$var."result['error'] = ".$var1."No Record Found With This ".$referenceKey->attribute_code.$var1.";".PHP_EOL;
                } else {
                    if(!empty($primaryKey)) {
                        $model .= "      ".$var."result['error'] = ".$var1."No Record Found With This ".$primaryKey->attribute_code.$var1.";".PHP_EOL;
                    }
                }
                $model .= "      return ".$var."result;".PHP_EOL;
                $model .= "    }".PHP_EOL.PHP_EOL;
                $model .= "    # Initialize variable with false result".PHP_EOL;
                $model .= "    ".$var."result = FALSE;".PHP_EOL.PHP_EOL;
                $model .= "    # Delete data".PHP_EOL;
                if(!empty($referenceKey)) {
                    $model .= "    ".$var."delete = ".$var."this->db->delete('".$table->table_code."', ['".$referenceKey->attribute_code."' => ".$var.$referenceKey->attribute_code."]);".PHP_EOL;
                } else {
                    if(!empty($primaryKey)) {
                        $model .= "    ".$var."delete = ".$var."this->db->delete('".$table->table_code."', ['".$primaryKey->attribute_code."' => ".$var.$primaryKey->attribute_code."]);".PHP_EOL;
                    }
                }
                $model .= "    if(".$var."delete) {".PHP_EOL;
                $model .= "      ".$var."result = TRUE;".PHP_EOL;
                $model .= "    }".PHP_EOL.PHP_EOL;
                $model .= "    # return result;".PHP_EOL;
                $model .= "    return ".$var."result;".PHP_EOL;
                $model .= "  }".PHP_EOL.PHP_EOL;
                $model .= "#                                                                                                                 #".PHP_EOL;
                $model .= "###################################################################################################################".PHP_EOL;
                $model .= "#                                                                                                                 #".PHP_EOL.PHP_EOL;
                # Method 5 : Search Method
                $model .= "  /**".PHP_EOL;
                $model .= "   * Method Name : search".PHP_EOL;
                $model .= "   * Description : fetch all records based on search data".PHP_EOL;
                $model .= "   * ".PHP_EOL;
                $model .= "   * @"."param  string ".$var."search".PHP_EOL;
                $model .= "   * ".PHP_EOL;
                $model .= "   * @"."return  array response".PHP_EOL;
                $model .= "   */".PHP_EOL;
                $model .= "  public function search(string ".$var."search)".PHP_EOL;
                $model .= "  {".PHP_EOL;
                if(count($foreignKeys) == 0) {
                    $model .= "    # Initialize array".PHP_EOL;
                    $model .= "    ".$var."result = [];".PHP_EOL.PHP_EOL;
                }
                # Query Builder
                $model .= "    # Query builder".PHP_EOL;
                $model .= "    ".$var."this->db->select('";
                if(!empty($unHideAttributes)) {
                    foreach($unHideAttributes as $unHideAttribute) {
                        $model .= $unHideAttribute->attribute_code.",";
                    }
                    $model = substr($model, 0, -1);
                } else {
                    $model .= "*";
                }
                $model .= "')->from(".$var."this->table);".PHP_EOL;
                if(!empty($attributes)) {
                    foreach($attributes as $attribute) {
                        if($attribute->attribute_index === "PRIMARY" || $attribute->attribute_autoincrement === "1" || $attribute->attribute_datatype === "DATETIME" || json_decode($attribute->attribute_inputtype)->key === "FOREIGN_KEY") {
                            continue;
                        } else {
                            if(json_decode($attribute->attribute_inputtype)->key === "FOREIGN_KEY") {
                                $model .= "";
                            } else {
                                $model .= "    ".$var."this->db->or_where('".$attribute->attribute_code." LIKE', '%'. ".$var."search . '%');".PHP_EOL;
                            }
                        }
                    }                
                }
                $model .= PHP_EOL;
                if(count($foreignKeys) > 0) {
                    $model .= "    # result query".PHP_EOL;
                    $model .= "    ".$var."query = ".$var."this->db->get()->result_array();".PHP_EOL.PHP_EOL;
                    $model .= "    # Initialize array".PHP_EOL;
                    $model .= "    ".$var."data = [];".PHP_EOL.PHP_EOL;
                    $model .= "    # foreach all records".PHP_EOL;
                    $model .= "    foreach(".$var."query as ".$var."item) {".PHP_EOL;
                    foreach($foreignKeys as $foreignKey) {
                        $thisTablePrimaryKey = $this->getPrimaryKey($foreignKey->table_info);
                        $thisTableReferenceKey = $this->getReferenceKey($foreignKey->table_info);
                        $thisUnHideAttributes = $this->getUnHideAttributes($foreignKey->table_info);
                        if(empty($thisTableReferenceKey)) {
                            $model .= "      # fetch ".$foreignKey->table_info->table_code." data".PHP_EOL;
                            $model .= "      if(strlen(".$var."item['".$foreignKey->attribute_code."']) > 0)".PHP_EOL;
                            $model .= "        ".$var."item['".$foreignKey->table_info->table_code."'] = ".$var."this->db->select('";
                            if(!empty($thisUnHideAttributes)) {
                                foreach($thisUnHideAttributes as $thisUnHideAttribute) {
                                    $model .= $thisUnHideAttribute->attribute_code.",";
                                }
                                $model = substr($model, 0, -1);
                            } else {
                                $model .= "*";
                            }
                            $model .= "')->from('".$foreignKey->table_info->table_code."')->where('".$thisTablePrimaryKey->attribute_code."', ".$var."item['".$foreignKey->attribute_code."'])->get()->row_array() ?? [];".PHP_EOL.PHP_EOL;
                        } else {
                            $model .= "      # fetch ".$foreignKey->table_info->table_code." data".PHP_EOL;
                            $model .= "      if(strlen(".$var."item['".$foreignKey->attribute_code."']) > 0)".PHP_EOL;
                            $model .= "        ".$var."item['".$foreignKey->table_info->table_code."'] = ".$var."this->db->select('";
                            if(!empty($thisUnHideAttributes)) {
                                foreach($thisUnHideAttributes as $thisUnHideAttribute) {
                                    $model .= $thisUnHideAttribute->attribute_code.",";
                                }
                                $model = substr($model, 0, -1);
                            } else {
                                $model .= "*";
                            }
                            $model .= "')->from('".$foreignKey->table_info->table_code."')->where('".$thisTableReferenceKey->attribute_code."', ".$var."item['".$foreignKey->attribute_code."'])->get()->row_array() ?? [];".PHP_EOL.PHP_EOL;
                        }
                    }
                    $model .= "      ".$var."data[] = ".$var."item;".PHP_EOL;
                    $model .= "    }".PHP_EOL.PHP_EOL;
                    $model .= "    # Return result".PHP_EOL;
                    $model .= "    return ".$var."data;".PHP_EOL;
                } else {
                    $model .= "    # result".PHP_EOL;
                    $model .= "    ".$var."result = ".$var."this->db->get()->result_array();".PHP_EOL.PHP_EOL;
                    $model .= "    # Return result".PHP_EOL;
                    $model .= "    return ".$var."result;".PHP_EOL;
                }
                $model .= "  }".PHP_EOL.PHP_EOL;
                $model .= "}".PHP_EOL;
                $model .= "?>";

                # Create File & Copy Content
                file_put_contents($filePath, $model , FILE_APPEND | LOCK_EX);
            }  
        }

        return TRUE;
    }




















/* *************************************************************************************************************** */
/*  ###  Create Library Model  ###                                                                                 */
/* *************************************************************************************************************** */

    /**
     * NOTE : Create Models For Each Table
     *
     * @param   array     $tables - All Tables
     * 
     * @param   string    $libraryFilePath - Library File Path
     * 
     * @param   string    $modelsFeature - Model Feature Data
     * 
     * @param   string    $authenticationFeature - Authentication Feature Data
     * 
     * @return  Boolean   True / False
     */
    public function createLibraryModel($tables, $libraryFilePath, $modelsFeature, $authenticationFeature, $projectName)
    {
        # Initialise String
        $library = "";

        # Initialize Variable
        $var = "$";
        $var1 = '"';

        # Model which contains many methods
        $library .= "<?php".PHP_EOL;
        $library .= "if(! defined('BASEPATH')) exit ('No direct script access allowed');".PHP_EOL.PHP_EOL;
        $library .= "class LibraryModel extends CI_Model {".PHP_EOL.PHP_EOL;
        $library .= "  public function __construct(){".PHP_EOL;
        $library .= "    parent::__construct();".PHP_EOL;
        $library .= "    ".$var."this->table  = 'users';".PHP_EOL;
        $library .= "    ".$var."this->table1 = 'jwt_tokens';".PHP_EOL;
        $library .= "  }".PHP_EOL.PHP_EOL;
        $library .= "  /**".PHP_EOL;
        $library .= "   * Method Name : UUID".PHP_EOL;
        $library .= "   * Description : Generate our own uuid's".PHP_EOL;
        $library .= "   * ".PHP_EOL;
        $library .= "   * @param   boolean   ".$var."trim - false".PHP_EOL;
        $library .= "   * ".PHP_EOL;
        $library .= "   * @return  string    UUID".PHP_EOL;
        $library .= "   */".PHP_EOL;
        $library .= "  public function UUID(".$var."trim = false)".PHP_EOL;
        $library .= "  {".PHP_EOL;
        $library .= "    # Format".PHP_EOL;
        $library .= "    ".$var."format = (".$var."trim == false) ? '%04x%04x-%04x-%04x-%04x-%04x%04x%04x' : '%04x%04x%04x%04x%04x%04x%04x%04x';".PHP_EOL.PHP_EOL;
        $library .= "    # generate UUID".PHP_EOL;
        $library .= "    ".$var."uuid = sprintf(".$var."format,".PHP_EOL;
        $library .= "      # 32 bits for ".$var1."time_low".$var1.PHP_EOL;
        $library .= "      mt_rand(0, 0xffff), mt_rand(0, 0xffff),".PHP_EOL;
        $library .= "      # 16 bits for ".$var1."time_mid".$var1.PHP_EOL;
        $library .= "      mt_rand(0, 0xffff),".PHP_EOL;
        $library .= "      # 16 bits for ".$var1."time_hi_and_version".$var1.", four most significant bits holds version number 4".PHP_EOL;
        $library .= "      mt_rand(0, 0x0fff) | 0x4000,".PHP_EOL;
        $library .= "      # 16 bits, 8 bits for ".$var1."clk_seq_hi_res".$var1.", 8 bits for ".$var1."clk_seq_low".$var1.", two most significant bits holds zero and one for variant DCE1.1".PHP_EOL;
        $library .= "      mt_rand(0, 0x3fff) | 0x8000,".PHP_EOL;
        $library .= "      # 48 bits for ".$var1."node".$var1.PHP_EOL;
        $library .= "      mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)".PHP_EOL;
        $library .= "    );".PHP_EOL;
        $library .= "    ".PHP_EOL;
        $library .= "    return ".$var."uuid ?? ".$var1.$var1.";".PHP_EOL;
        $library .= "  }".PHP_EOL.PHP_EOL;   
        $library .= "#                                                                                                                 #".PHP_EOL;
        $library .= "###################################################################################################################".PHP_EOL;
        $library .= "#                                                                                                                 #".PHP_EOL.PHP_EOL;
        $library .= "  /**".PHP_EOL;
        $library .= "   * Method Name : createToken".PHP_EOL;
        $library .= "   * Description : create a token to the user".PHP_EOL;
        $library .= "   * ".PHP_EOL;
        $library .= "   * @param   string    ".$var."private_uuid   of the user".PHP_EOL;
        $library .= "   * ".PHP_EOL;
        $library .= "   * @param   string    ".$var."session_id   of the user".PHP_EOL;
        $library .= "   * ".PHP_EOL;
        $library .= "   * @return  array     Response".PHP_EOL;
        $library .= "   */".PHP_EOL;
        $library .= "  public function createToken(string ".$var."private_uuid)".PHP_EOL; 
        $library .= "  {".PHP_EOL;
        $library .= "    # Force some Body parameters".PHP_EOL;
        $library .= "    ".$var."session_id = password_hash( ".$var."this->LibraryModel->UUID(), PASSWORD_BCRYPT);".PHP_EOL;
        $library .= "    ".$var."jwt_token = md5(uniqid(rand(), true)).md5(uniqid(rand(), true)).md5(uniqid(rand(), true));".PHP_EOL.PHP_EOL;
        $library .= "    # Create array".PHP_EOL;
        $library .= "    ".$var."data=array(".PHP_EOL;
        $library .= "      'user_uuid'=>".$var."private_uuid,".PHP_EOL;
        $library .= "      'session_id'=>".$var."session_id,".PHP_EOL;
        $library .= "      'jwt_token'=>".$var."jwt_token,".PHP_EOL;
        $library .= "      'created_dt'=>date('Y-m-d H:i:s')".PHP_EOL;
        $library .= "    );".PHP_EOL.PHP_EOL;
        $library .= "    # Initialize array".PHP_EOL;
        $library .= "    ".$var."result = [];".PHP_EOL.PHP_EOL;
        $library .= "    # Insert data".PHP_EOL;
        $library .= "    ".$var."insert = ".$var."this->db->insert(".$var."this->table1,".$var."data);".PHP_EOL;
        $library .= "    if(".$var."insert) {".PHP_EOL;
        $library .= "      ".$var."id = ".$var."this->db->insert_id();".PHP_EOL;
        $library .= "      ".$var."result = ".$var."this->db->select('jwt_token')->from(".$var."this->table1)->where('id', ".$var."id)->get()->row_array();".PHP_EOL;
        $library .= "    }".PHP_EOL.PHP_EOL;
        $library .= "    return ".$var."result;".PHP_EOL;
        $library .= "  }".PHP_EOL.PHP_EOL;
        $library .= "#                                                                                                                 #".PHP_EOL;
        $library .= "###################################################################################################################".PHP_EOL;
        $library .= "#                                                                                                                 #".PHP_EOL.PHP_EOL;
        $library .= "  /**".PHP_EOL;
        $library .= "   * Method Name : getAuthUser".PHP_EOL;
        $library .= "   * Description : Verify jwt-token & get user data".PHP_EOL;
        $library .= "   * ".PHP_EOL;
        $library .= "   * @param   string  ".$var."key".PHP_EOL;
        $library .= "   * ".PHP_EOL;
        $library .= "   * @return  array   ".$var."user User-Data".PHP_EOL;
        $library .= "   */".PHP_EOL;
        $library .= "  public function getAuthUser(string ".$var."key) ".PHP_EOL;
        $library .= "  {".PHP_EOL;
        $library .= "    # Initialize array".PHP_EOL;
        $library .= "    ".$var."user = [];".PHP_EOL.PHP_EOL;
        $library .= "    # Get jwt token data".PHP_EOL;
        $library .= "    ".$var."jwtToken = ".$var."this->db->select('*')->from(".$var."this->table1)->where('jwt_token', ".$var."key)->get()->row_array() ?? [];".PHP_EOL;
        $library .= "    if(empty(".$var."jwtToken)) return ".$var."jwtToken;".PHP_EOL.PHP_EOL;
        $library .= "    # Get Auth User Data".PHP_EOL;
        $library .= "    ".$var."user = ".$var."this->db->select('uuid, user_name, user_email, user_mobile, created_date')->from(".$var."this->table)->where('private_uuid', ".$var."jwtToken['user_uuid'])->get()->row_array() ?? [];".PHP_EOL;
        $library .= "    if(empty(".$var."user)) return ".$var."user;".PHP_EOL.PHP_EOL;
        $library .= "    return ".$var."user;".PHP_EOL;
        $library .= "  }".PHP_EOL.PHP_EOL;
        $library .= "#                                                                                                                 #".PHP_EOL;
        $library .= "###################################################################################################################".PHP_EOL;
        $library .= "#                                                                                                                 #".PHP_EOL.PHP_EOL;
        $library .= "  /**".PHP_EOL;
        $library .= "   * Method Name : verifyAuthentication".PHP_EOL;
        $library .= "   * Description : Verify token-type & jwt-token".PHP_EOL;
        $library .= "   * ".PHP_EOL;
        $library .= "   * @param   string  ".$var."authorization".PHP_EOL;
        $library .= "   * ".PHP_EOL;
        $library .= "   * @return  array   Response(jwt-token)".PHP_EOL;
        $library .= "   */".PHP_EOL;
        $library .= "  public function verifyAuthentication(string ".$var."authorization)".PHP_EOL;
        $library .= "  {".PHP_EOL;
        $library .= "    # Initialize array".PHP_EOL;
        $library .= "    ".$var."result = [];".PHP_EOL.PHP_EOL;
        $library .= "    # Explode ".$var."authorization to get token-type & jwt-token".PHP_EOL;
        $library .= "    ".$var."data = explode(".$var1." ".$var1.", ".$var."authorization);".PHP_EOL;
        $library .= "    if(count(".$var."data) !== 2) {".PHP_EOL;
        $library .= "      ".$var."result['error'] = ".$var1."Unformatted Token! (Expected Format: <token_type> <jwt_token>)".$var1.";".PHP_EOL;
        $library .= "      return ".$var."result;".PHP_EOL;
        $library .= "    }".PHP_EOL.PHP_EOL;
        $library .= "    # Validate token-type".PHP_EOL;
        $library .= "    if ( (strtolower(".$var."data[0]) !== ".$var1."token".$var1.")) {".PHP_EOL;
        $library .= "      ".$var."result['error'] = ".$var1."Wrong Token Type!".$var1.";".PHP_EOL;
        $library .= "      return ".$var."result;".PHP_EOL;
        $library .= "    }".PHP_EOL.PHP_EOL;
        $library .= "    # Validate jwt-token".PHP_EOL;
        $library .= "    if (empty(".$var."data[1])) {".PHP_EOL;
        $library .= "      ".$var."result['error'] = ".$var1."Token Missing!".$var1.";".PHP_EOL;
        $library .= "      return ".$var."result;".PHP_EOL;
        $library .= "    }".PHP_EOL.PHP_EOL;
        $library .= "    # Verify jwt-token".PHP_EOL;
        $library .= "    ".$var."verifyToken = ".$var."this->db->select('*')->from(".$var."this->table1)->where('jwt_token', ".$var."data[1])->get()->row_array() ?? [];".PHP_EOL;
        $library .= "    if(empty(".$var."verifyToken)) {".PHP_EOL;
        $library .= "      ".$var."result['error'] = ".$var1."Invalid Token!".$var1.";".PHP_EOL;
        $library .= "      return ".$var."result;".PHP_EOL;
        $library .= "    }".PHP_EOL.PHP_EOL;
        $library .= "    # success message - return jwt-token".PHP_EOL;
        $library .= "    ".$var."result['jwt_token'] = ".$var."data[1];".PHP_EOL.PHP_EOL;
        $library .= "    return ".$var."result;".PHP_EOL;
        $library .= "  }".PHP_EOL;
        $library .= "}".PHP_EOL;
        $library .= "?>";

        # Create File & Copy Content
        file_put_contents($libraryFilePath, $library , FILE_APPEND | LOCK_EX);

        return TRUE;
    }
    



















/* *************************************************************************************************************** */
/*  ###  Create Register Model File For Project  ###                                                                            */
/* *************************************************************************************************************** */

    /**
     * NOTE : Create Register Model File
     *
     * @param   array       $tables - All Tables
     * 
     * @param   string      $filePath - File Path
     * 
     * @param   string      $projectName - Project Name
     * 
     * @return  true/false
     */
    public function createRegisterModel($tables, $filePath, $projectName)
    {
        # Initialise Variables
        $var = "$";
        $var1 = '"';

        # Migrate for each table
        foreach($tables as $table) {

            # Register Model Only For Users
            if($table->table_code === "users") {
                
                # Get Attributes For Particular Table
                $attributes = Attribute::where('table_uuid',$table->uuid)->get();

                # Get Showable Columns
                $unHideAttributes = $this->getUnHideAttributes($table);

                # Initialise Strings
                $registerM = "";

                $registerM .= "<?php".PHP_EOL;
                $registerM .= "/**".PHP_EOL;
                $registerM .= " * RegisterModel.php".PHP_EOL;
                $registerM .= " *".PHP_EOL;
                $registerM .= " * Register Model".PHP_EOL;
                $registerM .= " *".PHP_EOL;
                $registerM .= " * Generated with AutoGenCode v1.0.0".PHP_EOL;
                $registerM .= " *".PHP_EOL;
                $registerM .= " * @author      Pavan Kumar".PHP_EOL;
                $registerM .= " * @contact     8520872771".PHP_EOL;
                $registerM .= " * @mailId      en.pavankumar@gmail.com".PHP_EOL;
                $registerM .= " *".PHP_EOL;
                $registerM .= " * @createdAt   ".date("Y-m-d h:i:s").PHP_EOL;
                $registerM .= " * @project     ".$projectName.PHP_EOL;
                $registerM .= " */".PHP_EOL;
                $registerM .= "#########################################################################################".PHP_EOL.PHP_EOL;
                $registerM .= "# No direct script access allowed".PHP_EOL;
                $registerM .= "if(! defined('BASEPATH')) exit ('No direct script access allowed');".PHP_EOL.PHP_EOL;
                $registerM .= "/**".PHP_EOL;
                $registerM .= " * Register Model".PHP_EOL;
                $registerM .= " */".PHP_EOL;
                $registerM .= "class RegisterModel extends CI_Model {".PHP_EOL.PHP_EOL;
                $registerM .= "  public function __construct() {".PHP_EOL;
                $registerM .= "    parent::__construct();".PHP_EOL;
                $registerM .= "    ".$var."this->table = 'users';".PHP_EOL;
                $registerM .= "    ".$var."this->load->model('LibraryModel');".PHP_EOL;
                $registerM .= "  }".PHP_EOL.PHP_EOL;
                $registerM .= "#".PHP_EOL;
                $registerM .= "########################################################################################################".PHP_EOL;
                $registerM .= "#".PHP_EOL.PHP_EOL;
                $registerM .= "  /**".PHP_EOL;
                $registerM .= "   * Method Name : register".PHP_EOL;
                $registerM .= "   * Description : register a new record".PHP_EOL;
                $registerM .= "   * ".PHP_EOL;
                $registerM .= "   * @param   array   ".$var."input  -  post body".PHP_EOL;
                $registerM .= "   * ".PHP_EOL;
                $registerM .= "   * @return  string  Authorization_Token".PHP_EOL;
                $registerM .= "   */".PHP_EOL;
                $registerM .= "  public function register(array ".$var."input)".PHP_EOL;
                $registerM .= "  {".PHP_EOL;
                foreach($attributes as $attribute) {
                    if($attribute->attribute_index === "UNIQUE") {
                        $registerM .= "    # ".$attribute->attribute_code." - unique check".PHP_EOL;
                        $registerM .= "    ".$var.$attribute->attribute_code." = ".$var."this->db->select('*')->from(".$var."this->table)->where('".$attribute->attribute_code."', ".$var."input['".$attribute->attribute_code."'])->get()->result();".PHP_EOL;
                        $registerM .= "    if(!empty(".$var.$attribute->attribute_code.")) {".PHP_EOL;
                        $registerM .= "      ".$var."result['message'] = ".$var1.$attribute->attribute_code." Already Exist".$var1.";".PHP_EOL;
                        $registerM .= "      return ".$var."result;".PHP_EOL;
                        $registerM .= "    }".PHP_EOL.PHP_EOL;
                    } else { continue; }
                }
                $registerM .= "    # Force some Body parameters".PHP_EOL;
                $registerM .= "    ".$var."pw_seed = ".$var."this->LibraryModel->UUID();".PHP_EOL;
                $registerM .= "    ".$var."pw_hash = password_hash( ".$var."pw_seed.".$var1."_".$var1.".".$var."input['user_password'], PASSWORD_BCRYPT);".PHP_EOL;
                $registerM .= "    ".$var."pw_algo = ".$var1."PASSWORD_BCRYPT".$var1.";".PHP_EOL.PHP_EOL;
                $registerM .= "    # Create array".PHP_EOL;
                $registerM .= "    ".$var."data=array(".PHP_EOL;
                if(!empty($attributes)) {
                    foreach($attributes as $attribute) {
                        if($attribute->attribute_index === "PRIMARY" || $attribute->attribute_autoincrement === "1" || $attribute->attribute_autoincrement === "on") {
                            continue;
                        } else {
                            # UUID
                            if(json_decode($attribute->attribute_inputtype)->key === "REFERENCE_KEY_UUID" || json_decode($attribute->attribute_inputtype)->key === "UUID") {
                                $registerM .= "      '".$attribute->attribute_code."'=>".$var."this->LibraryModel->UUID(),".PHP_EOL;
                                continue;
                            }
                            # Current Date
                            if(json_decode($attribute->attribute_inputtype)->key === "CURRENT_DATE") {
                                $registerM .= "      '".$attribute->attribute_code."'=>date('Y-m-d'),".PHP_EOL;
                                continue;
                            }
                            # Current Date Time
                            if(json_decode($attribute->attribute_inputtype)->key === "CURRENT_DATETIME") {
                                $registerM .= "      '".$attribute->attribute_code."'=>date('Y-m-d H:i:s'),".PHP_EOL;
                                continue;
                            }
                            # Current Date Time
                            if(json_decode($attribute->attribute_inputtype)->key === "CURRENT_DATE") {
                                $registerM .= "      '".$attribute->attribute_code."'=>date(".$var1."Y-m-d H:i:s A".$var1.", time()),".PHP_EOL;
                                continue;
                            }
                            # Pw_seed
                            if($attribute->attribute_code === "pw_seed") {
                                $registerM .= "      'pw_seed'=>".$var."pw_seed,".PHP_EOL;
                                continue;
                            }
                            # Pw_hash
                            if($attribute->attribute_code === "pw_hash") {
                                $registerM .= "      'pw_hash'=>".$var."pw_hash,".PHP_EOL;
                                continue;
                            }
                            # Pw_algo
                            if($attribute->attribute_code === "pw_algo") {
                                $registerM .= "      'pw_algo'=>".$var."pw_algo,".PHP_EOL;
                                continue;
                            }
                            # Private_uuid
                            if($attribute->attribute_code === "private_uuid") {
                                $registerM .= "      'private_uuid'=>".$var."this->LibraryModel->UUID(),".PHP_EOL;
                                continue;
                            }
                            $registerM .= "      '".$attribute->attribute_code."'=>".$var."input['".$attribute->attribute_code."'],".PHP_EOL;
                        }
                    }
                    $registerM = substr($registerM, 0, -3);
                }
                $registerM .= PHP_EOL;
                $registerM .= "    );".PHP_EOL.PHP_EOL;
                $registerM .= "    # Initialize array".PHP_EOL;
                $registerM .= "    ".$var."result = [];".PHP_EOL.PHP_EOL;
                $registerM .= "    # Insert data".PHP_EOL;
                $registerM .= "    ".$var."insert = ".$var."this->db->insert(".$var."this->table,".$var."data);".PHP_EOL;
                $registerM .= "    if(".$var."insert) {".PHP_EOL;
                $registerM .= "      # Inserted Id".PHP_EOL;
                $registerM .= "      ".$var."id = ".$var."this->db->insert_id();".PHP_EOL.PHP_EOL;
                $registerM .= "      # Get private_uuid from registered user - returns an array".PHP_EOL;
                $registerM .= "      ".$var."user = ".$var."this->db->select('private_uuid')->from(".$var."this->table)->where('id', ".$var."id)->get()->row_array() ?? [];".PHP_EOL;
                $registerM .= "      if(!empty(".$var."user)) {".PHP_EOL;
                $registerM .= "        # Private uuid".PHP_EOL;
                $registerM .= "        ".$var."private_uuid = ".$var."user['private_uuid'];".PHP_EOL.PHP_EOL;
                $registerM .= "        # Create a JWT token".PHP_EOL;                
                $registerM .= "        ".$var."token = ".$var."this->LibraryModel->createToken(".$var."private_uuid);".PHP_EOL;
                $registerM .= "        if(!empty(".$var."token)) {".PHP_EOL;
                $registerM .= "          ".$var."result['Authorization_Token'] = ".$var."token['jwt_token'];".PHP_EOL;
                $registerM .= "          ".$var."result['_user'] = ".$var."this->db->select('";
                if(!empty($unHideAttributes)) {
                    foreach($unHideAttributes as $unHideAttribute) {
                        $registerM .= $unHideAttribute->attribute_code.",";
                    }
                    $registerM = substr($registerM, 0, -1);
                } else {
                    $registerM .= "*";
                }
                $registerM .= "')->from(".$var."this->table)->where('id', ".$var."id)->get()->row_array() ?? [];".PHP_EOL;
                $registerM .= "        } else {".PHP_EOL;
                $registerM .= "          # Error Message".PHP_EOL;
                $registerM .= "          ".$var."result['message'] = 'Failed To Create Authorization Token!';".PHP_EOL;
                $registerM .= "        }".PHP_EOL;
                $registerM .= "      } else {".PHP_EOL;
                $registerM .= "        # Error Message".PHP_EOL;
                $registerM .= "        ".$var."result['message'] = 'Failed To Fetch User';".PHP_EOL;
                $registerM .= "      }".PHP_EOL;
                $registerM .= "    } else {".PHP_EOL;
                $registerM .= "      # Error Message".PHP_EOL;
                $registerM .= "      ".$var."result['message'] = 'Failed To Register New User';".PHP_EOL;
                $registerM .= "    }".PHP_EOL.PHP_EOL;
                $registerM .= "    return ".$var."result;".PHP_EOL;
                $registerM .= "  }".PHP_EOL.PHP_EOL;
                $registerM .= "}".PHP_EOL;
                $registerM .= "?>".PHP_EOL;                

                # Create Register Model File & Copy Content
                file_put_contents($filePath, $registerM.PHP_EOL, FILE_APPEND | LOCK_EX);  

                break;
            }
        }

        return TRUE;
    }




















/* *************************************************************************************************************** */
/*  ###  Create Login Model File For Project  ###                                                                            */
/* *************************************************************************************************************** */

    /**
     * NOTE : Create Login Model File
     *
     * @param   array       $tables - All Tables
     * 
     * @param   string      $filePath - File Path
     * 
     * @param   string      $projectName - Project Name
     * 
     * @return  true/false
     */
    public function createLoginModel($tables, $filePath, $projectName)
    {
        # Initialise Variables
        $var = "$";
        $var1 = '"';

        # Migrate for each table
        foreach($tables as $table) {

            # Register Model Only For Users
            if($table->table_code === "users") {
                
                # Get Attributes For Particular Table
                $attributes = Attribute::where('table_uuid',$table->uuid)->get();

                # Get Showable Columns
                $unHideAttributes = $this->getUnHideAttributes($table);

                # Initialise Strings
                $loginM = "";

                $loginM .= "<?php".PHP_EOL;
                $loginM .= "/**".PHP_EOL;
                $loginM .= " * LoginModel.php".PHP_EOL;
                $loginM .= " *".PHP_EOL;
                $loginM .= " * Generated with AutoGenCode v1.0.0".PHP_EOL;
                $loginM .= " *".PHP_EOL;
                $loginM .= " * @author      Pavan Kumar".PHP_EOL;
                $loginM .= " * @contact     8520872771".PHP_EOL;
                $loginM .= " * @mailId      en.pavankumar@gmail.com".PHP_EOL;
                $loginM .= " *".PHP_EOL;
                $loginM .= " * @createdAt   ".date("Y-m-d h:i:s").PHP_EOL;
                $loginM .= " * @project     ".$projectName.PHP_EOL;
                $loginM .= " */".PHP_EOL;
                $loginM .= "#########################################################################################".PHP_EOL.PHP_EOL;
                $loginM .= "# No direct script access allowed".PHP_EOL;
                $loginM .= "if(! defined('BASEPATH')) exit ('No direct script access allowed');".PHP_EOL.PHP_EOL;
                $loginM .= "class LoginModel extends CI_Model {".PHP_EOL.PHP_EOL;
                $loginM .= "  public function __construct(){".PHP_EOL;
                $loginM .= "      parent::__construct();".PHP_EOL;
                $loginM .= "      ".$var."this->table = 'users';".PHP_EOL;
                $loginM .= "      ".$var."this->load->model('LibraryModel');".PHP_EOL;
                $loginM .= "  }".PHP_EOL.PHP_EOL;
                foreach($attributes as $attribute) {
                    if( ( ($attribute->attribute_code === "user_name") || ($attribute->attribute_code === "user_email") || ($attribute->attribute_code === "user_mobile") ) && ($attribute->attribute_index === "UNIQUE") ) {
                     
                        $loginM .= "#".PHP_EOL;
                        $loginM .= "########################################################################################################".PHP_EOL;
                        $loginM .= "#".PHP_EOL.PHP_EOL;
                        $loginM .= "  /**".PHP_EOL;
                        $loginM .= "   *".PHP_EOL;
                        if($attribute->attribute_code === "user_name") {
                            $loginM .= "   * Method Name : nameLogin".PHP_EOL;
                            $loginM .= "   * Description : Login with name & password".PHP_EOL;
                        } else if($attribute->attribute_code === "user_email") {
                            $loginM .= "   * Method Name : emailLogin".PHP_EOL;
                            $loginM .= "   * Description : Login with email & password".PHP_EOL;
                        } else if($attribute->attribute_code === "user_mobile") {
                            $loginM .= "   * Method Name : mobileLogin".PHP_EOL;
                            $loginM .= "   * Description : Login with mobile number & password".PHP_EOL;
                        }
                        $loginM .= "   *".PHP_EOL;
                        $loginM .= "   * @param   array   ".$var."input post body".PHP_EOL;
                        $loginM .= "   * ".PHP_EOL;
                        $loginM .= "   * @return  string  Authorization_Token".PHP_EOL;
                        $loginM .= "   */".PHP_EOL;
                        if($attribute->attribute_code === "user_name") {
                            $loginM .= "  public function nameLogin(array ".$var."input) ".PHP_EOL;
                        } else if($attribute->attribute_code === "user_email") {
                            $loginM .= "  public function emailLogin(array ".$var."input) ".PHP_EOL;
                        } else if($attribute->attribute_code === "user_mobile") {
                            $loginM .= "  public function mobileLogin(array ".$var."input) ".PHP_EOL;
                        }
                        $loginM .= "  {".PHP_EOL;
                        if($attribute->attribute_code === "user_name") {
                            $loginM .= "    # Get data based on user_name".PHP_EOL;
                            $loginM .= "    ".$var."name = ".$var."this->db->select('*')->from(".$var."this->table)->where('user_name', ".$var."input['user_name'])->get()->row_array();".PHP_EOL;
                            $loginM .= "    if(empty(".$var."name)) {".PHP_EOL;
                            $loginM .= "      ".$var."result['message'] = ".$var1."Name Does Not Exist".$var1.";".PHP_EOL;
                            $loginM .= "      return ".$var."result;".PHP_EOL;
                            $loginM .= "    }".PHP_EOL.PHP_EOL;
                        } else if($attribute->attribute_code === "user_email") {
                            $loginM .= "    # Get data based on user_email".PHP_EOL;
                            $loginM .= "    ".$var."email = ".$var."this->db->select('*')->from(".$var."this->table)->where('user_email', ".$var."input['user_email'])->get()->row_array();".PHP_EOL;
                            $loginM .= "    if(empty(".$var."email)) {".PHP_EOL;
                            $loginM .= "      ".$var."result['message'] = ".$var1."Email Does Not Exist".$var1.";".PHP_EOL;
                            $loginM .= "      return ".$var."result;".PHP_EOL;
                            $loginM .= "    }".PHP_EOL.PHP_EOL;
                        } else if($attribute->attribute_code === "user_mobile") {
                            $loginM .= "    # Get data based on user_mobile".PHP_EOL;
                            $loginM .= "    ".$var."mobile = ".$var."this->db->select('*')->from(".$var."this->table)->where('user_mobile', ".$var."input['user_mobile'])->get()->row_array();".PHP_EOL;
                            $loginM .= "    if(empty(".$var."mobile)) {".PHP_EOL;
                            $loginM .= "      ".$var."result['message'] = ".$var1."mobile number Does Not Exist".$var1.";".PHP_EOL;
                            $loginM .= "      return ".$var."result;".PHP_EOL;
                            $loginM .= "    }".PHP_EOL.PHP_EOL;
                        }
                        $loginM .= "    # Verify Password".PHP_EOL;
                        if($attribute->attribute_code === "user_name") {
                            $loginM .= "    ".$var."verifyPassword = password_verify( ".$var."name['pw_seed'].'_'.".$var."input['user_password'], ".$var."name['pw_hash']);".PHP_EOL.PHP_EOL;
                        } else if($attribute->attribute_code === "user_email") {
                            $loginM .= "    ".$var."verifyPassword = password_verify( ".$var."email['pw_seed'].'_'.".$var."input['user_password'], ".$var."email['pw_hash']);".PHP_EOL.PHP_EOL;
                        } else if($attribute->attribute_code === "user_mobile") {
                            $loginM .= "    ".$var."verifyPassword = password_verify( ".$var."mobile['pw_seed'].'_'.".$var."input['user_password'], ".$var."mobile['pw_hash']);".PHP_EOL.PHP_EOL;
                        }
                        $loginM .= "    # If password matches create ".$var1."Session".$var1." & ".$var1."JWT - Token".$var1.PHP_EOL;
                        $loginM .= "    if (".$var."verifyPassword) {".PHP_EOL;
                        $loginM .= "      # Create a JWT token".PHP_EOL;
                        if($attribute->attribute_code === "user_name") {
                            $loginM .= "      ".$var."token = ".$var."this->LibraryModel->createToken(".$var."name['private_uuid']);".PHP_EOL;
                        } else if($attribute->attribute_code === "user_email") {
                            $loginM .= "      ".$var."token = ".$var."this->LibraryModel->createToken(".$var."email['private_uuid']);".PHP_EOL;
                        } else if($attribute->attribute_code === "user_mobile") {
                            $loginM .= "      ".$var."token = ".$var."this->LibraryModel->createToken(".$var."mobile['private_uuid']);".PHP_EOL;
                        }
                        $loginM .= "      if(!empty(".$var."token)) {".PHP_EOL;
                        $loginM .= "        ".$var."result['Authorization_Token'] = ".$var."token['jwt_token'];".PHP_EOL;
                        $loginM .= "        ".$var."result['_user'] = ".$var."this->db->select('";
                        if(!empty($unHideAttributes)) {
                            foreach($unHideAttributes as $unHideAttribute) {
                                $loginM .= $unHideAttribute->attribute_code.",";
                            }
                            $loginM = substr($loginM, 0, -1);
                        } else {
                            $loginM .= "*";
                        }
                        if($attribute->attribute_code === "user_name") {
                            $loginM .= "')->from(".$var."this->table)->where('id', ".$var."name['id'])->get()->row_array() ?? [];".PHP_EOL;
                        } else if($attribute->attribute_code === "user_email") {
                            $loginM .= "')->from(".$var."this->table)->where('id', ".$var."email['id'])->get()->row_array() ?? [];".PHP_EOL;
                        } else if($attribute->attribute_code === "user_mobile") {
                            $loginM .= "')->from(".$var."this->table)->where('id', ".$var."mobile['id'])->get()->row_array() ?? [];".PHP_EOL;
                        }
                        
                        $loginM .= "      }".PHP_EOL;
                        $loginM .= "    } else {".PHP_EOL;
                        $loginM .= "      # Return Error Message".PHP_EOL;
                        $loginM .= "      ".$var."result['message'] = ".$var1."Incorrect password".$var1.";".PHP_EOL;
                        $loginM .= "      return ".$var."result;".PHP_EOL;
                        $loginM .= "    }".PHP_EOL.PHP_EOL;
                        $loginM .= "    return ".$var."result;".PHP_EOL;
                        $loginM .= "  }".PHP_EOL;
                    
                    }
                }
                $loginM .= "}".PHP_EOL;
                $loginM .= "?>".PHP_EOL;

                # Create Login Model File & Copy Content
                file_put_contents($filePath, $loginM.PHP_EOL, FILE_APPEND | LOCK_EX);  

                break;
            }
        }

        return TRUE;
    }




















/* *************************************************************************************************************** */
/*  ###  Create Change Password Model File For Project  ###                                                                            */
/* *************************************************************************************************************** */

    /**
     * NOTE : Create Change Password Model File
     *
     * @param   string      $filePath - File Path
     * 
     * @param   string      $projectName - Project Name
     * 
     * @return  true/false
     */
    public function createChangePasswordModel($filePath, $projectName)
    {
        # Initialise Variables
        $var = "$";
        $var1 = '"';
        
        # Initialise Strings
        $changePassM = "";

        $changePassM .= "<?php".PHP_EOL;
        $changePassM .= "/**".PHP_EOL;
        $changePassM .= " * ChangePasswordModel.php".PHP_EOL;
        $changePassM .= " *".PHP_EOL;
        $changePassM .= " * Generated with AutoGenCode v1.0.0".PHP_EOL;
        $changePassM .= " *".PHP_EOL;
        $changePassM .= " * @author      Pavan Kumar".PHP_EOL;
        $changePassM .= " * @contact     8520872771".PHP_EOL;
        $changePassM .= " * @mailId      en.pavankumar@gmail.com".PHP_EOL;
        $changePassM .= " *".PHP_EOL;
        $changePassM .= " * @createdAt   ".date("Y-m-d h:i:s").PHP_EOL;
        $changePassM .= " * @project     ".$projectName.PHP_EOL;
        $changePassM .= " */".PHP_EOL;
        $changePassM .= "#########################################################################################".PHP_EOL.PHP_EOL;
        $changePassM .= "# No direct script access allowed".PHP_EOL;
        $changePassM .= "if(! defined('BASEPATH')) exit ('No direct script access allowed');".PHP_EOL.PHP_EOL;
        $changePassM .= "class ChangePasswordModel extends CI_Model {".PHP_EOL.PHP_EOL;
        $changePassM .= "  public function __construct(){".PHP_EOL;
        $changePassM .= "    parent::__construct();".PHP_EOL;
        $changePassM .= "    ".$var."this->table = 'users';".PHP_EOL;
        $changePassM .= "    ".$var."this->table1 = 'jwt_tokens';".PHP_EOL;
        $changePassM .= "    ".$var."this->load->model('LibraryModel');".PHP_EOL;
        $changePassM .= "  }".PHP_EOL.PHP_EOL;
        $changePassM .= "#".PHP_EOL;
        $changePassM .= "########################################################################################################".PHP_EOL;
        $changePassM .= "#".PHP_EOL.PHP_EOL;
        $changePassM .= "  /**".PHP_EOL;
        $changePassM .= "   * Method Name : changePassword".PHP_EOL;
        $changePassM .= "   * Description : Change Password".PHP_EOL;        
        $changePassM .= "   * ".PHP_EOL;
        $changePassM .= "   * @param   array   ".$var."input post body".PHP_EOL;
        $changePassM .= "   * @param   string  ".$var."token jwt-token".PHP_EOL;
        $changePassM .= "   * ".PHP_EOL;
        $changePassM .= "   * @return  array   Authorization_Token & user data".PHP_EOL;
        $changePassM .= "   */".PHP_EOL;
        $changePassM .= "  public function changePassword(array ".$var."input, string ".$var."token)".PHP_EOL;
        $changePassM .= "  {".PHP_EOL;
        $changePassM .= "    # Initialize array".PHP_EOL;
        $changePassM .= "    ".$var."result = [];".PHP_EOL.PHP_EOL;
        $changePassM .= "    # Get Jwt Token Data".PHP_EOL;
        $changePassM .= "    ".$var."getJwtData = ".$var."this->db->select('*')->from(".$var."this->table1)->where('jwt_token', ".$var."token)->get()->row_array() ?? [];".PHP_EOL;
        $changePassM .= "    if(empty(".$var."getJwtData)) {".PHP_EOL;
        $changePassM .= "      ".$var."result['error'] = ".$var1."Invalid Token!".$var1.";".PHP_EOL;
        $changePassM .= "      return ".$var."result;".PHP_EOL;
        $changePassM .= "    }".PHP_EOL.PHP_EOL;
        $changePassM .= "    # Private uuid".PHP_EOL;
        $changePassM .= "    ".$var."private_uuid = ".$var."getJwtData['user_uuid'];".PHP_EOL.PHP_EOL;
        $changePassM .= "    # Get User Data".PHP_EOL;
        $changePassM .= "    ".$var."user = ".$var."this->db->select('*')->from(".$var."this->table)->where('private_uuid', ".$var."private_uuid )->get()->row_array() ?? [];".PHP_EOL;
        $changePassM .= "    if(empty(".$var."user)) {".PHP_EOL;
        $changePassM .= "      ".$var."result['error'] = ".$var1."Invalid Token - User Not Found!".$var1.";".PHP_EOL;
        $changePassM .= "      return ".$var."result;".PHP_EOL;
        $changePassM .= "    }".PHP_EOL.PHP_EOL;
        $changePassM .= "    # Verify Password".PHP_EOL;
        $changePassM .= "    ".$var."verifyPassword = password_verify( ".$var."user['pw_seed'].'_'.".$var."input['old_password'], ".$var."user['pw_hash']);".PHP_EOL.PHP_EOL;
        $changePassM .= "    # Delete all running sessions & tokens of current user".PHP_EOL;
        $changePassM .= "    if(!empty(".$var."user) && ".$var."verifyPassword) {".PHP_EOL;
        $changePassM .= "      # Delete current user jwtTokens".PHP_EOL;
        $changePassM .= "      ".$var."deleteToken = ".$var."this->db->delete(".$var."this->table1, ['private_uuid' => ".$var."private_uuid ]);".PHP_EOL;
        $changePassM .= "    }".PHP_EOL.PHP_EOL;
        $changePassM .= "    # If password matches - update new password".PHP_EOL;
        $changePassM .= "    if (".$var."verifyPassword) {".PHP_EOL.PHP_EOL;
        $changePassM .= "      # Force some Body parameters".PHP_EOL;
        $changePassM .= "      ".$var."pw_seed = ".$var."this->LibraryModel->UUID();".PHP_EOL;
        $changePassM .= "      ".$var."pw_hash = password_hash( ".$var."pw_seed.".$var1."_".$var1.".".$var."input['new_password'], PASSWORD_BCRYPT);".PHP_EOL;
        $changePassM .= "      ".$var."pw_algo = ".$var1."PASSWORD_BCRYPT".$var1.";".PHP_EOL.PHP_EOL;
        $changePassM .= "      # Create array".PHP_EOL;
        $changePassM .= "      ".$var."data=array(".PHP_EOL;
        $changePassM .= "        'pw_seed'=>".$var."pw_seed,".PHP_EOL;
        $changePassM .= "        'pw_hash'=>".$var."pw_hash,".PHP_EOL;
        $changePassM .= "        'pw_algo'=>".$var."pw_algo".PHP_EOL;
        $changePassM .= "      );".PHP_EOL.PHP_EOL;
        $changePassM .= "      # Update password".PHP_EOL;
        $changePassM .= "      ".$var."update = ".$var."this->db->where('id',".$var."user['id'])->update(".$var."this->table,".$var."data);".PHP_EOL;
        $changePassM .= "      if(".$var."update) {".PHP_EOL;
        $changePassM .= "        # Create a JWT token".PHP_EOL;
        $changePassM .= "        ".$var."token = ".$var."this->LibraryModel->createToken(".$var."private_uuid);".PHP_EOL;
        $changePassM .= "        if(!empty(".$var."token)) {".PHP_EOL;
        $changePassM .= "          ".$var."result['Authorization_Token'] = ".$var."token['jwt_token'];".PHP_EOL;
        $changePassM .= "          ".$var."result['_user'] = ".$var."this->db->select('uuid,user_name,user_email,user_mobile,created_dt,modified_dt')->from(".$var."this->table)->where('id', ".$var."user['id'])->get()->row_array() ?? [];".PHP_EOL;
        $changePassM .= "        } else {".PHP_EOL;
        $changePassM .= "          # Error Message".PHP_EOL;
        $changePassM .= "          ".$var."result['error'] = 'Failed To Create Authorization Token!';".PHP_EOL;
        $changePassM .= "        }".PHP_EOL;
        $changePassM .= "      } else {".PHP_EOL;
        $changePassM .= "        # Error Message".PHP_EOL;
        $changePassM .= "        ".$var."result['error'] = 'Failed To Change Password';".PHP_EOL;
        $changePassM .= "      }".PHP_EOL.PHP_EOL;
        $changePassM .= "    } else {".PHP_EOL;
        $changePassM .= "      # Error Message".PHP_EOL;
        $changePassM .= "      ".$var."result['error'] = 'Invalid Old Password!';".PHP_EOL;
        $changePassM .= "    }".PHP_EOL;
        $changePassM .= "    return ".$var."result ?? [];".PHP_EOL;
        $changePassM .= "  }".PHP_EOL.PHP_EOL;
        $changePassM .= "}".PHP_EOL;
        $changePassM .= "?>";

        # Create Change Password Model File & Copy Content
        file_put_contents($filePath, $changePassM, FILE_APPEND | LOCK_EX);

        return TRUE;
    }




















/* *************************************************************************************************************** */
/*  ###  Create Forgot Password Model File For Project  ###                                                                            */
/* *************************************************************************************************************** */

    /**
     * NOTE : Create forgot Password Model File
     *
     * @param   string      $filePath - File Path
     * 
     * @param   string      $projectName - Project Name
     * 
     * @return  true/false
     */
    public function createForgotPasswordModel($filePath, $projectName)
    {
        # Initialise Variables
        $var = "$";
        $var1 = '"';
        $var2 = '.';
        
        # Initialise Strings
        $forgotPassM = "";

        $forgotPassM .= "<?php".PHP_EOL;
        $forgotPassM .= "/**".PHP_EOL;
        $forgotPassM .= " * ForgotPasswordModel.php".PHP_EOL;
        $forgotPassM .= " * ".PHP_EOL;
        $forgotPassM .= " * Generated with AutoGenCode v1.0.0".PHP_EOL;
        $forgotPassM .= " * ".PHP_EOL;
        $forgotPassM .= " * @author      Pavan Kumar".PHP_EOL;
        $forgotPassM .= " * @contact     8520872771".PHP_EOL;
        $forgotPassM .= " * @mailId      en.pavankumar@gmail.com".PHP_EOL;
        $forgotPassM .= " * ".PHP_EOL;
        $forgotPassM .= " * @createdAt   ".date("Y-m-d h:i:s").PHP_EOL;
        $forgotPassM .= " * @project     ".$projectName.PHP_EOL;
        $forgotPassM .= " */".PHP_EOL;
        $forgotPassM .= "##########################################################################################################".PHP_EOL.PHP_EOL;
        $forgotPassM .= "# No direct script access allowed".PHP_EOL;
        $forgotPassM .= "if(! defined('BASEPATH')) exit ('No direct script access allowed');".PHP_EOL.PHP_EOL;
        $forgotPassM .= "class ForgotPasswordModel extends CI_Model {".PHP_EOL.PHP_EOL;
        $forgotPassM .= "  public function __construct(){".PHP_EOL;
        $forgotPassM .= "    parent::__construct();".PHP_EOL;
        $forgotPassM .= "    ".$var."this->table = 'users';".PHP_EOL;
        $forgotPassM .= "    ".$var."this->table1 = 'jwt_tokens';".PHP_EOL;
        $forgotPassM .= "    ".$var."this->load->model('LibraryModel');".PHP_EOL;
        $forgotPassM .= "  }".PHP_EOL.PHP_EOL;
        $forgotPassM .= "#".PHP_EOL;
        $forgotPassM .= "########################################################################################################".PHP_EOL;
        $forgotPassM .= "#".PHP_EOL.PHP_EOL;
        $forgotPassM .= "  /**".PHP_EOL;
        $forgotPassM .= "   * Method Name : forgotPassword".PHP_EOL;
        $forgotPassM .= "   * Description : Forgot Password".PHP_EOL;
        $forgotPassM .= "   * ".PHP_EOL;
        $forgotPassM .= "   * @param   array   ".$var."input post body".PHP_EOL;
        $forgotPassM .= "   * ".PHP_EOL;
        $forgotPassM .= "   * @return  array   Response".PHP_EOL;
        $forgotPassM .= "   */".PHP_EOL;
        $forgotPassM .= "  public function forgotPassword(array ".$var."input)".PHP_EOL;
        $forgotPassM .= "  {".PHP_EOL;
        $forgotPassM .= "    # Initialize array".PHP_EOL;
        $forgotPassM .= "    ".$var."result = [];".PHP_EOL.PHP_EOL;
        $forgotPassM .= "    # Get Auth User Data".PHP_EOL;
        $forgotPassM .= "    ".$var."user = ".$var."this->db->select('*')->from(".$var."this->table)->where('user_email', ".$var."input['user_email'])->get()->row_array() ?? [];".PHP_EOL;
        $forgotPassM .= "    if(empty(".$var."user)) {".PHP_EOL;
        $forgotPassM .= "      ".$var."result['error'] = ".$var1."Email Number Does Not Exist".$var1.";".PHP_EOL;
        $forgotPassM .= "      return ".$var."result;".PHP_EOL;
        $forgotPassM .= "    }".PHP_EOL.PHP_EOL;
        $forgotPassM .= "    # Delete all running sessions & tokens of current user".PHP_EOL;
        $forgotPassM .= "    if(!empty(".$var."user)) {".PHP_EOL;
        $forgotPassM .= "      # Delete current user jwtTokens".PHP_EOL;
        $forgotPassM .= "      ".$var."deleteToken = ".$var."this->db->delete(".$var."this->table1, ['private_uuid' => ".$var."user['private_uuid'] ]);".PHP_EOL;
        $forgotPassM .= "    }".PHP_EOL.PHP_EOL;
        $forgotPassM .= "    #######################################################".PHP_EOL;
        $forgotPassM .= "    #".PHP_EOL;
        $forgotPassM .= "    # NOTE: Please configure email --- BEFORE USING SERVICE".PHP_EOL;
        $forgotPassM .= "    #".PHP_EOL;
        $forgotPassM .= "    #######################################################".PHP_EOL.PHP_EOL;
        $forgotPassM .= "    # Send mail".PHP_EOL;
        $forgotPassM .= "    try {".PHP_EOL;
        $forgotPassM .= "      # Load library email (default configured in codeigniter)".PHP_EOL;
        $forgotPassM .= "      ".$var."this->load->library('email');".PHP_EOL.PHP_EOL;
        $forgotPassM .= "      # Prepare mail".PHP_EOL;
        $forgotPassM .= "      ".$var."this->email->from('<Your-mail-id>', '<from-name>');".PHP_EOL;
        $forgotPassM .= "      ".$var."this->email->to(".$var."user['user_email']);".PHP_EOL;
        $forgotPassM .= "      ".$var."this->email->subject('Reset Password Link');".PHP_EOL;
        $forgotPassM .= "      ".$var."this->email->message(".$var1."Hi ".$var1.$var2.$var."user['user_name'].".$var1."! Reset Your Password Here :".$var1.$var2.$var."input['url']);".PHP_EOL;
        $forgotPassM .= "      ".$var."this->email->send();".PHP_EOL.PHP_EOL;
        $forgotPassM .= "      # Return message".PHP_EOL;
        $forgotPassM .= "      ".$var."result['message'] = ".$var1."Link sent to your mailId to change your password!".$var1.";".PHP_EOL;
        $forgotPassM .= "    } catch (Exception ".$var."e) {".PHP_EOL;
        $forgotPassM .= "      # Error message".PHP_EOL;
        $forgotPassM .= "      ".$var."result['error'] = ".$var."this->email->ErrorInfo;".PHP_EOL;
        $forgotPassM .= "    }".PHP_EOL.PHP_EOL;
        $forgotPassM .= "    # Return result".PHP_EOL;
        $forgotPassM .= "    return ".$var."result ?? [];".PHP_EOL;
        $forgotPassM .= "  }".PHP_EOL.PHP_EOL;
        $forgotPassM .= "}".PHP_EOL;
        $forgotPassM .= "?>";

        # Create Forgot Password Model File & Copy Content
        file_put_contents($filePath, $forgotPassM, FILE_APPEND | LOCK_EX);

        return TRUE;
    }




















/* *************************************************************************************************************** */
/*  ###  Create Forgot Password Model File For Project  ###                                                                            */
/* *************************************************************************************************************** */

    /**
     * NOTE : Create forgot Password Model File
     *
     * @param   string      $filePath - File Path
     * 
     * @param   string      $projectName - Project Name
     * 
     * @return  true/false
     */
    public function createResetPasswordModel($filePath, $projectName)
    {
        # Initialise Variables
        $var = "$";
        $var1 = '"';
        $var2 = '.';
        
        # Initialise Strings
        $resetPassM = "";
        
        $resetPassM .= "<?php".PHP_EOL;
        $resetPassM .= "/**".PHP_EOL;
        $resetPassM .= " * ResetPasswordModel.php".PHP_EOL;
        $resetPassM .= " *".PHP_EOL;
        $resetPassM .= " * Generated with AutoGenCode v1.0.0".PHP_EOL;
        $resetPassM .= " *".PHP_EOL;
        $resetPassM .= " * @author      Pavan Kumar".PHP_EOL;
        $resetPassM .= " * @contact     8520872771".PHP_EOL;
        $resetPassM .= " * @mailId      en.pavankumar@gmail.com".PHP_EOL;
        $resetPassM .= " *".PHP_EOL;
        $resetPassM .= " * @createdAt   ".date("Y-m-d h:i:s").PHP_EOL;
        $resetPassM .= " * @project     ".$projectName.PHP_EOL;
        $resetPassM .= " */".PHP_EOL;
        $resetPassM .= "#########################################################################################".PHP_EOL.PHP_EOL;
        $resetPassM .= "# No direct script access allowed".PHP_EOL;
        $resetPassM .= "if(! defined('BASEPATH')) exit ('No direct script access allowed');".PHP_EOL.PHP_EOL;
        $resetPassM .= "class ResetPasswordModel extends CI_Model {".PHP_EOL.PHP_EOL;
        $resetPassM .= "  public function __construct(){".PHP_EOL;
        $resetPassM .= "    parent::__construct();".PHP_EOL;
        $resetPassM .= "    ".$var."this->table = 'users';".PHP_EOL;
        $resetPassM .= "    ".$var."this->table1 = 'jwt_tokens';".PHP_EOL;
        $resetPassM .= "    ".$var."this->load->model('LibraryModel');".PHP_EOL;
        $resetPassM .= "  }".PHP_EOL.PHP_EOL;
        $resetPassM .= "#".PHP_EOL;
        $resetPassM .= "########################################################################################################".PHP_EOL;
        $resetPassM .= "#".PHP_EOL.PHP_EOL;
        $resetPassM .= "  /**".PHP_EOL;
        $resetPassM .= "   * Method Name : resetPassword".PHP_EOL;
        $resetPassM .= "   * Description : Reset Password".PHP_EOL;        
        $resetPassM .= "   * ".PHP_EOL;
        $resetPassM .= "   * @param   array   ".$var."input post body".PHP_EOL;
        $resetPassM .= "   * ".PHP_EOL;
        $resetPassM .= "   * @return  array   Response".PHP_EOL;
        $resetPassM .= "   */".PHP_EOL;
        $resetPassM .= "  public function resetPassword(array ".$var."input)".PHP_EOL;
        $resetPassM .= "  {".PHP_EOL;
        $resetPassM .= "    # Initialize array".PHP_EOL;
        $resetPassM .= "    ".$var."result = [];".PHP_EOL.PHP_EOL;
        $resetPassM .= "    # Get User Data".PHP_EOL;
        $resetPassM .= "    ".$var."user = ".$var."this->db->select('*')->from(".$var."this->table)->where('user_email', ".$var."input['user_email'] )->get()->row_array() ?? [];".PHP_EOL;
        $resetPassM .= "    if(empty(".$var."user)) {".PHP_EOL;
        $resetPassM .= "      ".$var."result['error'] = 'Email does not exist!';".PHP_EOL;
        $resetPassM .= "      return ".$var."result;".PHP_EOL;
        $resetPassM .= "    }".PHP_EOL.PHP_EOL;
        $resetPassM .= "    # Force some Body parameters".PHP_EOL;
        $resetPassM .= "    ".$var."pw_seed = ".$var."this->LibraryModel->UUID();".PHP_EOL;
        $resetPassM .= "    ".$var."pw_hash = password_hash( ".$var."pw_seed.'_'.".$var."input['new_password'], PASSWORD_BCRYPT);".PHP_EOL;
        $resetPassM .= "    ".$var."pw_algo = 'PASSWORD_BCRYPT';".PHP_EOL.PHP_EOL;
        $resetPassM .= "    # Create array".PHP_EOL;
        $resetPassM .= "    ".$var."data=array(".PHP_EOL;
        $resetPassM .= "      'pw_seed'=>".$var."pw_seed,".PHP_EOL;
        $resetPassM .= "      'pw_hash'=>".$var."pw_hash,".PHP_EOL;
        $resetPassM .= "      'pw_algo'=>".$var."pw_algo".PHP_EOL;
        $resetPassM .= "    );".PHP_EOL.PHP_EOL;
        $resetPassM .= "    # Update password".PHP_EOL;
        $resetPassM .= "    ".$var."update = ".$var."this->db->where('id',".$var."user['id'])->update(".$var."this->table,".$var."data);".PHP_EOL;
        $resetPassM .= "    if(".$var."update) {".PHP_EOL;
        $resetPassM .= "      ".$var."result['message'] = 'Password Successfully Changed!';".PHP_EOL;
        $resetPassM .= "    } else {".PHP_EOL;
        $resetPassM .= "      # Error Message".PHP_EOL;
        $resetPassM .= "      ".$var."result['error'] = 'Failed To Change Password';".PHP_EOL;
        $resetPassM .= "    }".PHP_EOL.PHP_EOL;
        $resetPassM .= "   return ".$var."result ?? [];".PHP_EOL;
        $resetPassM .= "  }".PHP_EOL.PHP_EOL;
        $resetPassM .= "}".PHP_EOL;
        $resetPassM .= "?>";

        # Create Forgot Password Model File & Copy Content
        file_put_contents($filePath, $resetPassM, FILE_APPEND | LOCK_EX);

        return TRUE;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
/* *************************************************************************************************************** */
/*  ###  Create Logout Model File For Project  ###                                                                            */
/* *************************************************************************************************************** */

    /**
     * NOTE : Create Logout Model File
     *
     * @param   string      $filePath - File Path
     * 
     * @param   string      $projectName - Project Name
     * 
     * @return  true/false
     */
    public function createLogoutModel($filePath, $projectName)
    {
        # Initialise Variables
        $var = "$";
        $var1 = '"';
        
        # Initialise Strings
        $logoutM = "";

        $logoutM .= "<?php".PHP_EOL;
        $logoutM .= "/** ".PHP_EOL;
        $logoutM .= " * LogoutModel.php".PHP_EOL;
        $logoutM .= " *".PHP_EOL;
        $logoutM .= " * Generated with AutoGenCode v1.0.0".PHP_EOL;
        $logoutM .= " *".PHP_EOL;
        $logoutM .= " * @author      Pavan Kumar".PHP_EOL;
        $logoutM .= " * @contact     8520872771".PHP_EOL;
        $logoutM .= " * @mailId      en.pavankumar@gmail.com".PHP_EOL;
        $logoutM .= " * ".PHP_EOL;
        $logoutM .= " * @createdAt   ".date("Y-m-d h:i:s").PHP_EOL;
        $logoutM .= " * @project     ".$projectName.PHP_EOL;
        $logoutM .= " */".PHP_EOL;
        $logoutM .= "#########################################################################################".PHP_EOL.PHP_EOL;
        $logoutM .= "# No direct script access allowed".PHP_EOL;
        $logoutM .= "defined('BASEPATH') OR exit('No direct script access allowed');".PHP_EOL.PHP_EOL;
        $logoutM .= "/**".PHP_EOL;
        $logoutM .= " * Logout Model".PHP_EOL;
        $logoutM .= " */".PHP_EOL;
        $logoutM .= "class LogoutModel extends CI_Model {".PHP_EOL.PHP_EOL;
        $logoutM .= "  public function __construct(){".PHP_EOL;
        $logoutM .= "    parent::__construct();".PHP_EOL;
        $logoutM .= "    ".$var."this->table = 'users';".PHP_EOL;
        $logoutM .= "    ".$var."this->table1 = 'jwt_tokens';".PHP_EOL;
        $logoutM .= "    ".$var."this->load->model('LibraryModel');".PHP_EOL;
        $logoutM .= "  }".PHP_EOL.PHP_EOL;
        $logoutM .= "#".PHP_EOL;
        $logoutM .= "########################################################################################################".PHP_EOL;
        $logoutM .= "#".PHP_EOL.PHP_EOL;
        $logoutM .= "  /**".PHP_EOL;
        $logoutM .= "   * Method Name : logout".PHP_EOL;
        $logoutM .= "   * Description : Logout".PHP_EOL;
        $logoutM .= "   * ".PHP_EOL;
        $logoutM .= "   * @param   string    ".$var."jwtToken".PHP_EOL;
        $logoutM .= "   * ".PHP_EOL;
        $logoutM .= "   * @return  array     Response".PHP_EOL;
        $logoutM .= "   */".PHP_EOL;
        $logoutM .= "  public function logout(string ".$var."jwtToken)".PHP_EOL;
        $logoutM .= "  {".PHP_EOL;
        $logoutM .= "    # Initialize an array".PHP_EOL;
        $logoutM .= "    ".$var."result = [];".PHP_EOL.PHP_EOL;
        $logoutM .= "    # Delete current jwt--token".PHP_EOL;
        $logoutM .= "    ".$var."deleteToken = ".$var."this->db->delete(".$var."this->table1, ['jwt_token' => ".$var."jwtToken]);".PHP_EOL;
        $logoutM .= "    if(!".$var."deleteToken) {".PHP_EOL;
        $logoutM .= "      ".$var."result['error'] = ".$var1."Failed To Delete Token!".$var1.";".PHP_EOL;
        $logoutM .= "      return ".$var."result;".PHP_EOL;
        $logoutM .= "    }".PHP_EOL.PHP_EOL;
        $logoutM .= "    # Success Message".PHP_EOL;
        $logoutM .= "    ".$var."result['message'] = ".$var1."Logout Successful!".$var1.";".PHP_EOL.PHP_EOL;
        $logoutM .= "    # Return result".PHP_EOL;
        $logoutM .= "    return ".$var."result;".PHP_EOL;
        $logoutM .= "  }".PHP_EOL.PHP_EOL;
        $logoutM .= "}".PHP_EOL;
        $logoutM .= "?>";

        # Create Logout Model File & Copy Content
        file_put_contents($filePath, $logoutM, FILE_APPEND | LOCK_EX);

        return TRUE;
    }




















/* *************************************************************************************************************** */
/*  ###  Generate Migrations For Given Tables  ###                                                                                 */
/* *************************************************************************************************************** */

    /**
     * NOTE : Generate Migrations For Given Tables
     *
     * @param   array     $tables - All Tables
     * 
     * @param   string    $migrationDirectory - Migration Directory
     * 
     * @param   object    $authenticationFeature - Authentication Feature Data
     * 
     * @return  Success / Failure
     */
    public function createMigrations($tables, $migrationDirectory, object $authenticationFeature)
    {
        # Initialize Variables
        $var = "$";
        $var1 = '"';

        # Initialize counter
        if($authenticationFeature->enable === "YES") {
            # Initialize Counter
            $counter = 2;
        } else {
            # Initialize Counter
            $counter = 1;
        }
        
        # Migrate for each table
        foreach($tables as $table) {

            # Initialise String
            $string = "";

            # Class Name
            $className = 'Migration_Create_'.$table->table_code.'_table';

            # File Name
            if($counter > 9) $base = "0"; else $base = "00";
            $fileName = $base.$counter.'_create_'.$table->table_code.'_table.php';
            $filePath = $migrationDirectory.DIRECTORY_SEPARATOR.$fileName;

            # Get Attributes For Particular Table
            $attributes =  Attribute::where('table_uuid',$table->uuid)->get();

            $var = "$";

            $string .= "<?php defined('BASEPATH') or exit('No direct script access allowed');".PHP_EOL.PHP_EOL;
            $string .= "/**".PHP_EOL;
            $string .= " * Class ".$className.PHP_EOL;
            $string .= " *".PHP_EOL;
            $string .= " * @"."property CI_DB_forge         ".$var."dbforge".PHP_EOL;
            $string .= " * @"."property CI_DB_query_builder ".$var."db".PHP_EOL;
            $string .= " */".PHP_EOL;
            $string .= "class ".$className." extends CI_Migration".PHP_EOL;
            $string .= "{".PHP_EOL;
            $string .= "  public function up()".PHP_EOL;
            $string .= "  {".PHP_EOL;
            $string .= "    ".$var."this->dbforge->add_field(".PHP_EOL;
            $string .= "    array(".PHP_EOL;
            foreach($attributes as $attribute) {
                $string .= "      '".$attribute->attribute_code."'  =>  array(".PHP_EOL;
                $string .= "        'type'  =>  '".$attribute->attribute_datatype."',".PHP_EOL;
                if(!empty($attribute->attribute_length)) {
                    $string .= "        'constraint'  =>  '".$attribute->attribute_length."',".PHP_EOL;
                }
                if(json_decode($attribute->attribute_default)->key === "AS_DEFINED") {
                    $string .= "        'default'  =>  '".json_decode($attribute->attribute_default)->value."',".PHP_EOL;
                }
                if($attribute->attribute_attributes === "unsigned") {
                    $string .= "        'unsigned'  =>  TRUE,".PHP_EOL;
                }
                if($attribute->attribute_index === "UNIQUE") {
                    $string .= "        'unique'  =>  TRUE,".PHP_EOL;
                }
                if($attribute->attribute_autoincrement === "1" || $attribute->attribute_autoincrement === "on") {
                    $string .= "        'auto_increment'  =>  TRUE,".PHP_EOL;
                }
                $string .= "      ),".PHP_EOL;
            }
            $string .= "    ));".PHP_EOL.PHP_EOL;
            foreach($attributes as $attribute) {
                if($attribute->attribute_index === "PRIMARY") {
                    $string .= "    ".$var."this->dbforge->add_key('".$attribute->attribute_code."', TRUE);".PHP_EOL;
                }
            }
            $string .= "    ".$var."this->dbforge->create_table('".$table->table_code."');".PHP_EOL;
            $string .= "  }".PHP_EOL.PHP_EOL;
            $string .= "  public function down()".PHP_EOL;
            $string .= "  {".PHP_EOL;
            $string .= "    // ".$var."this->dbforge->drop_table('".$table->table_code."');".PHP_EOL;
            $string .= "  }".PHP_EOL.PHP_EOL;
            $string .= "}".PHP_EOL;

            # Create File & Copy Content
            file_put_contents($filePath, $string , FILE_APPEND | LOCK_EX);

            # Increment Counter
            $counter++;
        }

        return TRUE;
    }




















/* *************************************************************************************************************** */
/*  ###  Generate Default Migrations For Project  ###                                                                                 */
/* *************************************************************************************************************** */

    /**
     * NOTE : Generate Default Migrations For Project
     *
     * @param   string    $migrationDirectory - Migration Directory
     * 
     * @return  Success / Failure
     */
    public function createDefaultMigrations($migrationDirectory)
    {
        # Initialize variables
        $var = "$";

        # Jwt Tokens Migration

        # Initialise String
        $defjwtTokenMig = "";

        # File Path
        $defjettokenPath = $migrationDirectory.DIRECTORY_SEPARATOR.'001_create_jwt_tokens_table.php';

        # Jwt Tokens Migrations
        $defjwtTokenMig .= "<?php defined('BASEPATH') or exit('No direct script access allowed');".PHP_EOL.PHP_EOL;
        $defjwtTokenMig .= "/**".PHP_EOL;
        $defjwtTokenMig .= " * Class Migration_Create_jwt_tokens_table".PHP_EOL;
        $defjwtTokenMig .= " *".PHP_EOL;
        $defjwtTokenMig .= " * @property CI_DB_forge         ".$var."dbforge".PHP_EOL;
        $defjwtTokenMig .= " * @property CI_DB_query_builder ".$var."db".PHP_EOL;
        $defjwtTokenMig .= " */".PHP_EOL;
        $defjwtTokenMig .= "class Migration_Create_jwt_tokens_table extends CI_Migration".PHP_EOL;
        $defjwtTokenMig .= "{".PHP_EOL;
        $defjwtTokenMig .= "  public function up()".PHP_EOL;
        $defjwtTokenMig .= "  {".PHP_EOL;
        $defjwtTokenMig .= "    ".$var."this->dbforge->add_field(".PHP_EOL;
        $defjwtTokenMig .= "    array(".PHP_EOL;
        $defjwtTokenMig .= "      'id'  =>  array(".PHP_EOL;
        $defjwtTokenMig .= "        'type'  =>  'INT',".PHP_EOL;
        $defjwtTokenMig .= "        'constraint'  =>  '11',".PHP_EOL;
        $defjwtTokenMig .= "        'auto_increment'  =>  TRUE,".PHP_EOL;
        $defjwtTokenMig .= "      ),".PHP_EOL;
        $defjwtTokenMig .= "      'user_uuid'  =>  array(".PHP_EOL;
        $defjwtTokenMig .= "        'type'  =>  'VARCHAR',".PHP_EOL;
        $defjwtTokenMig .= "        'constraint'  =>  '48',".PHP_EOL;
        $defjwtTokenMig .= "      ),".PHP_EOL;
        $defjwtTokenMig .= "      'session_id'  =>  array(".PHP_EOL;
        $defjwtTokenMig .= "        'type'  =>  'VARCHAR',".PHP_EOL;
        $defjwtTokenMig .= "        'constraint'  =>  '128',".PHP_EOL;
        $defjwtTokenMig .= "      ),".PHP_EOL;
        $defjwtTokenMig .= "      'jwt_token'  =>  array(".PHP_EOL;
        $defjwtTokenMig .= "        'type'  =>  'VARCHAR',".PHP_EOL;
        $defjwtTokenMig .= "        'constraint'  =>  '255',".PHP_EOL;
        $defjwtTokenMig .= "      ),".PHP_EOL;
        $defjwtTokenMig .= "      'created_dt'  =>  array(".PHP_EOL;
        $defjwtTokenMig .= "        'type'  =>  'DATETIME',".PHP_EOL;
        $defjwtTokenMig .= "      ),".PHP_EOL;
        $defjwtTokenMig .= "    ));".PHP_EOL.PHP_EOL;
        $defjwtTokenMig .= "    ".$var."this->dbforge->add_key('id', TRUE);".PHP_EOL;
        $defjwtTokenMig .= "    ".$var."this->dbforge->create_table('jwt_tokens');".PHP_EOL;
        $defjwtTokenMig .= "  }".PHP_EOL.PHP_EOL;
        $defjwtTokenMig .= "  public function down()".PHP_EOL;
        $defjwtTokenMig .= "  {".PHP_EOL;
        $defjwtTokenMig .= "    // ".$var."this->dbforge->drop_table('jwt_tokens');".PHP_EOL;
        $defjwtTokenMig .= "  }".PHP_EOL.PHP_EOL;
        $defjwtTokenMig .= "}".PHP_EOL;

        # Create File & Copy Content
        file_put_contents($defjettokenPath, $defjwtTokenMig , FILE_APPEND | LOCK_EX);

        return TRUE;
    }
    



















/* *************************************************************************************************************** */
/*  ###  Basic Route Template   ###                                                                                    */
/* *************************************************************************************************************** */

    /**
     * NOTE : Basic Route Template
     *
     * @param   string      $routesPath
     * 
     * @return  boolean     TRUE / FALSE
     */
    public function basicRoute($routesPath)
    {
        # Initialize Variable
        $var = "$";

        # Initialize String
        $basicRoute = "";

        $basicRoute .= "<?php".PHP_EOL;
        $basicRoute .= "defined('BASEPATH') OR exit('No direct script access allowed');".PHP_EOL.PHP_EOL;        
        $basicRoute .= "/*".PHP_EOL;
        $basicRoute .= "| -------------------------------------------------------------------------".PHP_EOL;
        $basicRoute .= "| URI ROUTING".PHP_EOL;
        $basicRoute .= "| -------------------------------------------------------------------------".PHP_EOL;
        $basicRoute .= "| This file lets you re-map URI requests to specific controller functions.".PHP_EOL;
        $basicRoute .= "|".PHP_EOL;
        $basicRoute .= "| Typically there is a one-to-one relationship between a URL string".PHP_EOL;
        $basicRoute .= "| and its corresponding controller class/method. The segments in a".PHP_EOL;
        $basicRoute .= "| URL normally follow this pattern:".PHP_EOL;
        $basicRoute .= "|".PHP_EOL;
        $basicRoute .= "| example.com/class/method/id/".PHP_EOL;
        $basicRoute .= "|".PHP_EOL;
        $basicRoute .= "| In some instances, however, you may want to remap this relationship".PHP_EOL;
        $basicRoute .= "| so that a different class/function is called than the one".PHP_EOL;
        $basicRoute .= "| corresponding to the URL.".PHP_EOL;
        $basicRoute .= "|".PHP_EOL;
        $basicRoute .= "| Please see the user guide for complete details:".PHP_EOL;
        $basicRoute .= "|".PHP_EOL;
        $basicRoute .= "| https://codeigniter.com/user_guide/general/routing.html".PHP_EOL;
        $basicRoute .= "|".PHP_EOL;
        $basicRoute .= "| -------------------------------------------------------------------------".PHP_EOL;
        $basicRoute .= "| RESERVED ROUTES".PHP_EOL;
        $basicRoute .= "| -------------------------------------------------------------------------".PHP_EOL;
        $basicRoute .= "|".PHP_EOL;
        $basicRoute .= "| There are three reserved routes:".PHP_EOL;
        $basicRoute .= "|".PHP_EOL;
        $basicRoute .= "| ".$var."route['default_controller'] = 'welcome';".PHP_EOL;
        $basicRoute .= "|".PHP_EOL;
        $basicRoute .= "| This route indicates which controller class should be loaded if the".PHP_EOL;
        $basicRoute .= "| URI contains no data. In the above example, the 'welcome' class".PHP_EOL;
        $basicRoute .= "| would be loaded.".PHP_EOL;
        $basicRoute .= "|".PHP_EOL;
        $basicRoute .= "| ".$var."route['404_override'] = 'errors/page_missing';".PHP_EOL;
        $basicRoute .= "|".PHP_EOL;
        $basicRoute .= "| This route will tell the Router which controller/method to use if those".PHP_EOL;
        $basicRoute .= "| provided in the URL cannot be matched to a valid route.".PHP_EOL;
        $basicRoute .= "|".PHP_EOL;
        $basicRoute .= "| ".$var."route['translate_uri_dashes'] = FALSE;".PHP_EOL;
        $basicRoute .= "|".PHP_EOL;
        $basicRoute .= "| This is not exactly a route, but allows you to automatically route".PHP_EOL;
        $basicRoute .= "| controller and method names that contain dashes. '-' isn't a valid".PHP_EOL;
        $basicRoute .= "| class or method name character, so it requires translation.".PHP_EOL;
        $basicRoute .= "| When you set this option to TRUE, it will replace ALL dashes in the".PHP_EOL;
        $basicRoute .= "| controller and method URI segments.".PHP_EOL;
        $basicRoute .= "|".PHP_EOL;
        $basicRoute .= "| Examples: my-controller/index -> my_controller/index".PHP_EOL;
        $basicRoute .= "|   my-controller/my-method -> my_controller/my_method".PHP_EOL;
        $basicRoute .= "*/".PHP_EOL;
        $basicRoute .= $var."route['default_controller'] = 'welcome';".PHP_EOL;
        $basicRoute .= $var."route['404_override'] = '';".PHP_EOL;
        $basicRoute .= $var."route['translate_uri_dashes'] = TRUE;".PHP_EOL.PHP_EOL;
        $basicRoute .= "/*".PHP_EOL;
        $basicRoute .= "| -------------------------------------------------------------------------".PHP_EOL;
        $basicRoute .= "| Sample REST API Routes For Feature Reference".PHP_EOL;
        $basicRoute .= "| -------------------------------------------------------------------------".PHP_EOL;
        $basicRoute .= "*/".PHP_EOL.PHP_EOL;
        $basicRoute .= "// ".$var."route['api/example/users/(:num)'] = 'api/example/users/id/$1'; // Example 4".PHP_EOL;
        $basicRoute .= "// ".$var."route['api/example/users/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/example/users/id/$1/format/$3$4'; // Example 8".PHP_EOL.PHP_EOL;
        
        file_put_contents($routesPath, $basicRoute, FILE_APPEND | LOCK_EX);  

        return TRUE;
    }




















/* *************************************************************************************************************** */
/*  ###  Create Routes For Project  ###                                                                            */
/* *************************************************************************************************************** */

    /**
     * NOTE : Create Routes For Project
     *
     * @param   array       $tables - All Tables
     * 
     * @param   string      $routesPath - Routes Path
     * 
     * @param   json        $routingFeature - Routing Feature data
     * 
     * @param   json        $migrationsFeature - Migrations Feature data
     * 
     * @param   json        $authenticationFeature - Authentication Feature data
     * 
     * @return  true/false
     */
    public function createRoutes($tables, $routesPath, $routingFeature, $migrationsFeature, $authenticationFeature)
    {  
        # Initialise Variables
        $var = "$";
        $var1 = '"';

        # If Authentication feature is enabled
        if($migrationsFeature->enable === "YES") {
            # Initialize String
            $migRoute = "";
        
            $migRoute .= "/*".PHP_EOL;
            $migRoute .= "| -------------------------------------------------------------------------".PHP_EOL;
            $migRoute .= "| Migration REST API".PHP_EOL;
            $migRoute .= "| -------------------------------------------------------------------------".PHP_EOL;
            $migRoute .= "*/".PHP_EOL;
            $migRoute .= $var."route['migrate/db'] = 'api/MigrationController/index'; // GET Method".PHP_EOL.PHP_EOL;

            # Save To File
            file_put_contents($routesPath, $migRoute, FILE_APPEND | LOCK_EX);  
        }

        # Migrate for each table
        foreach($tables as $table) {

            # Initialise Strings
            $controller = "";
            $routes = "";
            $apidoc = "";
            $userRoutes = "";

            # Initialise Variables
            $var = "$";

            # Table Name / Model Name
            $tableName = $this->convertToTableName($table->table_code);

            # Skip Table Users
            if($table->table_code === "users") {
                # If Authentication feature is enabled
                if($authenticationFeature->enable === "YES") {

                    # Get Attributes For Particular Table
                    $attributes = Attribute::where('table_uuid',$table->uuid)->get();

                    # Create Routes - Get, Post, Put, Delete, Search - Get
                    $userRoutes .= "/*".PHP_EOL;
                    $userRoutes .= "| -------------------------------------------------------------------------".PHP_EOL;
                    $userRoutes .= "| AUTH ROUTES / ".$tableName." REST API Routes".PHP_EOL;
                    $userRoutes .= "| -------------------------------------------------------------------------".PHP_EOL;
                    $userRoutes .= "*/".PHP_EOL;
                    $userRoutes .= $var."route['api/auth/register'] = 'api/auth/RegisterController/register'; // POST Method".PHP_EOL;
                    foreach($attributes as $attribute) {
                        if($attribute->attribute_code === "user_name") {
                            $userRoutes .= $var."route['api/auth/nameLogin'] = 'api/auth/LoginController/nameLogin'; // POST Method".PHP_EOL;
                        } else if($attribute->attribute_code === "user_email") {
                            $userRoutes .= $var."route['api/auth/emailLogin'] = 'api/auth/LoginController/emailLogin'; // POST Method".PHP_EOL;
                        } else if($attribute->attribute_code === "user_mobile") {
                            $userRoutes .= $var."route['api/auth/mobileLogin'] = 'api/auth/LoginController/mobileLogin'; // POST Method".PHP_EOL;
                        }
                    }
                    $userRoutes .= $var."route['api/auth/forgotpassword'] = 'api/auth/ForgotPasswordController/forgotPassword'; // POST Method".PHP_EOL;
                    $userRoutes .= $var."route['api/auth/resetpassword'] = 'api/auth/ResetPasswordController/resetPassword'; // POST Method".PHP_EOL;
                    $userRoutes .= $var."route['api/auth/changepassword'] = 'api/auth/ChangePasswordController/changePassword'; // POST Method".PHP_EOL;
                    $userRoutes .= $var."route['api/auth/logout'] = 'api/auth/LogoutController/logout'; // GET Method".PHP_EOL;
                    $userRoutes .= $var."route['api/users'] = 'api/auth/".$tableName."Controller/fetch'; // GET Method".PHP_EOL;
                    $userRoutes .= $var."route['api/user/update'] = 'api/auth/".$tableName."Controller/update'; // GET Method".PHP_EOL;
                    $userRoutes .= $var."route['api/user/delete'] = 'api/auth/".$tableName."Controller/delete'; // GET Method".PHP_EOL;
                    

                    # Create Routes File & Copy Content
                    file_put_contents($routesPath, $userRoutes.PHP_EOL, FILE_APPEND | LOCK_EX);
                    continue;
                }
            }

            # Create All Tables Routes - If Routing Feature Is Enabled
            if($routingFeature->enable === "YES") {
                # Create Routes - Get, Post, Put, Delete, Search - Get
                $routes .= "/*".PHP_EOL;
                $routes .= "| -------------------------------------------------------------------------".PHP_EOL;
                $routes .= "| ".$tableName." REST API Routes".PHP_EOL;
                $routes .= "| -------------------------------------------------------------------------".PHP_EOL;
                $routes .= "*/".PHP_EOL;
                $routes .= $var."route['api/".$table->table_code."'] = 'api/".$tableName."Controller/fetch'; // GET Method".PHP_EOL;
                $routes .= $var."route['api/".$table->table_code."/"."create'] = 'api/".$tableName."Controller/create'; // POST Method".PHP_EOL;
                $routes .= $var."route['api/".$table->table_code."/update/(:any)'] = 'api/".$tableName."Controller/update/".$var."1'; // PUT Method".PHP_EOL;
                $routes .= $var."route['api/".$table->table_code."/delete/(:any)'] = 'api/".$tableName."Controller/delete/".$var."1'; // DELETE Method".PHP_EOL;
                $routes .= $var."route['api/".$table->table_code."/"."search'] = 'api/".$tableName."Controller/search'; // GET Method".PHP_EOL;

                # Create Routes File & Copy Content
                file_put_contents($routesPath, $routes.PHP_EOL, FILE_APPEND | LOCK_EX);
            }
            
        }

        return TRUE;
    }




















/* *************************************************************************************************************** */
/*  ###  Create Local Api Doc For Project  ###                                                                     */
/* *************************************************************************************************************** */

    /**
     * NOTE : Create Local Api Doc
     * 
     * @param   array       $tables - Tables
     * 
     * @param   string      $localApiDocPath - File Path
     * 
     * @param   string      $localDomainUrl - Domain Url
     * 
     * @param   object      $migrationsFeature - Migration Feature
     * 
     * @param   object      $authenticationFeature - Authentication Feature
     * 
     * @return  boolean     TRUE / FALSE
     */
    public function createLocalApiDoc($tables, $localApiDocPath, $localDomainUrl, object $migrationsFeature, object $authenticationFeature)
    {
        # Migration Api - If Migration Feature Exist
        if($migrationsFeature->enable === "YES") {
            # Initialize String
            $migApi = "";

            $migApi .= "//*".PHP_EOL;
            $migApi .= "|| =========================================================================".PHP_EOL;
            $migApi .= "|| MIGRATION API".PHP_EOL;
            $migApi .= "|| =========================================================================".PHP_EOL;
            $migApi .= "*//".PHP_EOL.PHP_EOL;
            $migApi .= "1. URL                      :   ".$localDomainUrl."index.php/migrate/db".PHP_EOL;
            $migApi .= "2. METHOD                   :   GET".PHP_EOL;
            $migApi .= "3. HEADERS                  :   ".PHP_EOL;
            $migApi .= "4. REQUEST PARAMETER'S      :   ".PHP_EOL;
            $migApi .= "5. RESPONSE                 :   Success".PHP_EOL.PHP_EOL;

            # Create Api Doc File & Copy Content
            file_put_contents($localApiDocPath, $migApi, FILE_APPEND | LOCK_EX);
        }

        # Initialise Variables
        $var = "$";
        $var1 = '"';

        # Create Controllers For Each Table
        foreach($tables as $table) 
        {
            # Initialise Strings
            $localApidoc = "";

            # Initialise Variables
            $var = "$";
            $var1 = '"';

            # Table Name / Model Name
            $tableName = $this->convertToTableName($table->table_code);

            # Get Attributes For Particular Table
            $attributes = Attribute::where('table_uuid',$table->uuid)->get();
        
            # Get Foreign Keys
            $foreignKeys = $this->getForeignKeyAttributes($table);

            # Get Primary Key
            $primaryKey = $this->getPrimaryKey($table);

            # Get Reference Key
            $referenceKey = $this->getReferenceKey($table);

            # Get Input Attributes Filled By Users
            $userFilledAttributes = $this->userFilledAttributes($table);

            # Get Mandatory Fields
            $mandatoryAttributes = $this->getMandatoryAttributes($table);

            # Auth User
            if($table->table_code === "users") {
                # If Authentication feature is enabled
                if($authenticationFeature->enable === "YES") {
                    # Initialize String
                    $localAuthApi = "";

                    # Heading
                    $localAuthApi .= "//*".PHP_EOL;
                    $localAuthApi .= "|| =========================================================================".PHP_EOL;
                    $localAuthApi .= "|| AUTH REST APIS".PHP_EOL;
                    $localAuthApi .= "|| =========================================================================".PHP_EOL;
                    $localAuthApi .= "*//".PHP_EOL.PHP_EOL;

                    # Registration Api
                    $localAuthApi .= "/*".PHP_EOL;
                    $localAuthApi .= "| -------------------------------------------------------------------------".PHP_EOL;
                    $localAuthApi .= "| REGISTRATION API".PHP_EOL;
                    $localAuthApi .= "| -------------------------------------------------------------------------".PHP_EOL;
                    $localAuthApi .= "*/".PHP_EOL.PHP_EOL;
                    $localAuthApi .= "1. URL                      :   ".$localDomainUrl."index.php/api/auth/register".PHP_EOL;
                    $localAuthApi .= "2. METHOD                   :   POST".PHP_EOL;
                    $localAuthApi .= "3. HEADERS                  :   Content-Type : application/json".PHP_EOL;
                    $localAuthApi .= "4. REQUEST PARAMETER'S      :   No-Params".PHP_EOL;
                    $localAuthApi .= "5. POST BODY".PHP_EOL;
                    $localAuthApi .= "   {".PHP_EOL;
                    foreach($attributes as $attribute) {
                        if( ($attribute->attribute_code === "id") || ($attribute->attribute_code === "uuid") || ($attribute->attribute_code === "private_uuid") || ($attribute->attribute_code === "pw_seed") || ($attribute->attribute_code === "pw_hash") || ($attribute->attribute_code === "pw_algo") || json_decode($attribute->attribute_inputtype)->key === "CURRENT_DATE" || json_decode($attribute->attribute_inputtype)->key === "CURRENT_DATETIME" || json_decode($attribute->attribute_inputtype)->key === "CURRENT_TIMESTAMP" ) {
                            continue;
                        } else {
                            $localAuthApi .= "      ".$var1.$attribute->attribute_code.$var1.":".$var1."".$var1.",".PHP_EOL;
                        }
                    }
                    $localAuthApi .= "      ".$var1."user_password".$var1.":".$var1.$var1.PHP_EOL;
                    $localAuthApi .= "   }".PHP_EOL;
                    $localAuthApi .= "6. RESPONSE".PHP_EOL;
                    $localAuthApi .= "    {".PHP_EOL;
                    $localAuthApi .= "      ".$var1."Authorization_Token".$var1.":".$var1."<TOKEN>".$var1.PHP_EOL;
                    $localAuthApi .= "    }".PHP_EOL;
                    $localAuthApi .= "7. RESPONSE CODE            :   201".PHP_EOL.PHP_EOL;

                    # Login Api
                    foreach($attributes as $attribute) {
                        if($attribute->attribute_code === "user_name" && $attribute->attribute_index === "UNIQUE") {
                            $localAuthApi .= "/*".PHP_EOL;
                            $localAuthApi .= "| -------------------------------------------------------------------------".PHP_EOL;
                            $localAuthApi .= "| NAME LOGIN API".PHP_EOL;
                            $localAuthApi .= "| -------------------------------------------------------------------------".PHP_EOL;
                            $localAuthApi .= "*/".PHP_EOL.PHP_EOL;
                            $localAuthApi .= "1. URL                      :   ".$localDomainUrl."index.php/api/auth/nameLogin".PHP_EOL;
                            $localAuthApi .= "2. METHOD                   :   POST".PHP_EOL;
                            $localAuthApi .= "3. HEADERS                  :   Content-Type : application/json".PHP_EOL;
                            $localAuthApi .= "4. REQUEST PARAMETER'S      :   No-Params".PHP_EOL;
                            $localAuthApi .= "5. POST BODY".PHP_EOL;
                            $localAuthApi .= "   {".PHP_EOL;
                            $localAuthApi .= "      ".$var1."user_name".$var1.":".$var1.$var1.PHP_EOL;
                            $localAuthApi .= "      ".$var1."user_password".$var1.":".$var1.$var1.PHP_EOL;
                            $localAuthApi .= "   }".PHP_EOL;
                            $localAuthApi .= "6. RESPONSE".PHP_EOL;
                            $localAuthApi .= "    {".PHP_EOL;
                            $localAuthApi .= "      ".$var1."Authorization_Token".$var1.":".$var1."<TOKEN>".$var1.PHP_EOL;
                            $localAuthApi .= "    }".PHP_EOL;
                            $localAuthApi .= "7. RESPONSE CODE            :   200".PHP_EOL.PHP_EOL;
                        } else if($attribute->attribute_code === "user_email" && $attribute->attribute_index === "UNIQUE") {
                            $localAuthApi .= "/*".PHP_EOL;
                            $localAuthApi .= "| -------------------------------------------------------------------------".PHP_EOL;
                            $localAuthApi .= "| EMAIL LOGIN API".PHP_EOL;
                            $localAuthApi .= "| -------------------------------------------------------------------------".PHP_EOL;
                            $localAuthApi .= "*/".PHP_EOL.PHP_EOL;
                            $localAuthApi .= "1. URL                      :   ".$localDomainUrl."index.php/api/auth/emailLogin".PHP_EOL;
                            $localAuthApi .= "2. METHOD                   :   POST".PHP_EOL;
                            $localAuthApi .= "3. HEADERS                  :   Content-Type : application/json".PHP_EOL;
                            $localAuthApi .= "4. REQUEST PARAMETER'S      :   No-Params".PHP_EOL;
                            $localAuthApi .= "5. POST BODY".PHP_EOL;
                            $localAuthApi .= "   {".PHP_EOL;
                            $localAuthApi .= "      ".$var1."user_email".$var1.":".$var1.$var1.PHP_EOL;
                            $localAuthApi .= "      ".$var1."user_password".$var1.":".$var1.$var1.PHP_EOL;
                            $localAuthApi .= "   }".PHP_EOL;
                            $localAuthApi .= "6. RESPONSE".PHP_EOL;
                            $localAuthApi .= "    {".PHP_EOL;
                            $localAuthApi .= "      ".$var1."Authorization_Token".$var1.":".$var1."<TOKEN>".$var1.PHP_EOL;
                            $localAuthApi .= "    }".PHP_EOL;
                            $localAuthApi .= "7. RESPONSE CODE            :   200".PHP_EOL.PHP_EOL;
                        } else if($attribute->attribute_code === "user_mobile" && $attribute->attribute_index === "UNIQUE") {
                            $localAuthApi .= "/*".PHP_EOL;
                            $localAuthApi .= "| -------------------------------------------------------------------------".PHP_EOL;
                            $localAuthApi .= "| MOBILE LOGIN API".PHP_EOL;
                            $localAuthApi .= "| -------------------------------------------------------------------------".PHP_EOL;
                            $localAuthApi .= "*/".PHP_EOL.PHP_EOL;
                            $localAuthApi .= "1. URL                      :   ".$localDomainUrl."index.php/api/auth/mobileLogin".PHP_EOL;
                            $localAuthApi .= "2. METHOD                   :   POST".PHP_EOL;
                            $localAuthApi .= "3. HEADERS                  :   Content-Type : application/json".PHP_EOL;
                            $localAuthApi .= "4. REQUEST PARAMETER'S      :   No-Params".PHP_EOL;
                            $localAuthApi .= "5. POST BODY".PHP_EOL;
                            $localAuthApi .= "   {".PHP_EOL;
                            $localAuthApi .= "      ".$var1."user_mobile".$var1.":".$var1.$var1.PHP_EOL;
                            $localAuthApi .= "      ".$var1."user_password".$var1.":".$var1.$var1.PHP_EOL;
                            $localAuthApi .= "   }".PHP_EOL;
                            $localAuthApi .= "6. RESPONSE".PHP_EOL;
                            $localAuthApi .= "    {".PHP_EOL;
                            $localAuthApi .= "      ".$var1."Authorization_Token".$var1.":".$var1."<TOKEN>".$var1.PHP_EOL;
                            $localAuthApi .= "    }".PHP_EOL;
                            $localAuthApi .= "7. RESPONSE CODE            :   200".PHP_EOL.PHP_EOL;
                        }
                    }

                    # Forgot Password Api
                    $localAuthApi .= "/*".PHP_EOL;
                    $localAuthApi .= "| -------------------------------------------------------------------------".PHP_EOL;
                    $localAuthApi .= "| FORGOT PASSWORD API".PHP_EOL;
                    $localAuthApi .= "| -------------------------------------------------------------------------".PHP_EOL;
                    $localAuthApi .= "*/".PHP_EOL.PHP_EOL;
                    $localAuthApi .= "1. URL                      :   ".$localDomainUrl."index.php/api/auth/changepassword".PHP_EOL;
                    $localAuthApi .= "2. METHOD                   :   POST".PHP_EOL;
                    $localAuthApi .= "3. HEADERS                  :   Content-Type : application/json".PHP_EOL;
                    $localAuthApi .= "4. REQUEST PARAMETER'S      :   No-Params".PHP_EOL;
                    $localAuthApi .= "5. POST BODY".PHP_EOL;
                    $localAuthApi .= "   {".PHP_EOL;
                    $localAuthApi .= "      ".$var1."user_email".$var1.":".$var1.$var1.",".PHP_EOL;
                    $localAuthApi .= "      ".$var1."url".$var1.":".$var1.$var1.PHP_EOL;
                    $localAuthApi .= "   }".PHP_EOL;
                    $localAuthApi .= "6. RESPONSE                 :   An array".PHP_EOL;
                    $localAuthApi .= "7. RESPONSE CODE            :   200".PHP_EOL.PHP_EOL;

                    # Reset Password Api
                    $localAuthApi .= "/*".PHP_EOL;
                    $localAuthApi .= "| -------------------------------------------------------------------------".PHP_EOL;
                    $localAuthApi .= "| RESET PASSWORD API".PHP_EOL;
                    $localAuthApi .= "| -------------------------------------------------------------------------".PHP_EOL;
                    $localAuthApi .= "*/".PHP_EOL.PHP_EOL;
                    $localAuthApi .= "1. URL                      :   ".$localDomainUrl."index.php/api/auth/resetpassword".PHP_EOL;
                    $localAuthApi .= "2. METHOD                   :   POST".PHP_EOL;
                    $localAuthApi .= "3. HEADERS                  :   Content-Type : application/json".PHP_EOL;
                    $localAuthApi .= "4. REQUEST PARAMETER'S      :   No-Params".PHP_EOL;
                    $localAuthApi .= "5. POST BODY".PHP_EOL;
                    $localAuthApi .= "   {".PHP_EOL;
                    $localAuthApi .= "      ".$var1."user_email".$var1.":".$var1.$var1.",".PHP_EOL;
                    $localAuthApi .= "      ".$var1."new_password".$var1.":".$var1.$var1.",".PHP_EOL;
                    $localAuthApi .= "      ".$var1."repeat_password".$var1.":".$var1.$var1.PHP_EOL;
                    $localAuthApi .= "   }".PHP_EOL;
                    $localAuthApi .= "6. RESPONSE                 :   An array".PHP_EOL;
                    $localAuthApi .= "7. RESPONSE CODE            :   200".PHP_EOL.PHP_EOL;

                    # Change Password Api
                    $localAuthApi .= "/*".PHP_EOL;
                    $localAuthApi .= "| -------------------------------------------------------------------------".PHP_EOL;
                    $localAuthApi .= "| CHANGE PASSWORD API".PHP_EOL;
                    $localAuthApi .= "| -------------------------------------------------------------------------".PHP_EOL;
                    $localAuthApi .= "*/".PHP_EOL.PHP_EOL;
                    $localAuthApi .= "1. URL                      :   ".$localDomainUrl."index.php/api/auth/changepassword".PHP_EOL;
                    $localAuthApi .= "2. METHOD                   :   POST".PHP_EOL;
                    $localAuthApi .= "3. HEADERS                  :   Content-Type : application/json".PHP_EOL;
                    $localAuthApi .= "4. REQUEST PARAMETER'S      :   No-Params".PHP_EOL;
                    $localAuthApi .= "5. POST BODY".PHP_EOL;
                    $localAuthApi .= "   {".PHP_EOL;
                    $localAuthApi .= "      ".$var1."old_password".$var1.":".$var1.$var1.",".PHP_EOL;
                    $localAuthApi .= "      ".$var1."new_password".$var1.":".$var1.$var1.",".PHP_EOL;
                    $localAuthApi .= "      ".$var1."repeat_password".$var1.":".$var1.$var1.PHP_EOL;
                    $localAuthApi .= "   }".PHP_EOL;
                    $localAuthApi .= "6. RESPONSE".PHP_EOL;
                    $localAuthApi .= "    {".PHP_EOL;
                    $localAuthApi .= "      ".$var1."Authorization_Token".$var1.":".$var1."<TOKEN>".$var1.PHP_EOL;
                    $localAuthApi .= "    }".PHP_EOL;
                    $localAuthApi .= "7. RESPONSE CODE            :   200".PHP_EOL.PHP_EOL;

                    # Logout Api
                    $localAuthApi .= "/*".PHP_EOL;
                    $localAuthApi .= "| -------------------------------------------------------------------------".PHP_EOL;
                    $localAuthApi .= "| LOGOUT API".PHP_EOL;
                    $localAuthApi .= "| -------------------------------------------------------------------------".PHP_EOL;
                    $localAuthApi .= "*/".PHP_EOL.PHP_EOL;
                    $localAuthApi .= "1. URL                      :   ".$localDomainUrl."index.php/api/auth/logout".PHP_EOL;
                    $localAuthApi .= "2. METHOD                   :   GET".PHP_EOL;
                    $localAuthApi .= "3. HEADERS                  :   ".PHP_EOL;
                    $localAuthApi .= "4. REQUEST PARAMETER'S      :   ".PHP_EOL;
                    $localAuthApi .= "5. RESPONSE                 :   No-Content".PHP_EOL;
                    $localAuthApi .= "6. RESPONSE CODE            :   204".PHP_EOL.PHP_EOL;

                    # Create Api Doc File & Copy Content
                    file_put_contents($localApiDocPath, $localAuthApi, FILE_APPEND | LOCK_EX);
                    continue;
                }
            }
        
            # Rest Full Apis Heading
            $localApidoc .= "//*".PHP_EOL;
            $localApidoc .= "|| =========================================================================".PHP_EOL;
            $localApidoc .= "|| ".$tableName." REST APIS".PHP_EOL;
            $localApidoc .= "|| =========================================================================".PHP_EOL;
            $localApidoc .= "*//".PHP_EOL.PHP_EOL;

            # API 1 : Get Method
            $localApidoc .= "/*".PHP_EOL;
            $localApidoc .= "| ------------|".PHP_EOL;
            $localApidoc .= "|  GET Method |".PHP_EOL;
            $localApidoc .= "| ------------|".PHP_EOL;
            $localApidoc .= "*/".PHP_EOL;
            $localApidoc .= "1. URL                      :   ".$localDomainUrl."api/".$table->table_code.PHP_EOL;
            $localApidoc .= "2. METHOD                   :   GET".PHP_EOL;
            $localApidoc .= "3. HEADERS                  :   Content-Type : application/json, Authorization : token <token-after-login/register>".PHP_EOL;
            $localApidoc .= "4. REQUEST PARAMETER'S      :   ";
            if(!empty($primaryKey)) {
                if(json_decode($primaryKey->attribute_inputtype)->key !== "HIDE") {
                    $localApidoc .= $primaryKey->attribute_code."(optional), ";
                }
            }
            if(!empty($referenceKey) && ($referenceKey->attribute_code !== $primaryKey->attribute_code) ) {
                $localApidoc .= $referenceKey->attribute_code."(optional), ";
            }
            if(count($foreignKeys) > 0) {
                foreach($foreignKeys as $foreignKey) {
                    $localApidoc .= $foreignKey->attribute_code."(optional), ";
                }
            }
            $localApidoc .= "limit(optional), ";
            $localApidoc .= "start(optional)".PHP_EOL;
            $localApidoc .= "5. RESPONSE                 :   An array of records".PHP_EOL.PHP_EOL;
            # API 2 : POST Method
            $localApidoc .= "/*".PHP_EOL;
            $localApidoc .= "| -------------|".PHP_EOL;
            $localApidoc .= "|  POST Method |".PHP_EOL;
            $localApidoc .= "| -------------|".PHP_EOL;
            $localApidoc .= "*/".PHP_EOL;
            $localApidoc .= "1. URL                      :   ".$localDomainUrl."api/".$table->table_code."/create".PHP_EOL;
            $localApidoc .= "2. METHOD                   :   POST".PHP_EOL;
            $localApidoc .= "3. HEADERS                  :   Content-Type : application/json, Authorization : token <token-after-login/register>".PHP_EOL;
            $localApidoc .= "4. REQUEST PARAMETER'S      :   No-Params".PHP_EOL;
            $localApidoc .= "5. POST BODY".PHP_EOL;
            $localApidoc .= "    {".PHP_EOL;
            if(!empty($userFilledAttributes)) {
                foreach($userFilledAttributes as $userFilledAttribute) {
                    if (next($userFilledAttributes)==true) {
                        $localApidoc .= '      "'.$userFilledAttribute->attribute_code.'":"",'.PHP_EOL;                        
                    } else {
                        $localApidoc .= '      "'.$userFilledAttribute->attribute_code.'":"",'.PHP_EOL;
                    }                    
                }                
            }
            $localApidoc .= "    }".PHP_EOL;
            $localApidoc .= "6. RESPONSE                 :   Record in an array".PHP_EOL;
            $localApidoc .= "7. RESPONSE CODE            :   201".PHP_EOL.PHP_EOL;
            # API 3 : PUT Method
            $localApidoc .= "/*".PHP_EOL;
            $localApidoc .= "| ------------|".PHP_EOL;
            $localApidoc .= "|  PUT Method |".PHP_EOL;
            $localApidoc .= "| ------------|".PHP_EOL;
            $localApidoc .= "*/".PHP_EOL;
            $localApidoc .= "1. URL                      :   ".$localDomainUrl."api/".$table->table_code."/update/<id>".PHP_EOL;
            $localApidoc .= "2. METHOD                   :   PUT".PHP_EOL;
            $localApidoc .= "3. HEADERS                  :   Content-Type : application/json, Authorization : token <token-after-login/register>".PHP_EOL;
            $localApidoc .= "4. REQUEST PARAMETER'S      :   No-Params".PHP_EOL;
            $localApidoc .= "5. POST BODY".PHP_EOL;
            $localApidoc .= "    {".PHP_EOL;
            if(!empty($userFilledAttributes)) {
                foreach($userFilledAttributes as $userFilledAttribute) {
                    if (next($userFilledAttributes)==true) {
                        $localApidoc .= '      "'.$userFilledAttribute->attribute_code.'":"",'.PHP_EOL;                        
                    } else {
                        $localApidoc .= '      "'.$userFilledAttribute->attribute_code.'":"",'.PHP_EOL;
                    }                    
                }                
            }
            $localApidoc .= "    }".PHP_EOL;
            $localApidoc .= "6. RESPONSE                 :   Record in an array".PHP_EOL;
            $localApidoc .= "7. RESPONSE CODE            :   200".PHP_EOL.PHP_EOL;
            # API 4 : DELETE Method
            $localApidoc .= "/*".PHP_EOL;
            $localApidoc .= "| ---------------|".PHP_EOL;
            $localApidoc .= "|  DELETE Method |".PHP_EOL;
            $localApidoc .= "| ---------------|".PHP_EOL;
            $localApidoc .= "*/".PHP_EOL;
            $localApidoc .= "1. URL                      :   ".$localDomainUrl."api/".$table->table_code."/delete/<id>".PHP_EOL;
            $localApidoc .= "2. METHOD                   :   DELETE".PHP_EOL;
            $localApidoc .= "3. HEADERS                  :   Content-Type : application/json, Authorization : token <token-after-login/register>".PHP_EOL;
            $localApidoc .= "4. response                 :   No-Content".PHP_EOL.PHP_EOL;
            # API 5 : SEARCH Method
            $localApidoc .= "/*".PHP_EOL;
            $localApidoc .= "| ----------------|".PHP_EOL;
            $localApidoc .= "|  SEARCH Method  |".PHP_EOL;
            $localApidoc .= "| ----------------|".PHP_EOL;
            $localApidoc .= "*/".PHP_EOL;
            $localApidoc .= "1. URL                      :   ".$localDomainUrl."api/".$table->table_code."/search".PHP_EOL;
            $localApidoc .= "2. METHOD                   :   GET".PHP_EOL;
            $localApidoc .= "3. HEADERS                  :   Content-Type : application/json, Authorization : token <token-after-login/register>".PHP_EOL;
            $localApidoc .= "4. REQUEST PARAMETER'S      :   search(mandatory)".PHP_EOL;
            $localApidoc .= "5. RESPONSE                 :   An array of records".PHP_EOL.PHP_EOL;

            # Create Api Doc File & Copy Content
            file_put_contents($localApiDocPath, $localApidoc , FILE_APPEND | LOCK_EX);

        }

        return TRUE;
    }




















/* *************************************************************************************************************** */
/*  ###  Create Server Api Doc For Project  ###                                                                     */
/* *************************************************************************************************************** */

    /**
     * NOTE : Create Server Api Doc
     * 
     * @param   array       $tables - Tables
     * 
     * @param   string      $localApiDocPath - File Path
     * 
     * @param   string      $localDomainUrl - Domain Url
     * 
     * @param   object      $migrationsFeature - Migration Feature
     * 
     * @param   object      $authenticationFeature - Authentication Feature
     * 
     * @return  boolean     TRUE / FALSE
     */
    public function createServerApiDoc($tables, $serverApiDocPath, $serverDomainUrl, object $migrationsFeature, object $authenticationFeature)
    {
        # Migration Api - If Migration Feature Exist
        if($migrationsFeature->enable === "YES") {
            # Initialize String
            $migApi = "";

            $migApi .= "//*".PHP_EOL;
            $migApi .= "|| =========================================================================".PHP_EOL;
            $migApi .= "|| MIGRATION API".PHP_EOL;
            $migApi .= "|| =========================================================================".PHP_EOL;
            $migApi .= "*//".PHP_EOL.PHP_EOL;
            $migApi .= "1. URL                      :   ".$serverDomainUrl."index.php/migrate/db".PHP_EOL;
            $migApi .= "2. METHOD                   :   GET".PHP_EOL;
            $migApi .= "3. HEADERS                  :   ".PHP_EOL;
            $migApi .= "4. REQUEST PARAMETER'S      :   ".PHP_EOL;
            $migApi .= "5. RESPONSE                 :   Success".PHP_EOL.PHP_EOL;

            # Create Api Doc File & Copy Content
            file_put_contents($serverApiDocPath, $migApi, FILE_APPEND | LOCK_EX);
        }

        # Initialise Variables
        $var = "$";
        $var1 = '"';

        # Create Controllers For Each Table
        foreach($tables as $table) 
        {
            # Initialise Strings
            $serverApidoc = "";

            # Initialise Variables
            $var = "$";
            $var1 = '"';

            # Table Name / Model Name
            $tableName = $this->convertToTableName($table->table_code);

            # Get Attributes For Particular Table
            $attributes = Attribute::where('table_uuid',$table->uuid)->get();
        
            # Get Foreign Keys
            $foreignKeys = $this->getForeignKeyAttributes($table);

            # Get Primary Key
            $primaryKey = $this->getPrimaryKey($table);

            # Get Reference Key
            $referenceKey = $this->getReferenceKey($table);

            # Get Input Attributes Filled By Users
            $userFilledAttributes = $this->userFilledAttributes($table);

            # Get Mandatory Fields
            $mandatoryAttributes = $this->getMandatoryAttributes($table);

            # Auth User
            if($table->table_code === "users") {
                # If Authentication feature is enabled
                if($authenticationFeature->enable === "YES") {
                    # Initialize String
                    $serverAuthApi = "";

                    # Heading
                    $serverAuthApi .= "//*".PHP_EOL;
                    $serverAuthApi .= "|| =========================================================================".PHP_EOL;
                    $serverAuthApi .= "|| AUTH REST APIS".PHP_EOL;
                    $serverAuthApi .= "|| =========================================================================".PHP_EOL;
                    $serverAuthApi .= "*//".PHP_EOL.PHP_EOL;

                    # Registration Api
                    $serverAuthApi .= "/*".PHP_EOL;
                    $serverAuthApi .= "| -------------------------------------------------------------------------".PHP_EOL;
                    $serverAuthApi .= "| REGISTRATION API".PHP_EOL;
                    $serverAuthApi .= "| -------------------------------------------------------------------------".PHP_EOL;
                    $serverAuthApi .= "*/".PHP_EOL.PHP_EOL;
                    $serverAuthApi .= "1. URL                      :   ".$serverDomainUrl."index.php/api/auth/register".PHP_EOL;
                    $serverAuthApi .= "2. METHOD                   :   POST".PHP_EOL;
                    $serverAuthApi .= "3. HEADERS                  :   Content-Type : application/json".PHP_EOL;
                    $serverAuthApi .= "4. REQUEST PARAMETER'S      :   No-Params".PHP_EOL;
                    $serverAuthApi .= "5. POST BODY".PHP_EOL;
                    $serverAuthApi .= "   {".PHP_EOL;
                    foreach($attributes as $attribute) {
                        if( ($attribute->attribute_code === "id") || ($attribute->attribute_code === "uuid") || ($attribute->attribute_code === "private_uuid") || ($attribute->attribute_code === "pw_seed") || ($attribute->attribute_code === "pw_hash") || ($attribute->attribute_code === "pw_algo") || json_decode($attribute->attribute_inputtype)->key === "CURRENT_DATE" || json_decode($attribute->attribute_inputtype)->key === "CURRENT_DATETIME" || json_decode($attribute->attribute_inputtype)->key === "CURRENT_TIMESTAMP" ) {
                            continue;
                        } else {
                            $serverAuthApi .= "      ".$var1.$attribute->attribute_code.$var1.":".$var1."".$var1.",".PHP_EOL;
                        }
                    }
                    $serverAuthApi .= "      ".$var1."user_password".$var1.":".$var1.$var1.PHP_EOL;
                    $serverAuthApi .= "   }".PHP_EOL;
                    $serverAuthApi .= "6. RESPONSE".PHP_EOL;
                    $serverAuthApi .= "    {".PHP_EOL;
                    $serverAuthApi .= "      ".$var1."Authorization_Token".$var1.":".$var1."<TOKEN>".$var1.PHP_EOL;
                    $serverAuthApi .= "    }".PHP_EOL;
                    $serverAuthApi .= "7. RESPONSE CODE            :   201".PHP_EOL.PHP_EOL;

                    # Login Api
                    foreach($attributes as $attribute) {
                        if($attribute->attribute_code === "user_name" && $attribute->attribute_index === "UNIQUE") {
                            $serverAuthApi .= "/*".PHP_EOL;
                            $serverAuthApi .= "| -------------------------------------------------------------------------".PHP_EOL;
                            $serverAuthApi .= "| NAME LOGIN API".PHP_EOL;
                            $serverAuthApi .= "| -------------------------------------------------------------------------".PHP_EOL;
                            $serverAuthApi .= "*/".PHP_EOL.PHP_EOL;
                            $serverAuthApi .= "1. URL                      :   ".$serverDomainUrl."index.php/api/auth/nameLogin".PHP_EOL;
                            $serverAuthApi .= "2. METHOD                   :   POST".PHP_EOL;
                            $serverAuthApi .= "3. HEADERS                  :   Content-Type : application/json".PHP_EOL;
                            $serverAuthApi .= "4. REQUEST PARAMETER'S      :   No-Params".PHP_EOL;
                            $serverAuthApi .= "5. POST BODY".PHP_EOL;
                            $serverAuthApi .= "   {".PHP_EOL;
                            $serverAuthApi .= "      ".$var1."user_name".$var1.":".$var1.$var1.PHP_EOL;
                            $serverAuthApi .= "      ".$var1."user_password".$var1.":".$var1.$var1.PHP_EOL;
                            $serverAuthApi .= "   }".PHP_EOL;
                            $serverAuthApi .= "6. RESPONSE".PHP_EOL;
                            $serverAuthApi .= "    {".PHP_EOL;
                            $serverAuthApi .= "      ".$var1."Authorization_Token".$var1.":".$var1."<TOKEN>".$var1.PHP_EOL;
                            $serverAuthApi .= "    }".PHP_EOL;
                            $serverAuthApi .= "7. RESPONSE CODE            :   200".PHP_EOL.PHP_EOL;
                        } else if($attribute->attribute_code === "user_email" && $attribute->attribute_index === "UNIQUE") {
                            $serverAuthApi .= "/*".PHP_EOL;
                            $serverAuthApi .= "| -------------------------------------------------------------------------".PHP_EOL;
                            $serverAuthApi .= "| EMAIL LOGIN API".PHP_EOL;
                            $serverAuthApi .= "| -------------------------------------------------------------------------".PHP_EOL;
                            $serverAuthApi .= "*/".PHP_EOL.PHP_EOL;
                            $serverAuthApi .= "1. URL                      :   ".$serverDomainUrl."index.php/api/auth/emailLogin".PHP_EOL;
                            $serverAuthApi .= "2. METHOD                   :   POST".PHP_EOL;
                            $serverAuthApi .= "3. HEADERS                  :   Content-Type : application/json".PHP_EOL;
                            $serverAuthApi .= "4. REQUEST PARAMETER'S      :   No-Params".PHP_EOL;
                            $serverAuthApi .= "5. POST BODY".PHP_EOL;
                            $serverAuthApi .= "   {".PHP_EOL;
                            $serverAuthApi .= "      ".$var1."user_email".$var1.":".$var1.$var1.PHP_EOL;
                            $serverAuthApi .= "      ".$var1."user_password".$var1.":".$var1.$var1.PHP_EOL;
                            $serverAuthApi .= "   }".PHP_EOL;
                            $serverAuthApi .= "6. RESPONSE".PHP_EOL;
                            $serverAuthApi .= "    {".PHP_EOL;
                            $serverAuthApi .= "      ".$var1."Authorization_Token".$var1.":".$var1."<TOKEN>".$var1.PHP_EOL;
                            $serverAuthApi .= "    }".PHP_EOL;
                            $serverAuthApi .= "7. RESPONSE CODE            :   200".PHP_EOL.PHP_EOL;
                        } else if($attribute->attribute_code === "user_mobile" && $attribute->attribute_index === "UNIQUE") {
                            $serverAuthApi .= "/*".PHP_EOL;
                            $serverAuthApi .= "| -------------------------------------------------------------------------".PHP_EOL;
                            $serverAuthApi .= "| MOBILE LOGIN API".PHP_EOL;
                            $serverAuthApi .= "| -------------------------------------------------------------------------".PHP_EOL;
                            $serverAuthApi .= "*/".PHP_EOL.PHP_EOL;
                            $serverAuthApi .= "1. URL                      :   ".$serverDomainUrl."index.php/api/auth/mobileLogin".PHP_EOL;
                            $serverAuthApi .= "2. METHOD                   :   POST".PHP_EOL;
                            $serverAuthApi .= "3. HEADERS                  :   Content-Type : application/json".PHP_EOL;
                            $serverAuthApi .= "4. REQUEST PARAMETER'S      :   No-Params".PHP_EOL;
                            $serverAuthApi .= "5. POST BODY".PHP_EOL;
                            $serverAuthApi .= "   {".PHP_EOL;
                            $serverAuthApi .= "      ".$var1."user_mobile".$var1.":".$var1.$var1.PHP_EOL;
                            $serverAuthApi .= "      ".$var1."user_password".$var1.":".$var1.$var1.PHP_EOL;
                            $serverAuthApi .= "   }".PHP_EOL;
                            $serverAuthApi .= "6. RESPONSE".PHP_EOL;
                            $serverAuthApi .= "    {".PHP_EOL;
                            $serverAuthApi .= "      ".$var1."Authorization_Token".$var1.":".$var1."<TOKEN>".$var1.PHP_EOL;
                            $serverAuthApi .= "    }".PHP_EOL;
                            $serverAuthApi .= "7. RESPONSE CODE            :   200".PHP_EOL.PHP_EOL;
                        }
                    }

                    # Forgot Password Api
                    $serverAuthApi .= "/*".PHP_EOL;
                    $serverAuthApi .= "| -------------------------------------------------------------------------".PHP_EOL;
                    $serverAuthApi .= "| FORGOT PASSWORD API".PHP_EOL;
                    $serverAuthApi .= "| -------------------------------------------------------------------------".PHP_EOL;
                    $serverAuthApi .= "*/".PHP_EOL.PHP_EOL;
                    $serverAuthApi .= "1. URL                      :   ".$serverDomainUrl."index.php/api/auth/changepassword".PHP_EOL;
                    $serverAuthApi .= "2. METHOD                   :   POST".PHP_EOL;
                    $serverAuthApi .= "3. HEADERS                  :   Content-Type : application/json".PHP_EOL;
                    $serverAuthApi .= "4. REQUEST PARAMETER'S      :   No-Params".PHP_EOL;
                    $serverAuthApi .= "5. POST BODY".PHP_EOL;
                    $serverAuthApi .= "   {".PHP_EOL;
                    $serverAuthApi .= "      ".$var1."user_email".$var1.":".$var1.$var1.",".PHP_EOL;
                    $serverAuthApi .= "      ".$var1."url".$var1.":".$var1.$var1.PHP_EOL;
                    $serverAuthApi .= "   }".PHP_EOL;
                    $serverAuthApi .= "6. RESPONSE                 :   An array".PHP_EOL;
                    $serverAuthApi .= "7. RESPONSE CODE            :   200".PHP_EOL.PHP_EOL;

                    # Reset Password Api
                    $serverAuthApi .= "/*".PHP_EOL;
                    $serverAuthApi .= "| -------------------------------------------------------------------------".PHP_EOL;
                    $serverAuthApi .= "| RESET PASSWORD API".PHP_EOL;
                    $serverAuthApi .= "| -------------------------------------------------------------------------".PHP_EOL;
                    $serverAuthApi .= "*/".PHP_EOL.PHP_EOL;
                    $serverAuthApi .= "1. URL                      :   ".$serverDomainUrl."index.php/api/auth/resetpassword".PHP_EOL;
                    $serverAuthApi .= "2. METHOD                   :   POST".PHP_EOL;
                    $serverAuthApi .= "3. HEADERS                  :   Content-Type : application/json".PHP_EOL;
                    $serverAuthApi .= "4. REQUEST PARAMETER'S      :   No-Params".PHP_EOL;
                    $serverAuthApi .= "5. POST BODY".PHP_EOL;
                    $serverAuthApi .= "   {".PHP_EOL;
                    $serverAuthApi .= "      ".$var1."user_email".$var1.":".$var1.$var1.",".PHP_EOL;
                    $serverAuthApi .= "      ".$var1."new_password".$var1.":".$var1.$var1.",".PHP_EOL;
                    $serverAuthApi .= "      ".$var1."repeat_password".$var1.":".$var1.$var1.PHP_EOL;
                    $serverAuthApi .= "   }".PHP_EOL;
                    $serverAuthApi .= "6. RESPONSE                 :   An array".PHP_EOL;
                    $serverAuthApi .= "7. RESPONSE CODE            :   200".PHP_EOL.PHP_EOL;

                    # Change Password Api
                    $serverAuthApi .= "/*".PHP_EOL;
                    $serverAuthApi .= "| -------------------------------------------------------------------------".PHP_EOL;
                    $serverAuthApi .= "| CHANGE PASSWORD API".PHP_EOL;
                    $serverAuthApi .= "| -------------------------------------------------------------------------".PHP_EOL;
                    $serverAuthApi .= "*/".PHP_EOL.PHP_EOL;
                    $serverAuthApi .= "1. URL                      :   ".$serverDomainUrl."index.php/api/auth/changepassword".PHP_EOL;
                    $serverAuthApi .= "2. METHOD                   :   POST".PHP_EOL;
                    $serverAuthApi .= "3. HEADERS                  :   Content-Type : application/json".PHP_EOL;
                    $serverAuthApi .= "4. REQUEST PARAMETER'S      :   No-Params".PHP_EOL;
                    $serverAuthApi .= "5. POST BODY".PHP_EOL;
                    $serverAuthApi .= "   {".PHP_EOL;
                    $serverAuthApi .= "      ".$var1."old_password".$var1.":".$var1.$var1.PHP_EOL;
                    $serverAuthApi .= "      ".$var1."new_password".$var1.":".$var1.$var1.PHP_EOL;
                    $serverAuthApi .= "      ".$var1."repeat_password".$var1.":".$var1.$var1.PHP_EOL;
                    $serverAuthApi .= "   }".PHP_EOL;
                    $serverAuthApi .= "6. RESPONSE".PHP_EOL;
                    $serverAuthApi .= "    {".PHP_EOL;
                    $serverAuthApi .= "      ".$var1."Authorization_Token".$var1.":".$var1."<TOKEN>".$var1.PHP_EOL;
                    $serverAuthApi .= "    }".PHP_EOL;
                    $serverAuthApi .= "7. RESPONSE CODE            :   200".PHP_EOL.PHP_EOL;

                    # Logout Api
                    $serverAuthApi .= "/*".PHP_EOL;
                    $serverAuthApi .= "| -------------------------------------------------------------------------".PHP_EOL;
                    $serverAuthApi .= "| LOGOUT API".PHP_EOL;
                    $serverAuthApi .= "| -------------------------------------------------------------------------".PHP_EOL;
                    $serverAuthApi .= "*/".PHP_EOL.PHP_EOL;
                    $serverAuthApi .= "1. URL                      :   ".$serverDomainUrl."index.php/api/auth/logout".PHP_EOL;
                    $serverAuthApi .= "2. METHOD                   :   GET".PHP_EOL;
                    $serverAuthApi .= "3. HEADERS                  :   ".PHP_EOL;
                    $serverAuthApi .= "4. REQUEST PARAMETER'S      :   ".PHP_EOL;
                    $serverAuthApi .= "5. RESPONSE                 :   No-Content".PHP_EOL;
                    $serverAuthApi .= "6. RESPONSE CODE            :   204".PHP_EOL.PHP_EOL;

                    # Create Api Doc File & Copy Content
                    file_put_contents($serverApiDocPath, $serverAuthApi, FILE_APPEND | LOCK_EX);
                    continue;
                }
            }
        
            # Rest Full Apis Heading
            $serverApidoc .= "//*".PHP_EOL;
            $serverApidoc .= "|| =========================================================================".PHP_EOL;
            $serverApidoc .= "|| ".$tableName." REST APIS".PHP_EOL;
            $serverApidoc .= "|| =========================================================================".PHP_EOL;
            $serverApidoc .= "*//".PHP_EOL.PHP_EOL;

            # API 1 : Get Method
            $serverApidoc .= "/*".PHP_EOL;
            $serverApidoc .= "| ------------|".PHP_EOL;
            $serverApidoc .= "|  GET Method |".PHP_EOL;
            $serverApidoc .= "| ------------|".PHP_EOL;
            $serverApidoc .= "*/".PHP_EOL;
            $serverApidoc .= "1. URL                      :   ".$serverDomainUrl."api/".$table->table_code.PHP_EOL;
            $serverApidoc .= "2. METHOD                   :   GET".PHP_EOL;
            $serverApidoc .= "3. HEADERS                  :   Content-Type : application/json, Authorization : token <token-after-login/register>".PHP_EOL;
            $serverApidoc .= "4. REQUEST PARAMETER'S      :   ";
            if(!empty($primaryKey)) {
                if(json_decode($primaryKey->attribute_inputtype)->key !== "HIDE") {
                    $serverApidoc .= $primaryKey->attribute_code."(optional), ";
                }
            }
            if(!empty($referenceKey) && ($referenceKey->attribute_code !== $primaryKey->attribute_code) ) {
                $serverApidoc .= $referenceKey->attribute_code."(optional), ";
            }
            if(count($foreignKeys) > 0) {
                foreach($foreignKeys as $foreignKey) {
                    $serverApidoc .= $foreignKey->attribute_code."(optional), ";
                }
            }
            $serverApidoc .= "limit(optional), ";
            $serverApidoc .= "start(optional)".PHP_EOL;
            $serverApidoc .= "5. RESPONSE                 :   An array of records".PHP_EOL.PHP_EOL;
            # API 2 : POST Method
            $serverApidoc .= "/*".PHP_EOL;
            $serverApidoc .= "| -------------|".PHP_EOL;
            $serverApidoc .= "|  POST Method |".PHP_EOL;
            $serverApidoc .= "| -------------|".PHP_EOL;
            $serverApidoc .= "*/".PHP_EOL;
            $serverApidoc .= "1. URL                      :   ".$serverDomainUrl."api/".$table->table_code."/create".PHP_EOL;
            $serverApidoc .= "2. METHOD                   :   POST".PHP_EOL;
            $serverApidoc .= "3. HEADERS                  :   Content-Type : application/json, Authorization : token <token-after-login/register>".PHP_EOL;
            $serverApidoc .= "4. REQUEST PARAMETER'S      :   No-Params".PHP_EOL;
            $serverApidoc .= "5. POST BODY".PHP_EOL;
            $serverApidoc .= "    {".PHP_EOL;
            if(!empty($userFilledAttributes)) {
                foreach($userFilledAttributes as $userFilledAttribute) {
                    if (next($userFilledAttributes)==true) {
                        $serverApidoc .= '      "'.$userFilledAttribute->attribute_code.'":"",'.PHP_EOL;                        
                    } else {
                        $serverApidoc .= '      "'.$userFilledAttribute->attribute_code.'":"",'.PHP_EOL;
                    }                    
                }                
            }
            $serverApidoc .= "    }".PHP_EOL;
            $serverApidoc .= "6. RESPONSE                 :   Record in an array".PHP_EOL;
            $serverApidoc .= "7. RESPONSE CODE            :   201".PHP_EOL.PHP_EOL;
            # API 3 : PUT Method
            $serverApidoc .= "/*".PHP_EOL;
            $serverApidoc .= "| ------------|".PHP_EOL;
            $serverApidoc .= "|  PUT Method |".PHP_EOL;
            $serverApidoc .= "| ------------|".PHP_EOL;
            $serverApidoc .= "*/".PHP_EOL;
            if(!empty($referenceKey)) {
                $serverApidoc .= "1. URL                      :   ".$serverDomainUrl."api/".$table->table_code."/update/<".$referenceKey->attribute_code.">".PHP_EOL;
            } else {
                if(!empty($primaryKey)) {
                    $serverApidoc .= "1. URL                      :   ".$serverDomainUrl."api/".$table->table_code."/update/<".$primaryKey->attribute_code.">".PHP_EOL;
                }
            }
            $serverApidoc .= "2. METHOD                   :   PUT".PHP_EOL;
            $serverApidoc .= "3. HEADERS                  :   Content-Type : application/json, Authorization : token <token-after-login/register>".PHP_EOL;
            $serverApidoc .= "4. REQUEST PARAMETER'S      :   No-Params".PHP_EOL;
            $serverApidoc .= "5. POST BODY".PHP_EOL;
            $serverApidoc .= "    {".PHP_EOL;
            if(!empty($userFilledAttributes)) {
                foreach($userFilledAttributes as $userFilledAttribute) {
                    if (next($userFilledAttributes)==true) {
                        $serverApidoc .= '      "'.$userFilledAttribute->attribute_code.'":"",'.PHP_EOL;                        
                    } else {
                        $serverApidoc .= '      "'.$userFilledAttribute->attribute_code.'":"",'.PHP_EOL;
                    }                    
                }                
            }
            $serverApidoc .= "    }".PHP_EOL;
            $serverApidoc .= "6. RESPONSE                 :   Record in an array".PHP_EOL;
            $serverApidoc .= "7. RESPONSE CODE            :   200".PHP_EOL.PHP_EOL;
            # API 4 : DELETE Method
            $serverApidoc .= "/*".PHP_EOL;
            $serverApidoc .= "| ---------------|".PHP_EOL;
            $serverApidoc .= "|  DELETE Method |".PHP_EOL;
            $serverApidoc .= "| ---------------|".PHP_EOL;
            $serverApidoc .= "*/".PHP_EOL;
            if(!empty($referenceKey)) {
                $serverApidoc .= "1. URL                      :   ".$serverDomainUrl."api/".$table->table_code."/delete/<".$referenceKey->attribute_code.">".PHP_EOL;
            } else {
                if(!empty($primaryKey)) {
                    $serverApidoc .= "1. URL                      :   ".$serverDomainUrl."api/".$table->table_code."/delete/<".$primaryKey->attribute_code.">".PHP_EOL;
                }
            }
            $serverApidoc .= "2. METHOD                   :   DELETE".PHP_EOL;
            $serverApidoc .= "3. HEADERS                  :   Content-Type : application/json, Authorization : token <token-after-login/register>".PHP_EOL;
            $serverApidoc .= "4. response                 :   No-Content".PHP_EOL.PHP_EOL;
            # API 5 : SEARCH Method
            $serverApidoc .= "/*".PHP_EOL;
            $serverApidoc .= "| ----------------|".PHP_EOL;
            $serverApidoc .= "|  SEARCH Method  |".PHP_EOL;
            $serverApidoc .= "| ----------------|".PHP_EOL;
            $serverApidoc .= "*/".PHP_EOL;
            $serverApidoc .= "1. URL                      :   ".$serverDomainUrl."api/".$table->table_code."/search".PHP_EOL;
            $serverApidoc .= "2. METHOD                   :   GET".PHP_EOL;
            $serverApidoc .= "3. HEADERS                  :   Content-Type : application/json, Authorization : token <token-after-login/register>".PHP_EOL;
            $serverApidoc .= "4. REQUEST PARAMETER'S      :   search(mandatory)".PHP_EOL;
            $serverApidoc .= "5. RESPONSE                 :   An array of records".PHP_EOL.PHP_EOL;

            # Create Api Doc File & Copy Content
            file_put_contents($serverApiDocPath, $serverApidoc , FILE_APPEND | LOCK_EX);

        }

        return TRUE;
    }




















/* *************************************************************************************************************** */
/*  ###  Project Guide / Project Installation Steps  ###                                                           */
/* *************************************************************************************************************** */

    /**
     * NOTE : Project Guide / Project Installation Steps
     *
     * @param   string    $installationStepsPath - Project Installation Steps Path
     * 
     * @return  Create File & return true/false
     */
    public function createlocalInstallationSteps($installationStepsPath, $localDomainUrl)
    {
        # Initialise Strings
        $string = "";

        # Create Controllers File & Copy Content
        $save = file_put_contents($installationStepsPath, $string , FILE_APPEND | LOCK_EX);   
        if(!$save) {
            return false;
        }

        return true;
    }




















/* *************************************************************************************************************** */
/*  ###  Project Guide / Project Installation Steps  ###                                                           */
/* *************************************************************************************************************** */

    /**
     * NOTE : Project Guide / Project Installation Steps
     *
     * @param   string    $installationStepsPath - Project Installation Steps Path
     * 
     * @return  Create File & return true/false
     */
    public function createserverInstallationSteps($installationStepsPath, $serverDomainUrl)
    {
        # Initialise Strings
        $string = "";

        # Create Controllers File & Copy Content
        $save = file_put_contents($installationStepsPath, $string , FILE_APPEND | LOCK_EX);   
        if(!$save) {
            return false;
        }

        return true;
    }






























/* *************************************************************************************************************** */
/*  ###  Get Foreign Key Tables   ###                                                                                    */
/* *************************************************************************************************************** */

    /**
     * NOTE : Get Foreign Keys Tables - For A Given Table
     *
     * @param   object    $table - All Tables
     * 
     * @return  array     $data
     */
    public function getForeignKeyTables(object $table)
    {
        # Get Attributes
        $attributes =  Attribute::where('table_uuid',$table->uuid)->get();
        
        # Initialize array
        $data = [];

        # Get Foreign Keys
        foreach($attributes as $attribute) {
            if(json_decode($attribute->attribute_inputtype)->key === "FOREIGN_KEY") {
                $getForeignTables = Table::where('uuid',json_decode($attribute->attribute_inputtype)->value)->get();
                foreach($getForeignTables as $getForeignTable) {
                    $getForeignTable = $getForeignTable;
                }
                $data[] = $getForeignTable;
            }
        }

        return $data;
    }

/* *************************************************************************************************************** */
/*  ###  Get Foreign Key Attributes   ###                                                                                    */
/* *************************************************************************************************************** */

    /**
     * NOTE : Get Foreign Key Attributes - For A Given Table
     *
     * @param   object    $table - All Tables
     * 
     * @return  array     $data
     */
    public function getForeignKeyAttributes(object $table)
    {
        # Get Attributes
        $attributes =  Attribute::where('table_uuid',$table->uuid)->get();
        
        # Initialize array
        $data = [];

        # Get Foreign Keys
        foreach($attributes as $attribute) {
            if(json_decode($attribute->attribute_inputtype)->key === "FOREIGN_KEY") {
                $getForeignTables = Table::where('uuid',json_decode($attribute->attribute_inputtype)->value)->get();
                foreach($getForeignTables as $getForeignTable) {
                    $attribute->table_info = $getForeignTable;
                    $data[] = $attribute;
                }
            }
        }

        return $data;
    }
        
/* *************************************************************************************************************** */
/*  ###  Get Primary Key   ###                                                                                     */
/* *************************************************************************************************************** */

    /**
     * NOTE : Get Primary Key - For A Given Table
     *
     * @param   object     $table - All Tables
     * 
     * @return  object     $data
     */
    public function getPrimaryKey(object $table)
    {
        # Get Attributes
        $attributes =  Attribute::where('table_uuid',$table->uuid)->get();
        
        # Get Foreign Keys
        foreach($attributes as $attribute) {
            if($attribute->attribute_index === "PRIMARY" || $attribute->attribute_autoincrement === "1" || $attribute->attribute_autoincrement === "on") {
                return $attribute;
            }
        }

        return $attribute ?? '';
    }
           
/* *************************************************************************************************************** */
/*  ###  Get Reference Key   ###                                                                                     */
/* *************************************************************************************************************** */

    /**
     * NOTE : Get Reference Key - For A Given Table
     *
     * @param   array     $table - All Tables
     * 
     * @return  object     $data
     */
    public function getReferenceKey(object $table)
    {
        # Initialize variable
        $data = "";

        # Get Attributes
        $attributes =  Attribute::where('table_uuid',$table->uuid)->get();
        
        # Get Reference Keys
        foreach($attributes as $attribute) {
            if(json_decode($attribute->attribute_inputtype)->key === "REFERENCE_KEY_UUID" || json_decode($attribute->attribute_inputtype)->key === "REFERENCE_KEY") {
                $data = $attribute;
            }
        }

        return $data ?? '';
    }
          
/* *************************************************************************************************************** */
/*  ###  Get User Filled Attributes   ###                                                                                     */
/* *************************************************************************************************************** */

    /**
     * NOTE : Get User Filled Attributes - For A Given Table
     *
     * @param   object     $table - All Tables
     * 
     * @return  object     $data
     */
    public function userFilledAttributes(object $table)
    {
        # Get Attributes
        $attributes =  Attribute::where('table_uuid',$table->uuid)->get();
        
        # Get Reference Keys
        foreach($attributes as $attribute) {
            if(
                json_decode($attribute->attribute_inputtype)->key === "REFERENCE_KEY_UUID" || 
                json_decode($attribute->attribute_inputtype)->key === "UUID" ||
                $attribute->attribute_autoincrement === "on" ||
                $attribute->attribute_autoincrement === "1" ||
                json_decode($attribute->attribute_inputtype)->key === "CURRENT_DATE" ||
                json_decode($attribute->attribute_inputtype)->key === "CURRENT_DATETIME" ||
                json_decode($attribute->attribute_inputtype)->key === "CURRENT_TIMESTAMP"
            ) {
                continue;
            } else {
                $data[] = $attribute;
            }
        }

        return $data ?? [];
    }
        
/* *************************************************************************************************************** */
/*  ###  Get Mandatory Attributes   ###                                                                                     */
/* *************************************************************************************************************** */

    /**
     * NOTE : Get Mandatory Attributes - For A Given Table
     *
     * @param   object     $table - All Tables
     * 
     * @return  object     $data
     */
    public function getMandatoryAttributes(object $table)
    {
        # Get Attributes
        $attributes =  Attribute::where('table_uuid',$table->uuid)->get();
        
        # Get Reference Keys
        foreach($attributes as $attribute) {
            if(
                $attribute->attribute_null === "on" ||
                $attribute->attribute_null === "1" ||
                $attribute->attribute_index === "PRIMARY" || 
                $attribute->attribute_autoincrement === "on" ||
                $attribute->attribute_autoincrement === "1" ||
                json_decode($attribute->attribute_inputtype)->key === "REFERENCE_KEY_UUID" || 
                json_decode($attribute->attribute_inputtype)->key === "UUID" ||                
                json_decode($attribute->attribute_inputtype)->key === "CURRENT_DATE" ||
                json_decode($attribute->attribute_inputtype)->key === "CURRENT_DATETIME" ||
                json_decode($attribute->attribute_inputtype)->key === "CURRENT_TIMESTAMP"
            ) {
                continue;
            } else {
                $data[] = $attribute;
            }
        }

        return $data ?? [];
    }
         
/* *************************************************************************************************************** */
/*  ###  Get Un-Hide Attributes   ###                                                                                     */
/* *************************************************************************************************************** */

    /**
     * NOTE : Get Un-Hide Attributes - For A Given Table
     *
     * @param   object     $table - All Tables
     * 
     * @return  object     $data
     */
    public function getUnHideAttributes(object $table)
    {
        # Get Attributes
        $attributes =  Attribute::where('table_uuid',$table->uuid)->get();
        
        # Get Reference Keys
        foreach($attributes as $attribute) {
            if(json_decode($attribute->attribute_inputtype)->key === "HIDE") {
                continue;
            } else {
                $data[] = $attribute;
            }
        }

        return $data ?? [];
    }

/* *************************************************************************************************************** */
/*  ###  Get User Filled Attributes To Update   ###                                                                                     */
/* *************************************************************************************************************** */

    /**
     * NOTE : Get User Filled Attributes To Update - For A Given Table
     *
     * @param   object     $table - Table
     * 
     * @return  object     $data
     */
    public function userUpdateFilledAttributes(object $table)
    {
        # Get Attributes
        $attributes =  Attribute::where('table_uuid',$table->uuid)->get();
        
        # Get Reference Keys
        foreach($attributes as $attribute) {
            if(
                $attribute->attribute_code === "pw_seed" ||
                $attribute->attribute_code === "pw_hash" ||
                $attribute->attribute_code === "pw_algo" ||
                $attribute->attribute_code === "private_uuid" ||
                $attribute->attribute_index === "PRIMARY" ||
                json_decode($attribute->attribute_inputtype)->key === "REFERENCE_KEY" ||
                json_decode($attribute->attribute_inputtype)->key === "REFERENCE_KEY_UUID" ||
                $attribute->attribute_autoincrement === "on" ||
                $attribute->attribute_autoincrement === "1" ||
                json_decode($attribute->attribute_inputtype)->key === "CURRENT_DATE" ||
                json_decode($attribute->attribute_inputtype)->key === "CURRENT_DATETIME" ||
                json_decode($attribute->attribute_inputtype)->key === "CURRENT_TIMESTAMP"
            ) {
                continue;
            } else {
                $data[] = $attribute;
            }
        }

        return $data ?? [];
    }

/* *************************************************************************************************************** */
/*  ###  Convert Any Code To Model Name Format   ###                                                               */
/* *************************************************************************************************************** */

    /**
     * NOTE : Convert Table Code To Model Name Format
     * 
     * RULES : - First Letter Will Be Capital
     *         - No Emty Spaces
     *         - Empty Spaces Are Removed & replace With Next Letter Capital
     *
     * @param   string    $code
     * 
     * @return  string    $data
     */
    public function convertToModelName($code)
    {
        $data = str_replace(" ", "", ucwords(str_replace("_", " ", $code)));

        return $data;
    }

        
/* *************************************************************************************************************** */
/*  ###  Convert Any Code To Table Name Format   ###                                                               */
/* *************************************************************************************************************** */

    /**
     * NOTE : Convert Code To Model Name Format
     * 
     * RULES : - First Letter Will Be Capital
     *         - No Emty Spaces
     *         - Empty Spaces Are Removed & replace With Next Letter Capital
     *
     * @param   string    $code
     * 
     * @return  string    $data
     */
    public function convertToTableName($code)
    {
        $data = str_replace(" ", "", ucwords(str_replace("_", " ", $code)));

        return $data;
    }
        
}             