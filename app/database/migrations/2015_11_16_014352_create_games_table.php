<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('games', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->nullable();
            $table->string('name', 256)->nullable();
            $table->text('description')->nullable();
            $table->string('image_url', 256)->nullable();
            $table->string('link_url', 256)->nullable();
            $table->integer('count_view')->nullable();
            $table->integer('count_play')->nullable();
            $table->integer('count_vote')->nullable();
            $table->integer('count_download')->nullable();
            $table->string('vote_average', 256)->nullable();
            $table->integer('weight_number')->nullable();
            $table->integer('score_status')->nullable();
            $table->string('start_date')->nullable();
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
        Schema::drop('games');
	}

}
