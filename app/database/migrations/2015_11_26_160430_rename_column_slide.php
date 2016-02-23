<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnSlide extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('sliders', function($table)
		{
		    $table->dropColumn('script');
		    $table->dropColumn('autoPlay');
		});
		Schema::table('sliders', function(Blueprint $table) {
            $table->text('autoplay')->after('id')->nullable();
            $table->string('type', 256)->after('id')->nullable();
            $table->string('type_name', 256)->after('id')->nullable();
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
