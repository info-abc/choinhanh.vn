<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
            $table->increments('id');
            $table->string('user_name', 256)->nullable();
            $table->string('email', 256)->nullable();
            $table->string('password', 256)->nullable();
            $table->string('uid', 256)->nullable();
            $table->string('uname', 256)->nullable();
            $table->string('first_name', 256)->nullable();
            $table->string('last_name', 256)->nullable();
            $table->string('full_name', 256)->nullable();
            $table->string('remember_token', 256)->nullable();
            $table->integer('status')->nullable();
            $table->string('ip', 256)->nullable();
            $table->string('device', 256)->nullable();
            $table->string('google_name', 256)->nullable();
            $table->string('google_id', 256)->nullable();
            $table->string('image_url', 256)->nullable();
            $table->softDeletes();
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
		Schema::drop('users');
	}

}
