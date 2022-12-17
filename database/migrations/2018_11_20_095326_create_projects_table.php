<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid', 48)->unique();
            $table->string('user_uuid', 48);
            $table->string('project_name');
            $table->string('project_code')->unique();
            $table->string('programming_language');
            $table->string('framework');
            $table->string('local_protocol');
            $table->string('local_portno')->nullable();
            $table->string('local_domain_name');
            $table->string('server_protocol');
            $table->string('server_portno')->nullable();
            $table->string('server_domain_name');
            $table->string('status');
            $table->string('api_token', 60)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
