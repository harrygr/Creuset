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
		'roles',
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

	/**
	 * Remove any data currently in the database tables
	 */
	protected function cleanDatabase()
	{
		$this->disableForeignKeyCheck();
		foreach ($this->tables as $table)
		{
			DB::table($table)->truncate();
		}
		$this->enableForeignKeyCheck();
	}

	protected function disableForeignKeyCheck()
	{
		$statement = $this->getForeignKeyCheckStatement();
		DB::statement($statement['disable']);
	}

	protected function enableForeignKeyCheck()
	{
		$statement = $this->getForeignKeyCheckStatement();
		DB::statement($statement['enable']);
	}

	protected function getForeignKeyCheckStatement()
	{
		$driver = \DB::connection()->getDriverName();

		if ($driver == 'sqlite')
		{
			return [
			'disable' => 'PRAGMA foreign_keys = OFF',
			'enable'  => 'PRAGMA foreign_keys = ON',
			];

		}

		return [
		'disable' => 'SET FOREIGN_KEY_CHECKS=0',
		'enable'  => 'SET FOREIGN_KEY_CHECKS=1',
		];
	}

}
