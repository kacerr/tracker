<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChallengesTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('userChallenges', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned();
			$table->integer('challenge_id')->unsigned();
			$table->timestamps();
		});

		Schema::create('userChallengeDetails', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned();
			$table->integer('challenge_id')->unsigned();
			$table->integer('attribute_id')->unsigned();
			$table->string('value');
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
		Schema::drop('userChallenges');
		Schema::drop('userChallengeDetails');
	}

}
