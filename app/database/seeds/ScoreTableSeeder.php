<?php

class ScoreTableSeeder extends Seeder {

	public function run()
	{
		Score::create([
					'user_id' => '1',
					'game_id' => '4',
					'score' => '500',
			]);
		Score::create([
					'user_id' => '2',
					'game_id' => '4',
					'score' => '300',
			]);
		Score::create([
					'user_id' => '3',
					'game_id' => '4',
					'score' => '300',
			]);
		Score::create([
					'user_id' => '1',
					'game_id' => '11',
					'score' => '2500',
			]);
	}
}
