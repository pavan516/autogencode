<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use File;
use Auth;
use App\Project;
use App\Database;
use App\Table;
use App\Attribute;

class LaravelController extends Controller
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
/*  ###  Generate Dot Env File  ###                                                                                 */
/* *************************************************************************************************************** */

    /**
     * NOTE : Generate Dot Env File.
     *
     * @param   Json Object  $project - Project Info
     * 
     * @param   Json Object  $database - Database Info
     * 
     * @return  string with file content
     */
    public function createDotEnv($project, $database)
    {
        $str = 'APP_NAME='.$project->project_name.'
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack

DB_CONNECTION='.$database->database_connection.'
DB_HOST='.$database->database_host.'
DB_PORT='.$database->database_port.'
DB_DATABASE='.$database->database_code.'
DB_USERNAME='.$database->database_user_name.'
DB_PASSWORD='.$database->database_password.'

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

REDIS_HOST='.$database->database_host.'
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
';

        return $str;
    }

/* *************************************************************************************************************** */
/*  ###  Create AddServiceProvider.php File  ###                                                                                 */
/* *************************************************************************************************************** */

    /**
     * NOTE : Create AddServiceProvider.php file
     * 
     * => add this line - use Illuminate\Support\Facades\Schema;
     * => To set defaultStringLength - 191
     *
     * @return  string with file content
     */
    public function createAddServiceProvider()
    {
        $str = '<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
';

        return $str;        
    }

/* *************************************************************************************************************** */
/*  ###  Generate Migrations For Given Tables  ###                                                                                 */
/* *************************************************************************************************************** */

    /**
     * NOTE : Generate Migrations For Given Tables
     *
     * @param   array     $tables - All Tables
     * 
     * @param   string    $migrationPath - Migration Path
     * 
     * @return  Success / Failure
     */
    public function createMigrations($tables, $migrationPath)
    {
        # Migrate for each table
        foreach($tables as $table) {

            # Initialise String
            $string = "";

            # Table Name
            $tableName = str_replace(" ", "", ucwords(str_replace("_", " ", $table->table_code)));

            # Class Name
            $className = 'Create'.$tableName.'Table';

            # File Name
            $key = mt_rand(000000, 999999);
            $fileName = date("Y").'_'.date("m").'_'.date("d").'_'.$key.'_create_'.$table->table_code.'_table.php';
            $filePath = $migrationPath.DIRECTORY_SEPARATOR.$fileName;

            # Get Attributes For Particular Table
            $attributes = '';
            $attributes =  Attribute::where('table_uuid',$table->uuid)->get();

            $var1 = "$";

            $string .= "<?php".PHP_EOL.PHP_EOL;
            $string .= "use Illuminate\Support\Facades\Schema;".PHP_EOL;
            $string .= "use Illuminate\Database\Schema\Blueprint;".PHP_EOL;
            $string .= "use Illuminate\Database\Migrations\Migration;".PHP_EOL.PHP_EOL;
            $string .= "class ".$className." extends Migration".PHP_EOL;
            $string .= "{".PHP_EOL;
            $string .= "    /**".PHP_EOL;            
            $string .= "    * Run the migrations.".PHP_EOL;
            $string .= "    *".PHP_EOL;
            $string .= "    * @return void".PHP_EOL;
            $string .= "    */".PHP_EOL;
            $string .= "    public function up()".PHP_EOL;
            $string .= "    {".PHP_EOL;
            $string .= "        Schema::create('".$table->table_code."', function (Blueprint ".$var1."table) {".PHP_EOL;
            foreach($attributes as $attribute) {
                $getString = $this->verifyDatatype($attribute);
                $string .= "            ".$getString.PHP_EOL;
            }
            $string .= "        });".PHP_EOL;
            $string .= "    }".PHP_EOL.PHP_EOL;
            $string .= "    /**".PHP_EOL;
            $string .= "    * Reverse the migrations.".PHP_EOL;
            $string .= "    *".PHP_EOL;
            $string .= "    * @return void".PHP_EOL;
            $string .= "    */".PHP_EOL;
            $string .= "    public function down()".PHP_EOL;
            $string .= "    {".PHP_EOL;
            $string .= "        Schema::dropIfExists('".$table->table_code."');".PHP_EOL;
            $string .= "    }".PHP_EOL;
            $string .= "}";

            # Create File & Copy Content
            file_put_contents($filePath, $string , FILE_APPEND | LOCK_EX);
        }
        return "Success";
    }
    
