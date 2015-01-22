<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('terms', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('taxonomy')->default('category');
			$table->string('term');
			$table->string('slug');
			$table->timestamps();
		});

		Schema::create('termables', function(Blueprint $table)
		{
			$table->integer('term_id')->unsigned();
			$table->integer('termable_id')->unsigned();
			$table->string('termable_type');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('terms');
		Schema::drop('termables');
	}

}
