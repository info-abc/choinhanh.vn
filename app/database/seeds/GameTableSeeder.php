<?php

class GameTableSeeder extends Seeder {

	public function run()
	{
		Game::create([
					'name' => 'Game Flash',
					'status' => ENABLED,
			]);
		Game::create([
					'name' => 'Game HTML5',
					'status' => ENABLED,
			]);
		Game::create([
					'name' => 'Game offline',
					'status' => ENABLED,
			]);
		// Game::create([
		// 			'name' => 'Game nấm lùn',
		// 			'parent_id' => '2',
		// 	]);
		// Game::create([
		// 			'name' => 'Game mèo',
		// 			'parent_id' => '2',
		// 	]);
	}

}