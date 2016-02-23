<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogEditsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('log_edits', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('history_id')->nullable();
            $table->integer('editor_id')->nullable();
            $table->string('editor_name', 256)->nullable();
            $table->string('editor_time', 256)->nullable();
            $table->string('editor_ip', 256)->nullable();
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
		Schema::drop('log_edits');
	}

}
