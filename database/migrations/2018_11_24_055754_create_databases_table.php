<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatabasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('databases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid', 48)->unique();
            $table->string('project_uuid', 48);
            $table->string('database_code');
            $table->string('database_connection')->nullable();
            $table->string('database_host')->nullable();
            $table->string('database_port')->nullable();
            $table->string('database_name');
            $table->string('database_user_name')->nullable();
            $table->string('database_password')->nullable();
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
        Schema::dropIfExists('databases');
    }
}
