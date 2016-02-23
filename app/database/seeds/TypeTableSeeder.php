<?php

class TypeTableSeeder extends Seeder {

	public function run()
	{
		Type::create([
			'name'=> 'Action',
			'description' => 'This is game action of game online',
		]);
		Type::create([
			'name'=> 'Boy',
			'description' => 'This is game boy of game online',
		]);
		Type::create([
			'name'=> 'Girl',
			'description' => 'This is game girl of game online',
		]);
	}

}