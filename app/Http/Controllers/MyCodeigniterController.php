<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\CodeigniterController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use ZipArchive;
use \RecursiveIteratorIterator;
use File;
use Auth;
use App\Project;
use App\Database;
use App\Table;
use App\Attribute;
use App\Feature;


class MyCodeigniterController extends CodeigniterController
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
     * NOTE : This method is called when generate Codeigniter is clicked.
     * 
     * @param       string      $project_uuid - Project UUID
     * 
     * @return
     */
    public function generate($project_uuid)
    {
        # Basic Step 1 : Get Auth User Info.
        $user = Auth::user();

        # Basic Step 2 : Get Project Info.
        $project = (new Project())->where('uuid', $project_uuid)->first();

        # Basic Step 3 : Get Features Info.
        $projectFeature = (new Feature())->where('project_uuid', $project_uuid)->where('feature_code', "PROJECT")->first();
        $controllersFeature = (new Feature())->where('project_uuid', $project_uuid)->where('feature_code', "CONTROLLERS")->first();
        $modelsFeature = (new Feature())->where('project_uuid', $project_uuid)->where('feature_code', "MODELS")->first();
        $migrationsFeature = (new Feature())->where('project_uuid', $project_uuid)->where('feature_code', "MIGRATIONS")->first();
        $routingFeature = (new Feature())->where('project_uuid', $project_uuid)->where('feature_code', "ROUTING")->first();
        $authenticationFeature = (new Feature())->where('project_uuid', $project_uuid)->where('feature_code', "AUTHENTICATION")->first();
        $apiDocumentFeature = (new Feature())->where('project_uuid', $project_uuid)->where('feature_code', "APIDOCUMENT")->first();
        $installationStepsFeature = (new Feature())->where('project_uuid', $project_uuid)->where('feature_code', "INSTALLATIONSTEPS")->first();

        # Basic Step 4 : Get Database Info.
        $database = (new Database())->where('project_uuid', $project_uuid)->first();
        
        # Basic Step 5 : Get All Tables
        $tables = (new Table())->where('project_uuid', $project_uuid)->get();

        ### Basic Step 6 : Local Domain
        $localDomainName = strtolower(str_replace(' ', '', ucwords($project->local_domain_name)));
        $localProtocol = strtolower($project->local_protocol);
        if( strlen($project->local_portno) > 0 ) {
            $localDomainUrl = $localProtocol."://".$localDomainName.":".$project->local_portno."/";
        } else {
            $localDomainUrl = $localProtocol."://".$localDomainName."/";
        }

        ### Basic Step 7 : Server Domain
        $serverDomainName = strtolower(str_replace(' ', '', ucwords($project->server_domain_name)));
        $serverProtocol = strtolower($project->server_protocol);
        if( strlen($project->server_portno) > 0 ) {
            $serverDomainUrl = $serverProtocol."://".$serverDomainName.":".$project->server_portno."/";
        } else {
            $serverDomainUrl = $serverProtocol."://".$serverDomainName."/";
        }




















        /* ****************************************************************************************************** */
        /* BASIC STEPS FOR AUTOGENCODE                                                                            */
        /* ****************************************************************************************************** */

        # Storage Path With App
        $path = app('path.storage').DIRECTORY_SEPARATOR.('app');

        # Create Users Folder If Does Not Exist.
        # Its Mandatory To Exist Users Folder.
        # Where all users folders are created.
        $usersFolder = $path.DIRECTORY_SEPARATOR.'users';
        if (!file_exists($usersFolder)) {
            Storage::makeDirectory('users');
        }

        # Create Folder For Current User With Code If Does Not Exist.
        $userDirectory = $usersFolder.DIRECTORY_SEPARATOR.$user->code;
        if (!file_exists($userDirectory)) {
            Storage::makeDirectory('users'.DIRECTORY_SEPARATOR.$user->code);
        }

        # Create Codeigniter Folder For Current User If Does Not Exist
        $codeigniterDirectory = $userDirectory.DIRECTORY_SEPARATOR.'codeigniter';
        if (!file_exists($codeigniterDirectory)) {
            Storage::makeDirectory('users'.DIRECTORY_SEPARATOR.$user->code.DIRECTORY_SEPARATOR.'codeigniter');
        }

        # Delete Project Folder Of Current User If Exist.
        # Create Project Folder For Current User If Does Not Exist.
        $projectDirectory = $codeigniterDirectory.DIRECTORY_SEPARATOR.$project->project_code;
        if (file_exists($projectDirectory)) {
            File::deleteDirectory($projectDirectory);
            Storage::makeDirectory('users'.DIRECTORY_SEPARATOR.$user->code.DIRECTORY_SEPARATOR.'codeigniter'.DIRECTORY_SEPARATOR.$project->project_code);
        } else {
            Storage::makeDirectory('users'.DIRECTORY_SEPARATOR.$user->code.DIRECTORY_SEPARATOR.'codeigniter'.DIRECTORY_SEPARATOR.$project->project_code);
        }

        # Create Agc Document Folder
        $agcDocument = $localApiDocPath = $projectDirectory.DIRECTORY_SEPARATOR.'agc documentation';
        if (file_exists($agcDocument)) {
            File::deleteDirectory($agcDocument);
            Storage::makeDirectory('users'.DIRECTORY_SEPARATOR.$user->code.DIRECTORY_SEPARATOR.'codeigniter'.DIRECTORY_SEPARATOR.$project->project_code.DIRECTORY_SEPARATOR.'agc documentation');
        } else {
            Storage::makeDirectory('users'.DIRECTORY_SEPARATOR.$user->code.DIRECTORY_SEPARATOR.'codeigniter'.DIRECTORY_SEPARATOR.$project->project_code.DIRECTORY_SEPARATOR.'agc documentation');
        }




















        /* ****************************************************************************************************** */
        /* Step 1 : Create Codeigniter Project. ( NOTE : ONLY IF PROJECT FEATURE IS ENABLED )                                                                       */
        /* ****************************************************************************************************** */

        # check project feature is enabled to yes
        if($projectFeature->enable === "YES") 
        {
            # Codeigniter Skeleton Path.
            $codeigniterSkeletonPath = app('path.storage').DIRECTORY_SEPARATOR.'frameworks'.DIRECTORY_SEPARATOR.'codeigniter';
            
            # Copy Codeigniter Skeleton Project To Main Project.
            $copy = (new Filesystem())->copyDirectory($codeigniterSkeletonPath, $projectDirectory, $overwrite = true);
            
            # Get Config Path.
            $configFilePath = $projectDirectory.DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

            # Modify Config File - with local & commented server domain url.
            $modifyConfigFile = (new CodeigniterController())->modifyConfigFile($configFilePath,$localDomainUrl,$serverDomainUrl);
            
            # Get Database Path & Delete 'Database' File If Exist.
            $databaseFilePath = $projectDirectory.DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'database.php';
            if (file_exists($projectDirectory)) {
                File::delete($databaseFilePath);
            }

            # Create 'Database' File
            $createDatabaseFile = (new CodeigniterController())->createDatabaseFile($database);
            file_put_contents($databaseFilePath, $createDatabaseFile.PHP_EOL , FILE_APPEND | LOCK_EX);
        }




















        /* ****************************************************************************************************** */
        /* Step 2 : Create All Types Of Controllers ( NOTE : ONLY IF CONTROLLERS FEATURE IS ENABLED )             */
        /* ****************************************************************************************************** */
        
        # Controllers Directory.
        $controllersDirectory = $projectDirectory.DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.'api';
            
        # Delete Controllers Directory If Exist.
        if (file_exists($controllersDirectory)) {
            File::deleteDirectory($controllersDirectory);
        }

        # check controllers feature is enabled to yes.
        if($controllersFeature->enable === "YES" || $authenticationFeature->enable === "YES" || $migrationsFeature->enable === "YES") {
            Storage::makeDirectory('users'.DIRECTORY_SEPARATOR.$user->code.DIRECTORY_SEPARATOR.'codeigniter'.DIRECTORY_SEPARATOR.$project->project_code.DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.'api');
        }

        # Create Auth Directory If Does Not Exist.
        $authControllerDirectory = $controllersDirectory.DIRECTORY_SEPARATOR."auth";
        if($authenticationFeature->enable === "YES") {
            Storage::makeDirectory('users'.DIRECTORY_SEPARATOR.$user->code.DIRECTORY_SEPARATOR.'codeigniter'.DIRECTORY_SEPARATOR.$project->project_code.DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.'api'.DIRECTORY_SEPARATOR.'auth');
        }

        # Create Controllers.
        $createControllers = (new CodeigniterController())->createControllers($tables, $controllersDirectory, $authControllerDirectory, $controllersFeature, $authenticationFeature, $project->project_name);
              
        # Create Migration Controller File If Migration Feature Is Enabled.
        if($migrationsFeature->enable === "YES") {
            # Create Migration Controller File If Does Not Exist.
            $migrationCtrlFilePath = $projectDirectory.DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.'api'.DIRECTORY_SEPARATOR.'MigrationController.php';
            
            # Create Migrations Controller For Project.
            $createMigrationCtrl = (new CodeigniterController())->createMigrationCtrl($migrationCtrlFilePath);
        }

        # Create Auth Controllers If Authentication Feature Is Enabled.
        if($authenticationFeature->enable === "YES") {
            
            # Create Register Controller
            $registerCntlFilePath = $authControllerDirectory.DIRECTORY_SEPARATOR.'RegisterController.php';
            $createRegisterController = (new CodeigniterController())->createRegisterController($tables, $registerCntlFilePath, $project->project_name);

            # Create Login Controller
            $loginCntlFilePath = $authControllerDirectory.DIRECTORY_SEPARATOR.'LoginController.php';
            $createLoginController = (new CodeigniterController())->createLoginController($tables, $loginCntlFilePath, $project->project_name);

            # Create Change Password Controller
            $chgPassCntlFilePath = $authControllerDirectory.DIRECTORY_SEPARATOR.'ChangePasswordController.php';
            $createChangePasswordController = (new CodeigniterController())->createChangePasswordController($chgPassCntlFilePath, $project->project_name);

            # Create Forgot Password Controller
            $forPassCntlFilePath = $authControllerDirectory.DIRECTORY_SEPARATOR.'ForgotPasswordController.php';
            $createForgotPasswordController = (new CodeigniterController())->createForgotPasswordController($forPassCntlFilePath, $project->project_name);
            
            # Create Reset Password Controller
            $resetPassCntlFilePath = $authControllerDirectory.DIRECTORY_SEPARATOR.'ResetPasswordController.php';
            $createResetPasswordController = (new CodeigniterController())->createResetPasswordController($resetPassCntlFilePath, $project->project_name);

            # Create Logout Controller
            $logoutCntlFilePath = $authControllerDirectory.DIRECTORY_SEPARATOR.'LogoutController.php';
            $createLogoutController = (new CodeigniterController())->createLogoutController($logoutCntlFilePath, $project->project_name);

        }




















        /* ****************************************************************************************************** */
        /* Step 3 : Create All Types Of Models ( NOTE : ONLY IF MODELS FEATURE IS ENABLED )                       */
        /* ****************************************************************************************************** */
        
        # Models Directory
        $modelsDirectory = $projectDirectory.DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'models';
            
        # Delete Models Directory If Exist.
        if (file_exists($modelsDirectory)) {
            File::deleteDirectory($modelsDirectory);
        }

        # Check Models Directory If Model Feature OR Authentication Feature enabled to yes
        if($modelsFeature->enable === "YES" || $authenticationFeature->enable === "YES") {
            Storage::makeDirectory('users'.DIRECTORY_SEPARATOR.$user->code.DIRECTORY_SEPARATOR.'codeigniter'.DIRECTORY_SEPARATOR.$project->project_code.DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'models');
        }

        # Create Auth Directory If Does Not Exist.
        $authModelsDirectory = $modelsDirectory.DIRECTORY_SEPARATOR."auth";
        if($authenticationFeature->enable === "YES") {
            Storage::makeDirectory('users'.DIRECTORY_SEPARATOR.$user->code.DIRECTORY_SEPARATOR.'codeigniter'.DIRECTORY_SEPARATOR.$project->project_code.DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.'auth');
        }

        # Create Models.
        $createModels = (new CodeigniterController())->createModels($tables, $modelsDirectory, $authModelsDirectory, $modelsFeature, $authenticationFeature, $project->project_name);

        # Create Library Model - If Model / Authentication Feature Is Enabled
        if($modelsFeature->enable === "YES" || $authenticationFeature->enable === "YES" || $controllersFeature->enable === "YES") {
            $libraryFilePath = $modelsDirectory.DIRECTORY_SEPARATOR.'LibraryModel.php';
            $createLibraryModel = (new CodeigniterController())->createLibraryModel($tables, $libraryFilePath, $modelsFeature, $authenticationFeature, $project->project_name);
        }

        # Create Auth Models If Authentication Feature Is Enabled To Yes.
        if($authenticationFeature->enable === "YES") {
            
            # Create Register Model
            $registerModelFilePath = $authModelsDirectory.DIRECTORY_SEPARATOR.'RegisterModel.php';
            $createRegisterModel = (new CodeigniterController())->createRegisterModel($tables, $registerModelFilePath, $project->project_name);

            # Create Login Model
            $loginModelFilePath = $authModelsDirectory.DIRECTORY_SEPARATOR.'LoginModel.php';
            $createLoginModel = (new CodeigniterController())->createLoginModel($tables, $loginModelFilePath, $project->project_name);

            # Create Change Password Model
            $chgPassModelFilePath = $authModelsDirectory.DIRECTORY_SEPARATOR.'ChangePasswordModel.php';
            $createChangePasswordModel = (new CodeigniterController())->createChangePasswordModel($chgPassModelFilePath, $project->project_name);
            
            # Create Forgot Password  Model
            $forPassModelFilePath = $authModelsDirectory.DIRECTORY_SEPARATOR.'ForgotPasswordModel.php';
            $createForgotPasswordModel = (new CodeigniterController())->createForgotPasswordModel($forPassModelFilePath, $project->project_name);
  
            # Create Reset Password  Model
            $resetPassModelFilePath = $authModelsDirectory.DIRECTORY_SEPARATOR.'ResetPasswordModel.php';
            $createResetPasswordModel = (new CodeigniterController())->createResetPasswordModel($resetPassModelFilePath, $project->project_name);

            # Create Logout Model
            $logoutModelFilePath = $authModelsDirectory.DIRECTORY_SEPARATOR.'LogoutModel.php';
            $createLogoutModel = (new CodeigniterController())->createLogoutModel($logoutModelFilePath, $project->project_name);

        }




















        /* ****************************************************************************************************** */
        /* Step 4 : Create Migrations ( NOTE : ONLY IF MIGRATIONS FEATURE IS ENABLED )                              */
        /* ****************************************************************************************************** */
        
        # check migrations feature is enabled to yes
        if($migrationsFeature->enable === "YES") {
            
            # Migrations Directory.
            $migrationDirectory = $projectDirectory.DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'migrations';
            
            # Delete Migrations Directory If Exist.
            if (file_exists($migrationDirectory)) {
                File::deleteDirectory($migrationDirectory);
                Storage::makeDirectory('users'.DIRECTORY_SEPARATOR.$user->code.DIRECTORY_SEPARATOR.'codeigniter'.DIRECTORY_SEPARATOR.$project->project_code.DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'migrations');
            } else {
                Storage::makeDirectory('users'.DIRECTORY_SEPARATOR.$user->code.DIRECTORY_SEPARATOR.'codeigniter'.DIRECTORY_SEPARATOR.$project->project_code.DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'migrations');
            }

            # Create Migrations For Each Table.
            $createMigrations = (new CodeigniterController())->createMigrations($tables, $migrationDirectory, $authenticationFeature);

            # Create Default Migrations If Authentication Feature Is Enabled
            if($authenticationFeature->enable === "YES") {
                $createDefaultMigrations = (new CodeigniterController())->createDefaultMigrations($migrationDirectory);
            }
        }

        


















        /* ****************************************************************************************************** */
        /* Step 5 : Create Routings ( NOTE : ONLY IF ROUTING FEATURE IS ENABLED )                              */
        /* ****************************************************************************************************** */
                
        # Create routes.php File if Does Not Exist / Delete Default routes.php File If Exist.
        $routesPath = $projectDirectory.DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'routes.php';
        if (file_exists($routesPath)) {
            File::delete($routesPath);
        }

        # Create A Basic Route File
        $basicRoute = (new CodeigniterController())->basicRoute($routesPath);
        
        # Create Routes For Project - As Per Enabled Feature.
        $createRoutes = (new CodeigniterController())->createRoutes($tables, $routesPath, $routingFeature, $migrationsFeature, $authenticationFeature);
        

        

















        /* ****************************************************************************************************** */
        /* Step 6 : Create Api Document ( NOTE : ONLY IF API DOCUMENT FEATURE IS ENABLED )                        */
        /* ****************************************************************************************************** */
        
        # check Api Document feature is enabled to yes
        if($apiDocumentFeature->enable === "YES") {
            
            # Delete An Api's Doc Folder If Exist & Create If Doesnot Exist.
            $apiDoc = $agcDocument.DIRECTORY_SEPARATOR."apis doc";
            if (file_exists($apiDoc)) {
                File::deleteDirectory($apiDoc);
                Storage::makeDirectory('users'.DIRECTORY_SEPARATOR.$user->code.DIRECTORY_SEPARATOR.'codeigniter'.DIRECTORY_SEPARATOR.$project->project_code.DIRECTORY_SEPARATOR.'agc documentation'.DIRECTORY_SEPARATOR."apis doc");
            } else {
                Storage::makeDirectory('users'.DIRECTORY_SEPARATOR.$user->code.DIRECTORY_SEPARATOR.'codeigniter'.DIRECTORY_SEPARATOR.$project->project_code.DIRECTORY_SEPARATOR.'agc documentation'.DIRECTORY_SEPARATOR."apis doc");
            }
            
            # Local Installation Steps & Server Installation Steps Path
            $localApiDocPath = $apiDoc.DIRECTORY_SEPARATOR."local_api_document.txt";
            $serverApiDocPath = $apiDoc.DIRECTORY_SEPARATOR."server_api_document.txt";

            # Create Api Document For Local - Project.
            $localApiDoc = (new CodeigniterController())->createLocalApiDoc($tables, $localApiDocPath, $localDomainUrl, $migrationsFeature, $authenticationFeature);
          
            # Create Api Document For Server - Project
            $serverApiDoc = (new CodeigniterController())->createServerApiDoc($tables, $serverApiDocPath, $serverDomainUrl, $migrationsFeature, $authenticationFeature);
          
        }




















        /* ****************************************************************************************************** */
        /* Step 7 : Write Installation Steps ( NOTE : ONLY IF INSTALLATION STEPS FEATURE IS ENABLED )                              */
        /* ****************************************************************************************************** */
        
        # check migrations feature is enabled to yes
        // if($installationStepsFeature->enable === "YES") {
            
        //     # Local Installation Steps Path
        //     $localInstallationStepsPath = $projectDirectory.DIRECTORY_SEPARATOR.'AGC DOCUMENTATION'.DIRECTORY_SEPARATOR."installation steps".DIRECTORY_SEPARATOR."local_installation_steps.txt";

        //     # Server Installation Steps Path
        //     $serverInstallationStepsPath = $projectDirectory.DIRECTORY_SEPARATOR.'AGC DOCUMENTATION'.DIRECTORY_SEPARATOR."installation steps".DIRECTORY_SEPARATOR."server_installation_steps.txt";

        //     # Create Local Installation Steps File If Does Not Exist.
        //     Storage::makeDirectory('users'.DIRECTORY_SEPARATOR.$user->code.DIRECTORY_SEPARATOR.'codeigniter'.DIRECTORY_SEPARATOR.$project->project_code.DIRECTORY_SEPARATOR.'AGC DOCUMENTATION'.DIRECTORY_SEPARATOR."installation steps".DIRECTORY_SEPARATOR."local_installation_steps.txt");
            
        //     # Create Server Installation Steps File If Does Not Exist.
        //     Storage::makeDirectory('users'.DIRECTORY_SEPARATOR.$user->code.DIRECTORY_SEPARATOR.'codeigniter'.DIRECTORY_SEPARATOR.$project->project_code.DIRECTORY_SEPARATOR.'AGC DOCUMENTATION'.DIRECTORY_SEPARATOR."installation steps".DIRECTORY_SEPARATOR."server_installation_steps.txt");
            
        //     # Create Installation Steps For Local - Project.
        //     $localInstallationSteps = (new CodeigniterController())->createlocalInstallationSteps($localInstallationStepsPath, $localDomainUrl);
          
        //     # Create Installation Steps For Server - Project.
        //     $serverInstallationSteps = (new CodeigniterController())->createserverInstallationSteps($serverInstallationStepsPath, $serverDomainUrl);
          
        // }




















        /* ****************************************************************************************************** */
        /* Step 7 : Archive & Download Project                                                                    */
        /* ****************************************************************************************************** */

        # Download file
        $files = glob($projectDirectory);
        \Zipper::make($projectDirectory.DIRECTORY_SEPARATOR.$project->project_name.'.zip')->add($files)->close();

        return response()->download($projectDirectory.DIRECTORY_SEPARATOR.$project->project_name.'.zip');
    }
 
}