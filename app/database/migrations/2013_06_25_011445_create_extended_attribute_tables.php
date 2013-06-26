<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtendedAttributeTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('extendedAttributeType', function(Blueprint $table)
		{
			$table->integer('id')->unsigned()->primary();
			$table->string('objectType');
			$table->string('name');
		});

		Schema::create('extendedAttribute', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('parentId')->unsigned();
			$table->integer('parentType')->unsigned();
			$table->text('value')->nullable();
			$table->text('valueJson')->nullable();
			$table->integer('attributeId')->unsigned();
			$table->foreign('attributeId')->references('id')->on('extendedAttributeType');

		});


	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('extendedAttribute');
		Schema::drop('extendedAttributeType');
	}

}
