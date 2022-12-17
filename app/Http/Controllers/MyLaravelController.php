<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\LaravelController;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use \RecursiveIteratorIterator;
use File;
use Auth;
use App\Project;
use App\Database;
use App\Table;
use App\Attribute;


class MyLaravelController extends LaravelController
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
     * NOTE : This method is called when generate laravel is clicked.
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
        $project = (new Project())->arrayToJson($project_uuid);

        # Basic Step 3 : Get Database Info
        $database = (new Database())->arrayToJson($project_uuid);

        # Basic Step 4 : Get All Tables
        $tables = (new Table())->fetchTables($database->uuid);

        # Basic Step 5 : Storage Path With App
        $path = app('path.storage').('\app');

        # Basic Step 6 : Path To Users Folder
        $usersFolder = $path.DIRECTORY_SEPARATOR.'users';
        
        # Basic Step 7 : User Directory
        $userDirectory = $usersFolder.DIRECTORY_SEPARATOR.$user->code;

        # Basic Step 8 : Project Directory
        $projectDirectory = $userDirectory.DIRECTORY_SEPARATOR.$project->project_code;

        # Basic Step 9 : Dot Env File Path
        $dotEnvFile = $projectDirectory.DIRECTORY_SEPARATOR.'.env';

        # Basic Step 10 : AppServiceProvider File Path
        $appServiceProviderPath = $projectDirectory.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Providers'.DIRECTORY_SEPARATOR.'AppServiceProvider.php';

        # Basic Step 11 : Database Migrations Path
        $migrationPath = $projectDirectory.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'migrations';

        # Basic Step 12 : Models Path
        $modelsPath = $projectDirectory.DIRECTORY_SEPARATOR.'app';

        # Basic Step 13 : Controllers Path
        $controllersPath = $projectDirectory.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Http'.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.'API';

        # Basic Step 14 : Routes Path - "routes/api.php"
        $routesPath = $projectDirectory.DIRECTORY_SEPARATOR.'routes'.DIRECTORY_SEPARATOR.'api.php';

        # Basic Step 15 : AGC Documentation Directory
        $agcDocDirectory = $projectDirectory.DIRECTORY_SEPARATOR.'AGC DOCUMENTATION';

        /* ****************************************************************************************************** */
        /* Step 1 : Create Laravel Project.                                                                       */
        /* ****************************************************************************************************** */

        # Step 1.1 : Create Users Folder If Does Not Exist
        if (!file_exists($usersFolder)) {
            Storage::makeDirectory('users');
        }

        # Step 1.2 : Create Folder For Current User With Code
        if (!file_exists($userDirectory)) {
            Storage::makeDirectory('users/'.$user->code);
        }

        # Step 1.3 : Change Directory To "$userDirectory"
        chdir($userDirectory);

        # Step 1.4 : Execute CMD Command To Create Laravel Project
        exec('composer create-project --prefer-dist laravel/laravel '.$project->project_code);
                   
        /* ****************************************************************************************************** */
        /* Step 2 : Setup Database Credentials - '.env' File                                                      */
        /* ****************************************************************************************************** */

        # Step 2.1 : Delete '.env' File 
        File::delete($dotEnvFile);

        # Step 2.2 : Create '.env' File
        $createDotEnv = (new LaravelController())->createDotEnv($project, $database);
        file_put_contents($dotEnvFile, $createDotEnv.PHP_EOL , FILE_APPEND | LOCK_EX);        
           
        /* ****************************************************************************************************** */
        /* Step 3 : Generate Migrations                                                                           */
        /* ****************************************************************************************************** */
        
        # Step 3.1 : Delete AppServiceProvider.php File - Under 'app/Providers/..'
        File::delete($appServiceProviderPath);

        # Step 3.2 : Create AppServiceProvider.php File
        $createAddServProv = (new LaravelController())->createAddServiceProvider();
        file_put_contents($appServiceProviderPath, $createAddServProv.PHP_EOL , FILE_APPEND | LOCK_EX);   

        # Step 3.3 : Create Migrations
        $createMigrations = (new LaravelController())->createMigrations($tables, $migrationPath);
                   
        /* ****************************************************************************************************** */
        /* Step 4 : Generate Models                                                                               */
        /* ****************************************************************************************************** */

        # Step 4.1 : Delete Default Model - 'User.php'
        File::delete($modelsPath.DIRECTORY_SEPARATOR.'User.php');

        # Step 4.2 : Create Models For Each Table
        $createModels = (new LaravelController())->createModels($tables, $modelsPath);
          
        /* ****************************************************************************************************** */
        /* Step 5 : Create Controllers, Routes & API-Document For Project                                         */
        /* ****************************************************************************************************** */

        # Step 5.1 : Create API Folder
        if (!file_exists($controllersPath)) {
            Storage::makeDirectory('users/'.$user->code.'/'.$project->project_code.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Http'.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.'API');
        }

        # Step 5.2 : Create AGC Documentation Directory
        if (!file_exists($agcDocDirectory)) {
            Storage::makeDirectory('users/'.$user->code.'/'.$project->project_code.'/AGC DOCUMENTATION');
        }

        # Step 5.3 : Delete Default routes/api.php File
        File::delete($routesPath);

        # Step 5.4 : Create A Basic Route
        $basicRoute = (new LaravelController())->basicRoute();
        file_put_contents($routesPath, $basicRoute , FILE_APPEND | LOCK_EX);  

        # Step 5.5 : Api Doc Path
        $apidocPath = $agcDocDirectory.DIRECTORY_SEPARATOR."API_Document.txt";

        # Step 5.6 : Create Controllers, Routes & API-Document For Project
        $createCntrlRoutApi = (new LaravelController())->createCntrlRoutApi($tables, $controllersPath, $routesPath, $apidocPath);
  
        /* ****************************************************************************************************** */
        /* Step 6 : Installation Steps - To Create & Setup Project                                                */
        /* ****************************************************************************************************** */

        # Step 6.1 : Installation Steps Doc File Path For Project
        $installationStepsPath = $agcDocDirectory.DIRECTORY_SEPARATOR."project_installation_steps.txt";

        # Step 5.4 : Create Installation Steps Doc For Project
        $installationSteps = (new LaravelController())->installationSteps($installationStepsPath);
        
        /* ****************************************************************************************************** */
        /* Step 7 : Archive & Download Project                                                                    */
        /* ****************************************************************************************************** */

        # Download file
        $files = glob($projectDirectory);
        \Zipper::make($projectDirectory.DIRECTORY_SEPARATOR.'test.zip')->add($files)->close();

        return response()->download($projectDirectory.DIRECTORY_SEPARATOR.'test.zip');

        return response("success");
    }

    
}

