/* *************************************************************************************************************** */
/*  ###  Verify DataType As Per Laravel  ###                                                                       */
/* *************************************************************************************************************** */

    /**
     * NOTE : Verify DataType As Per Laravel
     *
     * @param   json-Body $attribute
     * 
     * @required Params   string    $attribute_datatype - DataType (varchar/value)
     * 
     * @required Params   string    $attribute_length - Length Of The Datatype (empty/value)
     * 
     * @required Params   string    $attribute_default - Default Value (none/value)
     * 
     * @required Params   string    $attribute_attributes - Attributes (empty/value)
     * 
     * @required Params   string    $attribute_null - Null (1/0)
     * 
     * @required Params   string    $attribute_index - Index (empty/value)
     * 
     * @required Params   string    $attribute_autoincrement - AutoIncrement (1/0)
     * 
     * @return  Laravel Datatype
     */
    public function verifyDatatype($attribute)
    {
        # Initialize Variables
        $var1 = "$";

        switch ($attribute->attribute_datatype) {
  
            /* ********************* */
            /*  ###  VARCHAR  ###    */
            /* ********************* */

            # Varchar
            case "VARCHAR" :

                # Datatype
                $dataType = $var1."table->string('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string;   

            /* ********************* */
            /*  ###    INT    ###    */
            /* ********************* */

            # Int
            case "INT" :
            // Auto-incrementing UNSIGNED INTEGER (primary key) equivalent column.
            // INTEGER equivalent column.
            // $table->increments('id');
            // $table->integer('votes');
            // <option value="INT">INT</option> - integer (autoincrement - increments)

                # Datatype
                $dataType = $var1."table->integer('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string;                

            /* ********************* */
            /*    ###  FLOAT  ###    */
            /* ********************* */
            
            case "FLOAT" :
            // FLOAT equivalent column with a precision (total digits) and scale (decimal digits).
            // $table->float('amount', 8, 2);
            // <option value="FLOAT">FLOAT</option> - float

                # Datatype
                $dataType = $var1."table->float('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string;                
            
            /* ********************* */
            /*    ###  TEXT  ###     */
            /* ********************* */

            case "TEXT" :
            // TEXT equivalent column.
            // $table->text('description');
            // <option value="TEXT">TEXT</option>

                # Datatype
                $dataType = $var1."table->text('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 
                
            /* ********************* */
            /*  ###  BOOLEAN  ###    */
            /* ********************* */

            case "BOOLEAN" :
            // $table->boolean('confirmed');	BOOLEAN equivalent column.
            // <option value="BOOLEAN">BOOLEAN</option>

                # Datatype
                $dataType = $var1."table->boolean('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 
                
            /* ********************* */
            /*    ###  BLOB  ###     */
            /* ********************* */

            case "BLOB" :
            // $table->binary('data');	BLOB equivalent column.
            // <option value="BLOB">BLOB</option>

                # Datatype
                $dataType = $var1."table->binary('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 
                
            /* ********************* */
            /*    ###  DATE  ###     */
            /* ********************* */

            case "DATE" :
            // $table->date('created_at');	DATE equivalent column.
            // <option value="DATE">DATE</option>

                # Datatype
                $dataType = $var1."table->date('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string;                 

            /* ********************* */
            /*  ###  DATETIME  ###   */
            /* ********************* */

            case "DATETIME" :
            // $table->dateTime('created_at');	DATETIME equivalent column.
            // <option value="DATETIME">DATETIME</option>

                # Datatype
                $dataType = $var1."table->dateTime('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 

            /* ********************* */
            /*  ###  TIMESTAMP  ###  */
            /* ********************* */

            case "TIMESTAMP" :
                // $table->timestamp('added_on');	TIMESTAMP equivalent column.
                // <option value="TIMESTAMP">TIMESTAMP</option>

                # Datatype
                $dataType = $var1."table->timestamp('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 

            /* ********************* */
            /*  ###  TINYINT  ###    */
            /* ********************* */

            case "TINYINT" :
            // $table->tinyInteger('votes');	TINYINT equivalent column.
            // <option value="TINYINT">TINYINT</option>

                # Datatype
                $dataType = $var1."table->tinyInteger('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 

            /* ********************* */
            /*  ###  SMALLINT  ###   */
            /* ********************* */

            case "SMALLINT" :
            // $table->smallInteger('votes');	SMALLINT equivalent column.
            // <option value="SMALLINT">SMALLINT</option>

                # Datatype
                $dataType = $var1."table->smallInteger('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string;

            /* ********************* */
            /*  ###  MEDIUMINT  ###  */
            /* ********************* */

            case "MEDIUMINT" :
            // $table->mediumInteger('votes');	MEDIUMINT equivalent column.
            // <option value="MEDIUMINT">MEDIUMINT</option>

                # Datatype
                $dataType = $var1."table->mediumInteger('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 

            /* ********************* */
            /*  ###  BIGINT  ###    */
            /* ********************* */

            case "BIGINT" :
            // $table->bigInteger('votes');	BIGINT equivalent column.
            // <option value="BIGINT">BIGINT</option>

                # Datatype
                $dataType = $var1."table->bigInteger('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string;

            /* ********************* */
            /*  ###  DECIMAL  ###    */
            /* ********************* */

            case "DECIMAL" :
                // $table->decimal('amount', 8, 2);	
                // DECIMAL equivalent column with a precision (total digits) and scale (decimal digits).
                // <option value="DECIMAL">DECIMAL</option>

                # Datatype
                $dataType = $var1."table->decimal('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 

            /* ********************* */
            /*   ###  DOUBLE  ###    */
            /* ********************* */

            case "DOUBLE" :
                // $table->double('amount', 8, 2);	
                // DOUBLE equivalent column with a precision (total digits) and scale (decimal digits).
                // <option value="DOUBLE">DOUBLE</option>

                # Datatype
                $dataType = $var1."table->double('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 

            /* ********************* */
            /*    ###  REAL  ###     */
            /* ********************* */

            case "REAL" :
            // MySQL supports all standard SQL numeric data types. ... 
            // MySQL treats DOUBLE as a synonym for DOUBLE PRECISION (a nonstandard extension). 
            // MySQL also treats REAL as a synonym for DOUBLE PRECISION (a nonstandard variation), 
            // unless the REAL_AS_FLOAT SQL mode is enabled.Nov 23, 2012
            // $table->double('amount', 8, 2);	
            // DOUBLE equivalent column with a precision (total digits) and scale (decimal digits).
            // <option value="REAL">REAL</option>

                # Datatype
                $dataType = $var1."table->double('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 

            /* ********************* */
            /*     ###  BIT  ###     */
            /* ********************* */

            case "BIT" :
            // Before MySQL 5.0, BIT is just a synonym for TINYINT . ... 
            // You can use a BIT column to store one or many true/false values in a single column.
            //  BIT(1) defines a field that contains a single bit, BIT(2) stores 2 bits, and so on; 
            //  the maximum length of a BIT column is 64 bits. BIT behavior varies between storage engines.
            //  $table->tinyInteger('votes');	TINYINT equivalent column.
            // <option value="BIT">BIT</option>

                # Datatype
                $dataType = $var1."table->tinyInteger('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 

            /* ********************* */
            /*  ###  SERIAL  ###     */
            /* ********************* */

            case "SERIAL" :
            // On the other hand, SERIAL DEFAULT VALUE is shorthand for NOT NULL AUTO_INCREMENT UNIQUE KEY. 
            // The interger numeric type like TINYINT, SMALLINT, MEDIUMINT, INT, and BIGINT supports the 
            // SERIAL DEFAULT VALUE keyword.
            // Auto-incrementing UNSIGNED INTEGER (primary key) equivalent column.
            // $table->increments('id'); (autoincrement - increments)
            // <option value="SERIAL">SERIAL</option>

                # Datatype
                $dataType = $var1."table->increments('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 

            /* ********************* */
            /*    ###  CHAR  ###     */
            /* ********************* */

            case "CHAR" :
            // $table->char('name', 100);	CHAR equivalent column with an optional length.
            // <option value="CHAR">CHAR</option>

                # Datatype
                $dataType = $var1."table->char('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string;

            /* ********************* */
            /*  ###  TINYTEXT  ###   */
            /* ********************* */

            case "TINYTEXT" :
            // $table->text('description');	TEXT equivalent column.
            // <option value="TINYTEXT">TINYTEXT</option>

                # Datatype
                $dataType = $var1."table->text('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 

            /* ********************* */
            /*    ###  TEXT  ###     */
            /* ********************* */
            
            case "TEXT" :
            // $table->text('description');	TEXT equivalent column.
            // <option value="TEXT">TEXT</option>

                # Datatype
                $dataType = $var1."table->text('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 

            /* ********************* */
            /*  ###  MEDIUMTEXT  ### */
            /* ********************* */

            case "MEDIUMTEXT" :
            // $table->mediumText('description');	MEDIUMTEXT equivalent column.
            // <option value="MEDIUMTEXT">MEDIUMTEXT</option>

                # Datatype
                $dataType = $var1."table->mediumText('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 

            /* ********************* */
            /*  ###  LONGTEXT  ###   */
            /* ********************* */

            case "LONGTEXT" :
            // $table->longText('description');	LONGTEXT equivalent column.
            // <option value="LONGTEXT">LONGTEXT</option>

                # Datatype
                $dataType = $var1."table->longText('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 

            /* ********************* */
            /*  ###  BINARY  ###     */
            /* ********************* */
            
            case "BINARY" :
            // $table->binary('data');	BLOB equivalent column.
            // <option value="BINARY">BINARY</option>

                # Datatype
                $dataType = $var1."table->binary('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 

            /* ********************* */
            /*  ###  VARBINARY  ###  */
            /* ********************* */
            
            case "VARBINARY" :
            // $table->binary('data');	BLOB equivalent column.
            // <option value="VARBINARY">VARBINARY</option>

                # Datatype
                $dataType = $var1."table->binary('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 

            /* ********************* */
            /*  ###  TINYBLOB  ###   */
            /* ********************* */
            
            case "TINYBLOB" :
            // $table->binary('data');	BLOB equivalent column.
            // <option value="TINYBLOB">TINYBLOB</option>

                # Datatype
                $dataType = $var1."table->binary('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 

            /* ********************* */
            /*  ###  MEDIUMBLOB  ### */
            /* ********************* */
            
            case "MEDIUMBLOB" :
            // $table->binary('data');	BLOB equivalent column.
            // <option value="MEDIUMBLOB">MEDIUMBLOB</option>

                # Datatype
                $dataType = $var1."table->binary('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 

            /* ********************* */
            /*  ###  LONGBLOB  ###   */
            /* ********************* */
            
            case "LONGBLOB" :
            // $table->binary('data');	BLOB equivalent column.
            // <option value="LONGBLOB">LONGBLOB</option>

                # Datatype
                $dataType = $var1."table->binary('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 

            /* ********************* */
            /*    ###  ENUM  ###     */
            /* ********************* */
            
            case "ENUM" :
            // $table->enum('level', ['easy', 'hard']);	ENUM equivalent column.
            // <option value="ENUM">ENUM</option>

                # Datatype
                $dataType = $var1."table->enum('".$attribute->attribute_name."'";

                # Length                
                if(strlen($attribute->attribute_length) > 0) {
                    $items = explode(',', $attribute->attribute_length);
                    $length = "";
                    $length .= ", [";
                    $i = 0;
                    foreach($items as $item) {
                        $length .= "'".$item."'";
                        if(count($items) == ++$i) {
                            $length .= "";
                        } else {
                            $length .= ", ";
                        }
                    }
                    $length .= "])";
                } else {
                    $length = ")";
                }

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 

            /* ********************* */
            /*    ###  SET  ###      */
            /* ********************* */
            
            case "SET" :
            // $table->enum('level', ['easy', 'hard']);	ENUM equivalent column.
            // <option value="SET">SET</option>

                # Datatype
                $dataType = $var1."table->enum('".$attribute->attribute_name."'";

                # Length                
                if(strlen($attribute->attribute_length) > 0) {
                    $items = explode(',', $attribute->attribute_length);
                    $length = "";
                    $length .= ", [";
                    $i = 0;
                    foreach($items as $item) {
                        $length .= "'".$item."'";
                        if(count($items) == ++$i) {
                            $length .= "";
                        } else {
                            $length .= ", ";
                        }
                    }
                    $length .= "])";
                } else {
                    $length = ")";
                }

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 

            /* ********************* */
            /*    ###  TIME  ###     */
            /* ********************* */
            
            case "TIME" :
            // $table->time('sunrise');	TIME equivalent column.
            // <option value="TIME">TIME</option>

                # Datatype
                $dataType = $var1."table->time('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 

            /* ********************* */
            /*     ###  YEAR  ###    */
            /* ********************* */
            
            case "YEAR" :
            // $table->year('birth_year');	YEAR equivalent column.
            // <option value="YEAR">YEAR</option>";

                # Datatype
                $dataType = $var1."table->year('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 

            /* ********************* */
            /*  ###  GEOMETRY  ###   */
            /* ********************* */
            
            case "GEOMETRY" :
            // $table->geometry('positions');	GEOMETRY equivalent column.
            // <option title="A type that can store a geometry of any type">GEOMETRY</option>

                # Datatype
                $dataType = $var1."table->geometry('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 

            /* ********************* */
            /*    ###  POINT  ###    */
            /* ********************* */
            
            case "POINT" :
            // $table->point('position');	POINT equivalent column.
            // <option title="A point in 2-dimensional space">POINT</option>

                # Datatype
                $dataType = $var1."table->point('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 

            /* ********************* */
            /*    ## LINESTRING ##   */
            /* ********************* */
            
            case "LINESTRING" :
            // $table->lineString('positions');	LINESTRING equivalent column.
            // <option title="A curve with linear interpolation between points">LINESTRING</option>

                # Datatype
                $dataType = $var1."table->lineString('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 

            /* ********************* */
            /*  ###  POLYGON  ###    */
            /* ********************* */
            
            case "POLYGON" :
            // $table->polygon('positions');	POLYGON equivalent column.
            // <option title="A polygon">POLYGON</option>

                # Datatype
                $dataType = $var1."table->polygon('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 

            /* ********************* */
            /*  ##  MULTIPOINT  ##   */
            /* ********************* */
            
            case "MULTIPOINT" :
            // $table->multiPoint('positions');	MULTIPOINT equivalent column.
            // <option title="A collection of points">MULTIPOINT</option>

                # Datatype
                $dataType = $var1."table->multiPoint('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 

            /* ********************* */
            /* #  MULTILINESTRING  # */
            /* ********************* */
            
            case "MULTILINESTRING" :
            // $table->multiLineString('positions');	MULTILINESTRING equivalent column.
            // <option title="A collection of curves with linear interpolation between points">MULTILINESTRING</option>

                # Datatype
                $dataType = $var1."table->multiLineString('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 

            /* ********************* */
            /*  ## MULTIPOLYGON  ##  */
            /* ********************* */
            
            case "MULTIPOLYGON" :
            // $table->multiPolygon('positions');	MULTIPOLYGON equivalent column.
            // <option title="A collection of polygons">MULTIPOLYGON</option>

                # Datatype
                $dataType = $var1."table->multiPolygon('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 

            /* ********************* */
            /*   GEOMETRYCOLLECTION  */
            /* ********************* */
            
            case "GEOMETRYCOLLECTION" :
            // $table->geometryCollection('positions');	GEOMETRYCOLLECTION equivalent column.
            // <option title="A collection of geometry objects of any type">GEOMETRYCOLLECTION</option>

                # Datatype
                $dataType = $var1."table->geometryCollection('".$attribute->attribute_name."'";

                # Length
                $length = $this->length($attribute);

                # Default
                $default = $this->default($attribute);

                # Attributes
                $defaultAttr = $this->defaultAttribute($attribute);

                # Null
                $null = $this->null($attribute);
                
                # Index
                $index = $this->indexDataType($attribute);

                # Auto Increment
                $autoIncrement = $this->autoIncrement($attribute);                

                $string = $dataType.$length.$default.$defaultAttr.$null.$index.$autoIncrement.";";

                return $string; 

            default:

        }           
        
    }    
  
