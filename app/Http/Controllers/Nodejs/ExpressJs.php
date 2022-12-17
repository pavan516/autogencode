<?php

# Namespace
namespace App\Http\Controllers\Nodejs;

# Controllers
use App\Http\Controllers\Controller;

# Models
use App\Table;
use App\Attribute;

/**
 * Express JS
 */
class ExpressJs extends Controller
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
	}

/* *************************************************************************************************************** */
/*  ###  README.md FILE ###                                                                                        */
/* *************************************************************************************************************** */

	/**
	 * Method: createReadmeDotMdFile
	 * Description : This internal method will generate readme.md file with content in it.
	 *
	 * @param   string 	$filePath
	 * @param   string 	$projectName
	 *
	 * @return  Boolean	True/False
	 */
	public function createReadmeDotMdFile($filePath, $projectName)
	{
		# Initialize string
		$str = "";
		$str .= "# ".$projectName.PHP_EOL;
		$str .= "- setup all files as per standard structure".PHP_EOL;
		$str .= "- <app-name>".PHP_EOL;
		$str .= "  - <doc>".PHP_EOL;
		$str .= "    - <api-doc>".PHP_EOL;
		$str .= "      - <doc-files>".PHP_EOL;
		$str .= "    - <database>".PHP_EOL;
		$str .= "      - <versoned-files-sql>".PHP_EOL;
		$str .= "    - <postman>".PHP_EOL;
		$str .= "      - <postman-import-and-export-files>".PHP_EOL;
		$str .= "    - <swagger>".PHP_EOL;
		$str .= "      - <swagger-import-and-export-files>".PHP_EOL;
		$str .= "  - <src>".PHP_EOL;
		$str .= "    - <app>".PHP_EOL;
		$str .= "      - <config>".PHP_EOL;
		$str .= "     	 - config.ts".PHP_EOL;
		$str .= "        - version.json".PHP_EOL;
		$str .= "      - <controllers>".PHP_EOL;
		$str .= "        - <v1>".PHP_EOL;
		$str .= "   			 - file.controller.ts".PHP_EOL;
		$str .= "  			 - application.controller.ts".PHP_EOL;
		$str .= "  		 - <middlewares>".PHP_EOL;
		$str .= "  			 - file.middleware.ts".PHP_EOL;
		$str .= "      - <models>".PHP_EOL;
		$str .= "  	     - <v1>".PHP_EOL;
		$str .= "  		     - file.model.ts".PHP_EOL;
		$str .= "  	     - application.model.ts".PHP_EOL;
		$str .= "  	     - model.ts".PHP_EOL;
		$str .= "      - <routes>".PHP_EOL;
		$str .= "  	     - <v1>".PHP_EOL;
		$str .= "  		   - file.routes.ts".PHP_EOL;
		$str .= "  	     - application.routes.ts".PHP_EOL;
		$str .= "      - <utilities>".PHP_EOL;
		$str .= "  	     - file.ts".PHP_EOL;
		$str .= "      - index.ts".PHP_EOL;
		$str .= "    - <node_modules>".PHP_EOL;
		$str .= "      - <all-node-related-installed-modules>".PHP_EOL;
		$str .= "    - .env".PHP_EOL;
		$str .= "    - package-lock.json".PHP_EOL;
		$str .= "    - package.json".PHP_EOL;
		$str .= "    - tsconfig.json".PHP_EOL;
		$str .= "  - .gitignore".PHP_EOL;
		$str .= "  - changelog.md".PHP_EOL;
		$str .= "  - licence".PHP_EOL;
		$str .= "  - readme.md".PHP_EOL.PHP_EOL;
		$str .= "- npm init => to create a package.json".PHP_EOL;
		$str .= "- add dependencies".PHP_EOL;
		$str .= "  - npm install express".PHP_EOL;
		$str .= "  - npm install typescript".PHP_EOL;
		$str .= "  - npm install body-parser".PHP_EOL;
		$str .= "  - npm install cors".PHP_EOL;
		$str .= "  - npm install typescript-rest".PHP_EOL;
		$str .= "  - npm install mysql".PHP_EOL;
		$str .= "  - npm install @types/mysql".PHP_EOL;
		$str .= "  - npm install dotenv".PHP_EOL;
		$str .= "  - npm install uuid".PHP_EOL;
		$str .= "  - npm install bcryptjs".PHP_EOL;
		$str .= "  - npm install jsonwebtoken".PHP_EOL;
		$str .= "  - npm install nodemailer".PHP_EOL;
		$str .= "- add dev dependencies".PHP_EOL;
		$str .= "  - npm install nodemon --save-dev".PHP_EOL;
		$str .= "  - npm install @types/dotenv --save-dev".PHP_EOL;
		$str .= "  - npm install @types/express --save-dev".PHP_EOL;
		$str .= "  - npm install @types/node --save-dev".PHP_EOL;
		$str .= "  - npm install ts-node --save-dev".PHP_EOL;
		$str .= "  - npm install tslint --save-dev".PHP_EOL;
		$str .= "  - npm install tslint-config-prettier --save-dev".PHP_EOL;
		$str .= "  - npm install typescript --save-dev".PHP_EOL;
		$str .= "  - npm install @types/cors --save-dev".PHP_EOL;
		$str .= "  - npm install @types/node --save-dev".PHP_EOL;
		$str .= "  - create src directory under app".PHP_EOL;
		$str .= "  - create index.ts file inside src".PHP_EOL;
		$str .= "  - npm install @types/mysql --- dev".PHP_EOL;

		# create file
		$create = \file_put_contents($filePath, $str, FILE_APPEND | LOCK_EX);
		if(!$create) return false;

		# assume all okay
		return true;
	}

