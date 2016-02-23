<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldTotalPlayAndDowloadTableGame extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('games', function(Blueprint $table) {
            $table->integer('total_play_download_current_weekly')->after('count_play')->nullable();
        });
        Schema::table('games', function(Blueprint $table) {
            $table->integer('total_play_download_before_weekly')->after('count_play')->nullable();
        });
        
        Schema::table('games', function(Blueprint $table) {
            $table->integer('total_play_dowload_current_month')->after('vote_average')->nullable();
        });
        Schema::table('games', function(Blueprint $table) {
            $table->integer('total_play_dowload_before_month')->after('vote_average')->nullable();
        });
        Schema::table('games', function(Blueprint $table) {
            $table->date('update_week')->nullable();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
