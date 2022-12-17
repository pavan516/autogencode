<?php

# Namespace
namespace App\Http\Controllers\Nodejs;

# Utilities
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Filesystem\Filesystem;
// use Illuminate\Filesystem\File;
// use File;
use ZipArchive;
use \RecursiveIteratorIterator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Chumper\Zipper\Zipper;

# Controllers
use App\Http\Controllers\NodeJs\ExpressJs;

# Models
use App\Project;
use App\Database;
use App\Table;
use App\Attribute;
use App\Feature;

/**
 * Express Js Controller
 */
class ExpressJsController extends ExpressJs
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		# authentication
		$this->middleware('auth');

		# set max execution time to ininity
		ini_set('max_execution_time', 0);
	}

	/**
	 * generateMysql
	 *
	 * @param string $project_uuid
	 *
	 * @return void
	 */
	public function generateMysql($project_uuid)
	{
		/* ****************************************************************************************************** */
		/* FETCH USER & PROJECT RELATED DETAILS                                                                   */
		/* ****************************************************************************************************** */

		## Get Auth User Info.
		$user = Auth::user();

		## Get Project Info.
		$project = (new Project())->where('uuid', $project_uuid)->first();

		## Get Database Info.
		$database = (new Database())->where('project_uuid', $project_uuid)->first();

		## Get All Tables
		$tables = (new Table())->where('project_uuid', $project_uuid)->get();

		## Local Domain
		$localDomainName = \strtolower(\str_replace(' ', '', \ucwords($project->local_domain_name)));
		$localProtocol = \strtolower($project->local_protocol);
		if( strlen($project->local_portno) > 0 ) {
			$localDomainUrl = $localProtocol."://".$localDomainName.":".$project->local_portno."/";
		} else {
			$localDomainUrl = $localProtocol."://".$localDomainName."/";
		}

		## Server Domain
		$serverDomainName = \strtolower(\str_replace(' ', '', \ucwords($project->server_domain_name)));
		$serverProtocol = \strtolower($project->server_protocol);
		if( strlen($project->server_portno) > 0 ) {
			$serverDomainUrl = $serverProtocol."://".$serverDomainName.":".$project->server_portno."/";
		} else {
			$serverDomainUrl = $serverProtocol."://".$serverDomainName."/";
		}

		/* ****************************************************************************************************** */
		/* NODE JS PROJECT INSTALLATION STEPS                                                                     */
		/* ****************************************************************************************************** */

		# Storage Path With App
		$path = \app('path.storage').DIRECTORY_SEPARATOR.('app');

		# Create Users Folder If Does Not Exist.
		# Its Mandatory To Exist Users Folder.
		# Where all users folders are created.
		$usersFolder = $path.DIRECTORY_SEPARATOR.'users';
		if(!\file_exists($usersFolder)) Storage::makeDirectory('users');

		# Create Folder For Current User With Code If Does Not Exist.
		$userDirectory = $usersFolder.DIRECTORY_SEPARATOR.$user->code;
		if(!\file_exists($userDirectory)) Storage::makeDirectory('users'.DIRECTORY_SEPARATOR.$user->code);

		# Create NodeJs Folder For Current User If Does Not Exist
		$nodejsDirectory = $userDirectory.DIRECTORY_SEPARATOR.'nodejs';
		if (!\file_exists($nodejsDirectory)) {
			Storage::makeDirectory('users'.DIRECTORY_SEPARATOR.$user->code.DIRECTORY_SEPARATOR.'nodejs');
		}

		# Delete Project Folder Of Current User If Exist.
		# Create Project Folder For Current User If Does Not Exist.
		$projectDirectory = $nodejsDirectory.DIRECTORY_SEPARATOR.$project->project_code;
		if (\file_exists($projectDirectory)) {
			File::deleteDirectory($projectDirectory);
			Storage::makeDirectory('users'.DIRECTORY_SEPARATOR.$user->code.DIRECTORY_SEPARATOR.'nodejs'.DIRECTORY_SEPARATOR.$project->project_code);
		} else {
			Storage::makeDirectory('users'.DIRECTORY_SEPARATOR.$user->code.DIRECTORY_SEPARATOR.'nodejs'.DIRECTORY_SEPARATOR.$project->project_code);
		}

		# Create doc Folder
		$docDirectory = $projectDirectory.DIRECTORY_SEPARATOR.'doc';
		if (!\file_exists($docDirectory)) {
			Storage::makeDirectory('users'.DIRECTORY_SEPARATOR.$user->code.DIRECTORY_SEPARATOR.'nodejs'.DIRECTORY_SEPARATOR.$project->project_code.DIRECTORY_SEPARATOR.'doc');
		}

		# Create doc.api_doc Folder
		$apiDocDirectory = $docDirectory.DIRECTORY_SEPARATOR.'api_doc';
		$apiFilePath = $apiDocDirectory.DIRECTORY_SEPARATOR.'api.txt';
		if (!\file_exists($apiDocDirectory)) {
			Storage::makeDirectory('users'.DIRECTORY_SEPARATOR.$user->code.DIRECTORY_SEPARATOR.'nodejs'.DIRECTORY_SEPARATOR.$project->project_code.DIRECTORY_SEPARATOR.'doc'.DIRECTORY_SEPARATOR.'api_doc');
			\file_put_contents($apiFilePath, "", FILE_APPEND | LOCK_EX);
		}

		# Create doc.database Folder
		$databaseDirectory = $docDirectory.DIRECTORY_SEPARATOR.'database';
		$dbFilePath = $databaseDirectory.DIRECTORY_SEPARATOR.'version_1.sql';
		if (!\file_exists($databaseDirectory)) {
			Storage::makeDirectory('users'.DIRECTORY_SEPARATOR.$user->code.DIRECTORY_SEPARATOR.'nodejs'.DIRECTORY_SEPARATOR.$project->project_code.DIRECTORY_SEPARATOR.'doc'.DIRECTORY_SEPARATOR.'database');
			\file_put_contents($dbFilePath, "", FILE_APPEND | LOCK_EX);
		}

		# Create doc.postman Folder
		$postmanDirectory = $docDirectory.DIRECTORY_SEPARATOR.'postman';
		$postmanFilePath = $postmanDirectory.DIRECTORY_SEPARATOR.'postman.txt';
		if (!\file_exists($postmanDirectory)) {
			Storage::makeDirectory('users'.DIRECTORY_SEPARATOR.$user->code.DIRECTORY_SEPARATOR.'nodejs'.DIRECTORY_SEPARATOR.$project->project_code.DIRECTORY_SEPARATOR.'doc'.DIRECTORY_SEPARATOR.'postman');
			\file_put_contents($postmanFilePath, "", FILE_APPEND | LOCK_EX);
		}

		# Create doc.swagger Folder
		$swaggerDirectory = $docDirectory.DIRECTORY_SEPARATOR.'swagger';
		$swaggerFilePath = $swaggerDirectory.DIRECTORY_SEPARATOR.'swagger.txt';
		if (!\file_exists($swaggerDirectory)) {
			Storage::makeDirectory('users'.DIRECTORY_SEPARATOR.$user->code.DIRECTORY_SEPARATOR.'nodejs'.DIRECTORY_SEPARATOR.$project->project_code.DIRECTORY_SEPARATOR.'doc'.DIRECTORY_SEPARATOR.'swagger');
			\file_put_contents($swaggerFilePath, "", FILE_APPEND | LOCK_EX);
		}

		# Create src Folder
		$srcDirectory = $projectDirectory.DIRECTORY_SEPARATOR.'src';
		if (!\file_exists($srcDirectory)) {
			Storage::makeDirectory('users'.DIRECTORY_SEPARATOR.$user->code.DIRECTORY_SEPARATOR.'nodejs'.DIRECTORY_SEPARATOR.$project->project_code.DIRECTORY_SEPARATOR.'src');
		}

		# Create .gitignore File
		$dotGitIgnoreFilePath = $projectDirectory.DIRECTORY_SEPARATOR.'1.gitignore';
		if (!\file_exists($dotGitIgnoreFilePath)) {
			$gitIgnore  = "/src/.env".PHP_EOL."/src/node_modules".PHP_EOL;
			\file_put_contents($dotGitIgnoreFilePath, $gitIgnore, FILE_APPEND | LOCK_EX);
		}

		# Create changelog.md File
		$changeLogFilePath = $projectDirectory.DIRECTORY_SEPARATOR.'changelog.md';
		if (!\file_exists($changeLogFilePath)) {
			$changeLog  = "# v1.0.0".PHP_EOL."- Initial node js structure".PHP_EOL;
			\file_put_contents($changeLogFilePath, $changeLog, FILE_APPEND | LOCK_EX);
		}

		# Create LICENCE File
		$licenceFilePath = $projectDirectory.DIRECTORY_SEPARATOR.'LICENCE';
		if (!\file_exists($licenceFilePath)) {
			\file_put_contents($licenceFilePath, "", FILE_APPEND | LOCK_EX);
		}

		# Create README.md File
		$readmeDotMDFilePath = $projectDirectory.DIRECTORY_SEPARATOR.'README.md';
		if (!\file_exists($readmeDotMDFilePath)) {
			$this->createReadmeDotMdFile($readmeDotMDFilePath, $project->project_name);
		}

		# Create src > tsconfig.json File
		$tsconfigFilePath = $srcDirectory.DIRECTORY_SEPARATOR.'tsconfig.json';
		if (!\file_exists($tsconfigFilePath)) {
			$this->createTsConfigFile($tsconfigFilePath);
		}

		# Create src > .env File
		$dotEnvFilePath = $srcDirectory.DIRECTORY_SEPARATOR.'1.env';
		if (!\file_exists($dotEnvFilePath)) {
			$this->createDotEnvFile($dotEnvFilePath, $database, $project);
		}

		# Create src > package.json File + Install Node Modules
		$packageDotJsonFilePath = $srcDirectory.DIRECTORY_SEPARATOR.'package.json';
		if (!\file_exists($packageDotJsonFilePath)) {
			# Create File
			$this->createPackageDotJsonFile($packageDotJsonFilePath, $project->project_name);
			# Change Directory To src
			\chdir($srcDirectory);
			# Install All Node Modules
			exec('npm install express');
			exec('npm install typescript');
			exec('npm install body-parser');
			exec('npm install cors');
			exec('npm install typescript-rest');
			exec('npm install mysql');
			exec('npm install @types/mysql');
			exec('npm install dotenv');
			exec('npm install uuid');
			exec('npm install bcryptjs');
			exec('npm install jsonwebtoken');
			exec('npm install nodemailer');
			exec('npm install nodemon --save-dev');
			exec('npm install @types/dotenv --save-dev');
			exec('npm install @types/express --save-dev');
			exec('npm install @types/node --save-dev');
			exec('npm install ts-node --save-dev');
			exec('npm install tslint --save-dev');
			exec('npm install tslint-config-prettier --save-dev');
			exec('npm install typescript --save-dev');
			exec('npm install @types/cors --save-dev');
			exec('npm install @types/node --save-dev');
			exec('npm install @types/mysql --- dev');
		}

		# Create src.app Folder
		$appDirectory = $srcDirectory.DIRECTORY_SEPARATOR.'app';
		if (!\file_exists($appDirectory)) {
			Storage::makeDirectory('users'.DIRECTORY_SEPARATOR.$user->code.DIRECTORY_SEPARATOR.'nodejs'.DIRECTORY_SEPARATOR.$project->project_code.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'app');
		}

		/* ****************************************************************************************************** */
		/* SRC > APP > INDEX.TS                                                                                   */
		/* ****************************************************************************************************** */

		# Create src > app > index.ts File
		$indexFilePath = $appDirectory.DIRECTORY_SEPARATOR.'index.ts';
		if (!\file_exists($indexFilePath)) {
			$this->createIndexFile($indexFilePath);
		}

		/* ****************************************************************************************************** */
		/* SRC > APP > CONFIG                                                                                     */
		/* ****************************************************************************************************** */

		/* ****************************************************************************************************** */
		/* SRC > APP > CONTROLLERS                                                                                */
		/* ****************************************************************************************************** */

		/* ****************************************************************************************************** */
		/* SRC > APP > MIDDLEWARES                                                                                */
		/* ****************************************************************************************************** */

		/* ****************************************************************************************************** */
		/* SRC > APP > MODELS                                                                                   */
		/* ****************************************************************************************************** */

		/* ****************************************************************************************************** */
		/* SRC > APP > ROUTES                                                                                   */
		/* ****************************************************************************************************** */

		/* ****************************************************************************************************** */
		/* SRC > APP > UTILITIES                                                                                   */
		/* ****************************************************************************************************** */

		/* ****************************************************************************************************** */
		/* DOWNLOAD PROJECT                                                                                       */
		/* ****************************************************************************************************** */

		// # Create zipper client + Read folder files + make zip
		// $zipper = new \Chumper\Zipper\Zipper;
		// $files = \glob($projectDirectory);
		// $zipper->make($projectDirectory.DIRECTORY_SEPARATOR.$project->project_name.'.zip')->add($files)->close();

		// # Return response - ZIP FILE
		// return response()->download($projectDirectory.DIRECTORY_SEPARATOR.$project->project_name.'.zip');

		# TEMP RESPONSE
    print_r("success");exit;
	}

}