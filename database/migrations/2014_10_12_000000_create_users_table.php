<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid', 48)->unique();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('mobileno',20)->unique();
            $table->binary('profile_image')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->date('dateofbirth')->nullable();
            $table->string('account_type');
            $table->string('status');
            $table->string('api_token', 60)->unique();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
