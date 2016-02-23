<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('seos', function(Blueprint $table) {
            $table->increments('id');
            $table->string('model_name', 256)->nullable();
            $table->integer('model_id')->nullable();
            $table->string('title_site', 256)->nullable();
            $table->string('description_site', 256)->nullable();
            $table->string('keyword_site', 256)->nullable();
            $table->string('title_fb', 256)->nullable();
            $table->string('description_fb', 256)->nullable();
            $table->string('image_url_fb', 256)->nullable();
            $table->string('header_script', 256)->nullable();
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
		Schema::drop('seos');
	}

}
