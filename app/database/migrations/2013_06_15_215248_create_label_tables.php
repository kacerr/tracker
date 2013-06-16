<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabelTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('labels', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('label');
		});

		Schema::create('blogpost_labels', function(Blueprint $table)
		{
			$table->integer('blogpost_id');
			$table->integer('label_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('labels', function(Blueprint $table)
		{
			Schema::drop('labels');
		});
		Schema::table('blogpost_labels', function(Blueprint $table)
		{
			Schema::drop('blogpost_labels');
		});

	}

}