// if(empty($projectFiles)) {
//     # Step 1.5 : Extract Laravel Project To Current Project Folder
//     \Zipper::make($defProjDir)->extractTo($projectDirectory);
// }
// # Step 1.4 : Extract Laravel Project To Current Project Folder
// \Zipper::make($defProjDir)->extractTo($projectDirectory);



// $Path = public_path('test.zip');
//         \Zipper::make($Path)->extractTo('Appdividend');



# Step 2 : 

        // Get real path for our folder
    //     $projectDirectory = app('path.storage').('\app\users'.DIRECTORY_SEPARATOR.$user->code.DIRECTORY_SEPARATOR.$project->project_code);
    // $rootPath = realpath($projectDirectory);

    

    //     # Download file
    //     // $projectDirectory = app('path.storage').('\app\users'.DIRECTORY_SEPARATOR.$user->code.DIRECTORY_SEPARATOR.$project->project_code);
    //     $files = glob($projectDirectory);
    //     // $files = Storage::allDirectories($rootPath);
    //     \Zipper::make($projectDirectory.DIRECTORY_SEPARATOR.'test.zip')->add($files)->close();

    //     return response()->download($projectDirectory.DIRECTORY_SEPARATOR.'test.zip');
        
        // return Storage::download($projectDirectory);  




// $fdf = Request::fullUrl();
    // return response(app('path.storage').('\app\users'));
    // echo $hello = exec('php artisan migrate -v');

// Storage::disk('local')->put('users', 'Contents');
//  = echo asset('storage/users');

# Download file
// return Storage::download('file.jpg');

# Step 1.2.3 : Change Directory To Project Directory
// $projectDirectory = app('path.storage').('\app\users'.DIRECTORY_SEPARATOR.$user->code.DIRECTORY_SEPARATOR.$project->project_code);
// chdir($projectDirectory);

// # Step 1.2.4 : Execute CMD command To Generate Key
// exec('php artisan key:generate');

// Initialize archive object
    // $zip = new ZipArchive();
    // echo $zip->open($projectDirectory.'\testing.rar', ZipArchive::CREATE | ZipArchive::OVERWRITE);

    

    // foreach (File::allFiles($rootPath) as $name => $file)
    // {
    //     // Skip directories (they would be added automatically)
    //     if (!$file->isDir())
    //     {
    //         // Get real and relative path for current file
    //         $filePath = $file->getRealPath();
    //         $relativePath = substr($filePath, strlen($rootPath) + 1);

    //         // Add current file to archive
    //         $zip->addFile($filePath, $relativePath);
    //     }
    // }

    // Zip archive will be created only after closing object
    // $zip->close();