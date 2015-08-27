<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('role_id')->unsigned()->default(1);
			$table->string('name')->nullable();
			$table->string('username')->unique();
			$table->string('email')->unique();
			$table->string('password', 60);
			$table->rememberToken();
			$table->timestamp('last_seen_at')->nullable();
			$table->timestamps();

			$table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->dropForeign('roles_role_id_foreign');
		});

		Schema::drop('users');
	}

}
