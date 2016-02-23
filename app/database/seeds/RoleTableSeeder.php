<?php

class RoleTableSeeder extends Seeder {

	public function run()
	{
		Role::create([
					'name' => 'Admin',
					'description'=> 'Role is Admin',
			]);
		Role::create([
					'name' => 'Editor',
					'description'=> 'Role is Editor',
			]);
		Role::create([
					'name' => 'Seo',
					'description'=> 'Role is Seo',
			]);
	}

}