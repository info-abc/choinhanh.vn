<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSluggableColumns extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('games', function(Blueprint $table)
		{
			$table->string('slug', 256)->after('name')->nullable();
		});
		Schema::table('news', function(Blueprint $table)
		{
			$table->string('slug', 256)->after('title')->nullable();
		});
		Schema::table('type_news', function(Blueprint $table)
		{
			$table->string('slug', 256)->after('name')->nullable();
		});
		Schema::table('types', function(Blueprint $table)
		{
			$table->string('slug', 256)->after('name')->nullable();
		});
		Schema::table('category_parents', function(Blueprint $table)
		{
			$table->string('slug', 256)->after('name')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('games', function(Blueprint $table)
		{
			$table->dropColumn('slug');
		});
		Schema::table('news', function(Blueprint $table)
		{
			$table->dropColumn('slug');
		});
		Schema::table('type_news', function(Blueprint $table)
		{
			$table->dropColumn('slug');
		});
		Schema::table('types', function(Blueprint $table)
		{
			$table->dropColumn('slug');
		});
		Schema::table('category_parents', function(Blueprint $table)
		{
			$table->dropColumn('slug');
		});
	}

}