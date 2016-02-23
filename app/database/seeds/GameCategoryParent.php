<?php

class GameCategoryParent extends Seeder {

	public function run()
	{
		GameRelation::create([
					'category_parent_id' => 3,
					'game_id'=> 2,
			]);
		GameRelation::create([
					'category_parent_id' => 4,
					'game_id'=> 2,
			]);
		GameRelation::create([
					'category_parent_id' => 5,
					'game_id'=> 2,
			]);
	}

}