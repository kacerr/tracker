<?php

use Illuminate\Database\Migrations\Migration;

class AddColumnVisibleToBlogposts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::table('blogposts', function($table)
	    {
	        $table->boolean('visible')->default(true);
	    });
    }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	    Schema::table('blogposts', function($table)
	    {
	        $table->dropColumn('visible');
	    });
	}
}