<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid', 48)->unique();
            $table->string('table_uuid', 48);
            $table->string('attribute_name');
            $table->string('attribute_code');
            $table->string('attribute_datatype');
            $table->string('attribute_length')->nullable();
            $table->string('attribute_default');
            $table->string('attribute_attributes')->nullable();
            $table->string('attribute_null');
            $table->string('attribute_index')->nullable();
            $table->string('attribute_autoincrement');
            $table->string('attribute_inputtype')->nullable();
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
        Schema::dropIfExists('attributes');
    }
}