/* *************************************************************************************************************** */
/*  ###  SRC > PACKAGE.JSON FILE ###                                                                               */
/* *************************************************************************************************************** */

	/**
	 * Method: createPackageDotJsonFile
	 * Description : This internal method will generate package.json file with content in it.
	 *
	 * @param   string 	$filePath
	 * @param   string 	$projectName
	 *
	 * @return  Boolean	True/False
	 */
	public function createPackageDotJsonFile($filePath, $projectName)
	{
		# Initialize string
		$str = "";
		$str .= '{'.PHP_EOL;
		$str .= '  "name": "'.$projectName.'",'.PHP_EOL;
		$str .= '  "version": "1.0.0",'.PHP_EOL;
		$str .= '  "description": "autogenerated rest-full apis",'.PHP_EOL;
		$str .= '  "main": "index.js",'.PHP_EOL;
		$str .= '  "scripts": {'.PHP_EOL;
		$str .= '	   "start": "nodemon ./app/Index.ts",'.PHP_EOL;
		$str .= '	   "test": "echo \"Error: no test specified\" && exit 1"'.PHP_EOL;
		$str .= '  },'.PHP_EOL;
		$str .= '  "author": "PAVAN KUMAR - AUTO GENERATED CODE",'.PHP_EOL;
		$str .= '  "license": "ISC"'.PHP_EOL;
		$str .= '}'.PHP_EOL;

		# create file
		$create = \file_put_contents($filePath, $str, FILE_APPEND | LOCK_EX);
		if(!$create) return false;

		# assume all okay
		return true;
	}

/* *************************************************************************************************************** */
/*  ###  SRC > TSCONFIG.JSON FILE ###                                                                              */
/* *************************************************************************************************************** */

	/**
	 * Method: createTsConfigFile
	 * Description: This internal method will generate tsconfig.json file with content in it.
	 *
	 * @param   string 	$filePath
	 *
	 * @return  Boolean	True/False
	 */
	public function createTsConfigFile($filePath)
	{
		# Initialize string
		$str = "";
		$str .= '{'.PHP_EOL;
		$str .= '  "compilerOptions": {'.PHP_EOL;
		$str .= '	   "target": "es6",'.PHP_EOL;
		$str .= '	   "module": "commonjs",'.PHP_EOL;
		$str .= '	   "outDir": "./dist",'.PHP_EOL;
		$str .= '	   "strict": true,'.PHP_EOL;
		$str .= '	   "esModuleInterop": true,'.PHP_EOL;
		$str .= '	   "skipLibCheck": true,'.PHP_EOL;
		$str .= '	   "forceConsistentCasingInFileNames": true,'.PHP_EOL;
		$str .= '	   "resolveJsonModule": true'.PHP_EOL;
		$str .= '  }'.PHP_EOL;
		$str .= '}'.PHP_EOL;

		# create file
		$create = \file_put_contents($filePath, $str, FILE_APPEND | LOCK_EX);
		if(!$create) return false;

		# assume all okay
		return true;
	}

/* *************************************************************************************************************** */
/*  ###  SRC > .ENV FILE ###                                                                                       */
/* *************************************************************************************************************** */

	/**
	 * Method: createDotEnvFile
	 * Description: This internal method will generate .env file with content in it.
	 *
	 * @param   string 	$filePath
	 * @param   object 	$database
	 * @param   object 	$project
	 *
	 * @return  Boolean	True/False
	 */
	public function createDotEnvFile($filePath, $database, $project)
	{
		# Initialize string
		$str = "";
		$str .= '# APP CREDENTIALS'.PHP_EOL;
		$str .= 'APP_PORT='.$project->local_portno.PHP_EOL.PHP_EOL;
		$str .= '# DB CREDENTIALS'.PHP_EOL;
		$str .= 'DB_PORT='.$database->database_port.PHP_EOL;
		$str .= 'DB_HOST='.$database->database_host.PHP_EOL;
		$str .= 'DB_USER='.$database->database_user_name.PHP_EOL;
		$str .= 'DB_PASS='.$database->database_password.PHP_EOL;
		$str .= 'DB_NAME='.$database->database_code.PHP_EOL;
		$str .= '# APP SECRET TOKEN'.PHP_EOL.PHP_EOL;
		$str .= 'TOKEN_SECRET=cdcdbf1fde8f41d38e827e8449302558'.PHP_EOL;
		$str .= 'TOKEN_EXPIRES_IN=1800s'.PHP_EOL;

		# create file
		$create = \file_put_contents($filePath, $str, FILE_APPEND | LOCK_EX);
		if(!$create) return false;

		# assume all okay
		return true;
	}

