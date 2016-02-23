<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFieldStatusTableSeo extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('seos', function($table)
		{
		    $table->dropColumn('status');
		});
		Schema::table('seos', function(Blueprint $table) {
            $table->integer('status_seo')->after('footer_script')->nullable();
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
