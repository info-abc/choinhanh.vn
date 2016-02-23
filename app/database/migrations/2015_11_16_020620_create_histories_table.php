<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('histories', function(Blueprint $table) {
            $table->increments('id');
            $table->string('model_name', 256)->nullable();
            $table->integer('model_id')->nullable();
            $table->string('last_time', 256)->nullable();
            $table->integer('device')->nullable();
            $table->string('last_ip', 256)->nullable();
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
		Schema::drop('histories');
	}

}