/* *************************************************************************************************************** */
/*  ###  SRC > APP > INDEX.TS FILE ###                                                                             */
/* *************************************************************************************************************** */

	/**
	 * Method: createIndexFile
	 * Description: This internal method will generate index.ts file with content in it.
	 *
	 * @param   string 	$filePath
	 *
	 * @return  Boolean	True/False
	 */
	public function createIndexFile($filePath)
	{
		# Initialize string
		$str = "";
		$str .= "/**"." IMPORT EXPRESS, CORS, BODY-PARSER, DOTENV */".PHP_EOL;
		$str .= "import express from 'express';".PHP_EOL;
		$str .= "import cors from 'cors';".PHP_EOL;
		$str .= "import dotenv from 'dotenv';".PHP_EOL.PHP_EOL;
		$str .= "/**"." IMPORT ROUTES */".PHP_EOL;
		$str .= "import apiV1Routes from './routes/v1/api.routes';".PHP_EOL;
		$str .= "import authV1Routes from './routes/v1/auth.routes';".PHP_EOL;
		$str .= "import appRoutes from './routes/app.routes';".PHP_EOL.PHP_EOL;
		$str .= "/**"." LOAD CONFIG */".PHP_EOL;
		$str .= "dotenv.config();".PHP_EOL.PHP_EOL;
		$str .= "/**".PHP_EOL;
		$str .= " * Index".PHP_EOL;
		$str .= " */".PHP_EOL;
		$str .= "class Index {".PHP_EOL.PHP_EOL;
		$str .= "  /** VARIABLES */".PHP_EOL;
		$str .= "  public express: express.Application;".PHP_EOL.PHP_EOL;
		$str .= "  /**"." CONSTRUCTOR */".PHP_EOL;
		$str .= "  constructor()".PHP_EOL;
		$str .= "  {".PHP_EOL;
		$str .= "    /** LOAD EXPRESS */".PHP_EOL;
		$str .= "    this.express = express();".PHP_EOL.PHP_EOL;
		$str .= "    /** LOAD CORS */".PHP_EOL;
		$str .= "    this.express.use(cors());".PHP_EOL.PHP_EOL;
		$str .= "    /** CONVERT REQ TO JSON */".PHP_EOL;
		$str .= "    this.express.use(express.json());".PHP_EOL.PHP_EOL;
		$str .= "    /** LISTEN TO SPECIFIC PORT */".PHP_EOL;
		$str .= "    this.listen();".PHP_EOL.PHP_EOL;
		$str .= "    /** LOAD ROUTES */".PHP_EOL;
		$str .= "    this.loadRoutes();".PHP_EOL;
		$str .= "  }".PHP_EOL.PHP_EOL;
		$str .= "  /**".PHP_EOL;
		$str .= "   * Method: listen".PHP_EOL;
		$str .= "   *".PHP_EOL;
		$str .= "   * @return void".PHP_EOL;
		$str .= "   */".PHP_EOL;
		$str .= "  private listen(): void".PHP_EOL;
		$str .= "  {".PHP_EOL;
		$str .= "    /** LISTEN TO PORT */".PHP_EOL;
		$str .= "    this.express.listen(process.env.APP_PORT, ()=> {".PHP_EOL;
		$str .= '      console.log("server is up & running on port: ", process.env.APP_PORT);'.PHP_EOL;
		$str .= "    });".PHP_EOL;
		$str .= "  }".PHP_EOL.PHP_EOL;
		$str .= "  /**".PHP_EOL;
		$str .= "   * Method: loadRoutes".PHP_EOL;
		$str .= "   *".PHP_EOL;
		$str .= "   * @return void".PHP_EOL;
		$str .= "   */".PHP_EOL;
		$str .= "  private loadRoutes(): void".PHP_EOL;
		$str .= "  {".PHP_EOL;
		$str .= "    /** load routes */".PHP_EOL;
		$str .= "    this.express.use('', appRoutes);".PHP_EOL;
		$str .= "    this.express.use('/api/v1', apiV1Routes);".PHP_EOL;
		$str .= "    this.express.use('/api/v1/auth', authV1Routes);".PHP_EOL;
		$str .= "  }".PHP_EOL.PHP_EOL;
		$str .= "}".PHP_EOL.PHP_EOL;
		$str .= "/**"." EXPORT CLASS */".PHP_EOL;
		$str .= "export default new Index().express;".PHP_EOL;

		# create file
		$create = \file_put_contents($filePath, $str, FILE_APPEND | LOCK_EX);
		if(!$create) return false;

		# assume all okay
		return true;
	}

}