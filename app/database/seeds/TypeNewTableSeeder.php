<?php

class TypeNewTableSeeder extends Seeder {

	public function run()
	{
		TypeNew::create([
			'name'=> 'share',
		]);
		TypeNew::create([
			'name'=> 'news',
		]);
		TypeNew::create([
			'name'=> 'view',
		]);
	}

}