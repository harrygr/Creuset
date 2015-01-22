<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Creuset\Post;
use Creuset\User;
use Creuset\Term;


class DatabaseSeeder extends Seeder {

	private $tables = [
		'termables',
		'terms',
		'posts',
		'users',
	];

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->cleanDatabase();

		Model::unguard();

		$this->call('UsersTableSeeder');
		$this->call('PostsTableSeeder');
		$this->call('TermsTableSeeder');
		$this->call('TermablesTableSeeder');

	}


	protected function cleanDatabase()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS=0');
		foreach ($this->tables as $table)
		{
			DB::table($table)->truncate();
		}
		DB::statement('SET FOREIGN_KEY_CHECKS=1');
	}

}
