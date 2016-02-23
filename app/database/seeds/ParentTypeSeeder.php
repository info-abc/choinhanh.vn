<?php

class ParentTypeSeeder extends Seeder {

	public function run()
	{
		ParentType::create([
					'type_id' => 1,
					'category_parent_id'=> 2,
					'weight_number' => 1,
			]);
		ParentType::create([
					'type_id' => 2,
					'category_parent_id'=> 2,
					'weight_number' => 2,
			]);
		ParentType::create([
					'type_id' => 3,
					'category_parent_id'=> 2,
					'weight_number' => 3,
			]);
	}

}