/* *************************************************************************************************************** */
/*  ###  Length  ###                                                                                             */
/* *************************************************************************************************************** */

    /**
     * NOTE : Verify DataType As Per Laravel
     *
     * @param   Length
     * 
     * @return  Laravel Datatype
     */
    public function length($attribute)
    {
        if(strlen($attribute->attribute_length) > 0) {
            $length = ", ".$attribute->attribute_length.")";
        } else {
            $length = ")";
        }
        
        return $length;
    }    
    
/* *************************************************************************************************************** */
/*  ###  Default  ###                                                                                             */
/* *************************************************************************************************************** */

    /**
     * NOTE : Verify DataType As Per Laravel
     *
     * @param   Default
     * 
     * @return  Laravel Datatype
     */
    public function default($attribute)
    {
        if (json_decode($attribute->attribute_default)->key === "AS_DEFINED"){
            $default = "->default(".json_decode($attribute->attribute_default)->value.")";
        } else
        if (json_decode($attribute->attribute_default)->key === "NULL") {
            $default = "->nullable()";
        } else
        if (json_decode($attribute->attribute_default)->key === "CURRENT_TIMESTAMP") {
            $default = "->useCurrent()";
        } else {
            $default = "";
        }
        
        return $default;
    }
    
/* *************************************************************************************************************** */
/*  ###  Default Attributes  ###                                                                                             */
/* *************************************************************************************************************** */

    /**
     * NOTE : Verify DataType As Per Laravel
     *
     * @param   DefaultAttribute
     * 
     * @return  Laravel Datatype
     */
    public function defaultAttribute($attribute)
    {
        $defaultAttr = "";

        return $defaultAttr;        
    }   
    
