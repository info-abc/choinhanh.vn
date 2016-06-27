<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('RoleTableSeeder');
		$this->call('AdminTableSeeder');
		$this->call('CategoryParentSeeder');
		$this->call('TypeTableSeeder');
		$this->call('ParentTypeSeeder');
		$this->call('GameTableSeeder');
		$this->call('GameCategoryParent');
		$this->call('AdminSeoSeeder');
		$this->call('TypeNewTableSeeder');
		//$this->call('CommentTalbeSeeder');
		//$this->call('ScoreTableSeeder');
		//$this->call('FeedbackTableSeeder');
		//$this->call('FeedbackGameTableSeeder');
		$this->call('UserTableSeeder');
	}

}
