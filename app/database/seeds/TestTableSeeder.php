<?php

class TestTableSeeder extends Seeder {

	public function run()
	{
		TestGame::create([
					'width' => '640',
					'height'=>'480'
			]);
	}

}