<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreFieldHeaderScriptCeos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
			Schema::table('seos', function(Blueprint $table) {
            $table->text('header_script')->after('image_url_fb')->nullable();
        });
	}

	 /* Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
