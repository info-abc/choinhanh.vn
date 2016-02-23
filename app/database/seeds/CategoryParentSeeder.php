<?php

class CategoryParentSeeder extends Seeder {

	public function run()
	{
		CategoryParent::create([
			'position'=> 1,
			'name'=> 'Game Android',
			'description' => 'This is game android of menu',
			'weight_number' => 1,
		]);
		CategoryParent::create([
			'position'=> 1,
			'name'=> 'Game Online',
			'description' => 'This is game online of menu',
			'weight_number' => 2,
		]);
		CategoryParent::create([
			'position'=> 2,
			'name'=> 'Game Hot',
			'description' => 'This is game of content',
			'weight_number' => 1,
		]);
		CategoryParent::create([
			'position'=> 2,
			'name'=> 'Game chơi nhiều',
			'description' => 'This is game of content',
			'weight_number' => 2,
		]);
		CategoryParent::create([
			'position'=> 2,
			'name'=> 'Game bình chọn nhiều',
			'description' => 'This is game of content',
			'weight_number' => 3,
		]);

	}

}