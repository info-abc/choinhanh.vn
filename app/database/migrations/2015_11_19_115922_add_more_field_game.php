<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreFieldGame extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('games', function(Blueprint $table) {
            $table->string('link_upload_game', 256)->after('link_url')->nullable();
            $table->string('link_download', 256)->after('link_upload_game')->nullable();
            $table->string('gname', 256)->after('link_upload_game')->nullable();
            $table->integer('status')->after('link_upload_game')->nullable();
            $table->string('support_detail', 256)->after('link_upload_game')->nullable();
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