/* *************************************************************************************************************** */
/*  ###  Null  ###                                                                                             */
/* *************************************************************************************************************** */

    /**
     * NOTE : Verify DataType As Per Laravel
     *
     * @param   Null
     * 
     * @return  Laravel Datatype
     */
    public function null($attribute)
    {
        if($attribute->attribute_null === "on") {
            if (json_decode($attribute->attribute_default)->key === "NONE") {
                $null = "->nullable()";
            }
        } else {
            $null = "";
        }

        return $null;        
    }  
    
/* *************************************************************************************************************** */
/*  ###  Index  ###                                                                                             */
/* *************************************************************************************************************** */

    /**
     * NOTE : Verify DataType As Per Laravel
     *
     * @param   Index
     * 
     * @return  Laravel Datatype
     */
    public function indexDataType($attribute)
    {        
        if($attribute->attribute_index === "PRIMARY") {
            $index = "->primary()";
        } else 
        if($attribute->attribute_index === "UNIQUE") {
            $index = "->unique()";
        } else
        if ($attribute->attribute_index === "INDEX") {
            $index = "->index()";
        } else 
        if ($attribute->attribute_index === "SPATIAL") {
            $index = "->spatialIndex()";
        } else {
            $index = "";
        }

        return $index;
    }

/* *************************************************************************************************************** */
/*  ###  Auto Increment  ###                                                                                             */
/* *************************************************************************************************************** */

    /**
     * NOTE : Verify DataType As Per Laravel
     *
     * @param   AutoIncrement
     * 
     * @return  Laravel Datatype
     */
    public function autoIncrement($attribute)
    {
        if($attribute->attribute_autoincrement  === "on") {
            $autoIncrement = "->increments()";
        } else {
            $autoIncrement = "";
        }

        return $autoIncrement;
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
     * @return  Success / Failure
     */
    public function createModels($tables, $modelsPath)
    {
        # Migrate for each table
        foreach($tables as $table) {

            # Initialise String
            $string = "";

            # Table Name / Class Name
            $tableName = str_replace(" ", "", ucwords(str_replace("_", " ", $table->table_code)));

            # File Name
            $fileName = $tableName.".php";
            $filePath = $modelsPath.DIRECTORY_SEPARATOR.$fileName;

            # Get Attributes For Particular Table
            $attributes = '';
            $attributes =  Attribute::where('table_uuid',$table->uuid)->get();

            # Variables
            $var1 = "$";

            $string .= "<?php".PHP_EOL.PHP_EOL;
            $string .= "namespace App;".PHP_EOL.PHP_EOL;
            $string .= "use Illuminate\Notifications\Notifiable;".PHP_EOL;
            $string .= "use Illuminate\Contracts\Auth\MustVerifyEmail;".PHP_EOL;
            $string .= "use Illuminate\Foundation\Auth\User as Authenticatable;".PHP_EOL.PHP_EOL;
            $string .= "class ".$tableName." extends Authenticatable".PHP_EOL;
            $string .= "{".PHP_EOL;
            $string .= "    use Notifiable;".PHP_EOL.PHP_EOL;
            $string .= "    use Notifiable;".PHP_EOL.PHP_EOL;
            $string .= "    /**".PHP_EOL;
            $string .= "     * The attributes that are mass assignable.".PHP_EOL;
            $string .= "     *".PHP_EOL;
            $string .= "     * @var array".PHP_EOL;
            $string .= "     */".PHP_EOL;
            $string .= "    protected ".$var1."fillable = [".PHP_EOL;
            $string .= "       ";
            foreach($attributes as $attribute) {
                if(json_decode($attribute->attribute_inputtype)->key === "PASSWORD") {
                    $string .= "";
                } else {
                    $string .= " '".$attribute->attribute_code."',";
                }
            }
            $string .= PHP_EOL;
            $string .= "    ];".PHP_EOL.PHP_EOL;
            $string .= "    /**".PHP_EOL;
            $string .= "     * The attributes that should be hidden for arrays.".PHP_EOL;
            $string .= "     *".PHP_EOL;
            $string .= "     * @var array".PHP_EOL;
            $string .= "     */".PHP_EOL;
            $string .= "    protected ".$var1."hidden = [".PHP_EOL;
            $string .= "       ";
            foreach($attributes as $attribute) {
                if(json_decode($attribute->attribute_inputtype)->key === "PASSWORD") {
                    $string .= " '".$attribute->attribute_code."',";
                } else {
                    $string .= "";
                }
            }
            $string .= PHP_EOL;
            $string .= "    ];".PHP_EOL.PHP_EOL;
            $string .= "}";

            # Create File & Copy Content
            file_put_contents($filePath, $string , FILE_APPEND | LOCK_EX);            
        }

        return "Successfully Done";
    }
    
/* *************************************************************************************************************** */
/*  ###  Create Controllers, Routes & API-Document For Project  ###                                                                       */
/* *************************************************************************************************************** */

    /**
     * NOTE : Create Controllers, Routes & API-Document For Project
     *
     * @param   array     $tables - All Tables
     * 
     * @param   string    $controllersPath - Controllers Path
     * 
     * @param   string    $routesPath - Routes Path
     * 
     * @param   string    $apiDoc - Api Doc Path
     * 
     * @return  true/false
     */
    public function createCntrlRoutApi($tables, $controllersPath, $routesPath, $apidocPath)
    {
        # Migrate for each table
        foreach($tables as $table) {

            # Initialise Strings
            $controller = "";
            $routes = "";
            $apidoc = "";

            # Table Name / Model Name
            $tableName = $this->convertToModelName($table->table_code);

            # Class Name / File Name
            $className = $tableName.'Controller';

            # Controller File Path
            $controllerFilePath = $controllersPath.DIRECTORY_SEPARATOR.$className.'.php';

            # Get Attributes For Particular Table
            $attributes = '';
            $attributes =  Attribute::where('table_uuid',$table->uuid)->get();   
            
            # Initialise Variables
            $var1 = "$";

            # Get Foreign Keys
            $foreignKeys = $this->getForeignKeys($table);

            # Get Primary Key
            $primaryKey = $this->getPrimaryKey($table);

            /* ********************* */
            /*    CONTROLLERS Task   */
            /* ********************* */

            # Open Php File
            $controller .= "<?php".PHP_EOL.PHP_EOL;
            # Using namespace API
            $controller .= "namespace App\Http\Controllers\API;".PHP_EOL.PHP_EOL;
            # Using Default Controller
            $controller .= "use App\Http\Controllers\Controller;".PHP_EOL;
            # Using Request
            $controller .= "use Illuminate\Http\Request;".PHP_EOL;
            # Using Validator
            $controller .= "use Validator;".PHP_EOL;
            # Using Auth
            $controller .= "use Illuminate\Support\Facades\Auth;".PHP_EOL;
            # Using String Support
            $controller .= "use Illuminate\Support\Str;".PHP_EOL;
            # Using Required Models
            $controller .= "use App".DIRECTORY_SEPARATOR.$tableName.";".PHP_EOL;
            if(count($foreignKeys) > 0) {
                foreach($foreignKeys as $foreignKey) {
                    $modelname = $this->convertToModelName($foreignKey->table_code);
                    $controller .= "use App".DIRECTORY_SEPARATOR.$modelname.";".PHP_EOL;
                }
            }
            # Declaring Class Name
            $controller .= PHP_EOL.PHP_EOL;
            $controller .= "class ".$className." extends Controller".PHP_EOL;
            # Open Class Brase
            $controller .= "{".PHP_EOL;
            $controller .= "    public ".$var1."successStatus = 200;".PHP_EOL.PHP_EOL;
            # fetchAll
            $controller .= "    /*".PHP_EOL;
            $controller .= "     * Method Type   : GET".PHP_EOL;
            $controller .= "     *".PHP_EOL;
            $controller .= "     * Method Name   : fetchAll".PHP_EOL;
            $controller .= "     *".PHP_EOL;
            $controller .= "     * @param  No-Params".PHP_EOL;
            $controller .= "     *".PHP_EOL;
            $controller .= "     * @return \Illuminate\Http\Response".PHP_EOL;
            $controller .= "     */".PHP_EOL;
            $controller .= "    public function fetchAll()".PHP_EOL;
            $controller .= "    {".PHP_EOL;
            $controller .= "        ".$var1.$table->table_code." = ".$tableName."::all();".PHP_EOL;
            $controller .= "        foreach(".$var1.$table->table_code." as ".$var1."temp) {".PHP_EOL;
            if(count($foreignKeys) > 0) {
                foreach($foreignKeys as $foreignKey) {
                    $modelname = $this->convertToModelName($foreignKey->table_code);
                    $OtherPrimaryKey = $this->getPrimaryKey($foreignKey);
                    $controller .= "            ";
                    $controller .= $var1."temp['_".$foreignKey->table_code."_info'] = ".$modelname."::where('".$OtherPrimaryKey->attribute_code."', ";
                    $controller .= $var1."temp->".$foreignKey->table_code.")->get() ?? [];".PHP_EOL;
                }
            }
            $controller .= "            ".$var1."data[] = ".$var1."temp;".PHP_EOL;
            $controller .= "        }".PHP_EOL.PHP_EOL;      
            $controller .= "        return response()->json(['success' => ".$var1."data], ".$var1."this-> successStatus);".PHP_EOL;
            $controller .= "    }";

            # End Class Brase 
            $controller .= "}";

            # Create Controllers File & Copy Content
            file_put_contents($controllerFilePath, $controller , FILE_APPEND | LOCK_EX);   

            /* ********************** */
            /*       ROUTES TASK      */
            /* ********************** */

            # Create Routes File & Copy Content
            $routes .= $this->createRoute("get", $table->table_code, $className, "fetchAll").PHP_EOL;
            
            # Create Routes File & Copy Content
            file_put_contents($routesPath, $routes , FILE_APPEND | LOCK_EX);  
            
            /* ********************** */
            /* API DOC - SWAGGER TASK */
            /* ********************** */

            # Create Api Doc File & Copy Content
            file_put_contents($apidocPath, $apidoc , FILE_APPEND | LOCK_EX);
        }

        return true;
    }
        
/* *************************************************************************************************************** */
/*  ###  Get Foreign Keys   ###                                                                                    */
/* *************************************************************************************************************** */

    /**
     * NOTE : Get Foreign Keys - For A Given Table
     *
     * @param   array     $table - All Tables
     * 
     * @return  array     $data
     */
    public function getForeignKeys($table)
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
/*  ###  Get Primary Key   ###                                                                                     */
/* *************************************************************************************************************** */

    /**
     * NOTE : Get Primary Key - For A Given Table
     *
     * @param   array     $table - All Tables
     * 
     * @return  object     $data
     */
    public function getPrimaryKey($table)
    {
        # Get Attributes
        $attributes =  Attribute::where('table_uuid',$table->uuid)->get();
        
        # Get Foreign Keys
        foreach($attributes as $attribute) {
            if($attribute->attribute_index === "PRIMARY" || $attribute->attribute_autoincrement === "1") {
                return $attribute;
            }
        }

        return $attribute ?? '';
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
/*  ###  Basic Route Template   ###                                                                                    */
/* *************************************************************************************************************** */

    /**
     * NOTE : Basic Route Template
     *
     * @return  string     $data
     */
    public function basicRoute()
    {
        # Initialize Variable
        $var1 = "$";

        # Initialize String
        $data = "";

        $data .= "<?php".PHP_EOL.PHP_EOL;
        $data .= "use Illuminate\Http\Request;".PHP_EOL.PHP_EOL;
        $data .= "/*".PHP_EOL;
        $data .= "|--------------------------------------------------------------------------".PHP_EOL;
        $data .= "| API Routes".PHP_EOL;
        $data .= "|--------------------------------------------------------------------------".PHP_EOL;
        $data .= "|".PHP_EOL;
        $data .= "| Here is where you can register API routes for your application. These".PHP_EOL;
        $data .= "| routes are loaded by the RouteServiceProvider within a group which".PHP_EOL;
        $data .= '| is assigned the "api" middleware group. Enjoy building your API!'.PHP_EOL;
        $data .= "|".PHP_EOL;
        $data .= "*/".PHP_EOL;
        $data .= "// Route::middleware('auth:api')->get('/user', function (Request ".$var1."request) {".PHP_EOL;
        $data .= "//     return ".$var1."request->user();".PHP_EOL;
        $data .= "// });".PHP_EOL.PHP_EOL;

        return $data;
    }
           
/* *************************************************************************************************************** */
/*  ###  Create A Route For Given Details   ###                                                                    */
/* *************************************************************************************************************** */

    /**
     * NOTE : Create A Route For Given Details
     * 
     * SAMPLE : Route::get('users', 'API\UsersController@fetchAll');
     * 
     * @param   string     $method_type
     * 
     * @param   string     $table_code
     * 
     * @param   string     $controller
     * 
     * @param   string     $method_name
     *
     * @return  string     $data
     */
    public function createRoute($method_type, $table_code, $controller, $method_name)
    {
        # Initialize Variable
        $data = "";

        $data .= "Route::".$method_type."('".$table_code."', 'API".DIRECTORY_SEPARATOR.$controller."@".$method_name."');";
        
        return $data;
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
    public function installationSteps($installationStepsPath)
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

}




// $controller .= "        ".$var1.$tableName."=".$tableName."::all();".PHP_EOL;
            // $controller .= "        foreach(".$var1."users as ".$var1."user) {".PHP_EOL;

            //      * Auth User 
//      * 
//      * we return only loggedin User Profile Images
//      * 
//      * @return \Illuminate\Http\Response 
//      */ 
//     public function fetchComments() 
//     {
//         $comments = Comments::all();
//         return response()->json(['success' => $comments], $this-> successStatus);
//     }

    /** 
     * Upload User Profiles
     * 
     * we return user profiles in blob
     * 
     * @return \Illuminate\Http\Response 
     */ 
//     public function add(Request $request)
//     {
//         # Get data
//         $data = json_decode($request->getContent(), true); 
        
//         # validation
//         $validator = Validator::make($data, [ 
//             'comment' => 'required',
//             'post_uuid' => 'required',
//         ]);

//         # validation check
//         if ($validator->fails()) { 
//             return response()->json(['error'=>$validator->errors()], 401);            
//         }

//         # LoggedIn user
//         $user = Auth::user();
       
//         # Getting all input response
//         $input['user_uuid'] = $user->uuid;
//         $input['user_name'] = $user->name;
//         $input['user_image_url'] = $user->profile_images;
//         $input['post_uuid'] = $data['post_uuid'];
//         $input['comment'] = $data['comment'];
//         $input['comment_uuid'] = $data['comment_uuid'];
          
//         # Creating uuid,tokens & password
//         $input['uuid'] = (string) Str::uuid();
//         $input['api_token'] = str_random(60);

//         # creating User
//         $comment = Comments::create($input);
                
//         return response()->json(['success'=>$comment], $this-> successStatus); 
//     }

//     /** 
//      * Auth User 
//      * 
//      * we return only loggedin User Profile Images
//      * 
//      * @return \Illuminate\Http\Response 
//      */ 
//     public function fetchComments() 
//     {
//         $comments = Comments::all();
//         return response()->json(['success' => $comments], $this-> successStatus);
//     }

//     /** 
//      * Auth User 
//      * 
//      * we return only loggedin User Profile Images
//      * 
//      * @return \Illuminate\Http\Response 
//      */ 
//     public function fetchComment($uuid) 
//     {
//         # LoggedIn user
//         $comment = Comments::where('uuid', $uuid)->get();
//         return response()->json(['success' => $comment], $this-> successStatus);
//     }
    
//     /** 
//      * Users 
//      * 
//      * we return all users
//      * 
//      * @return \Illuminate\Http\Response 
//      */ 
//     public function fetchPost($post_uuid) 
//     { 
//         $comment = Comments::where('post_uuid', $post_uuid)->get();
//         return response()->json(['success' => $comment], $this-> successStatus);
//     }

//     /** 
//      * Update Auth User
//      * 
//      * update current auth user & return user data
//      * 
//      * @return \Illuminate\Http\Response 
//      */ 
//     public function update(Request $request,$uuid)
//     {
//         # Get data
//         $data = json_decode($request->getContent(), true);
        
//         # LoggedIn user
//         $user = Auth::user();
        
//         # Getting all input response
//         $input['comment'] = $data['comment'];
                
//         # Updating Post
//         $post = Comments::where('uuid', $uuid)->where('user_uuid', $user->uuid)
//         ->update(['comment' => $input['comment']]);
        
//         if($post==1) {
//             $success = Comments::where('uuid', $uuid)->get();
//         } else {
//             return response()->json(['code'=>404,'message'=>'unable to update user data'], 404); 
//         }

//         return response()->json(['success' => $success], $this-> successStatus);
//     }

//     /** 
//      * Delete Auth User
//      * 
//      * delete current auth user
//      * 
//      * @return \Illuminate\Http\Response 
//      */ 
//     public function delete($uuid)
//     {
//         # Auth User
//         $authUser = Auth::user();
        
//         # get user profile & delete
//         $comment = Comments::where('user_uuid', $authUser->uuid)->where('uuid', $uuid)->get()->each->delete();
   
//         return response()->json(['success' => 'Successfully Deleted'], $this-> successStatus);
//     }
// }


                