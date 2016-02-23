<?php

class FeedbackGameTableSeeder extends Seeder {

	public function run()
	{
		GameErrors::create([
					'game_id' => '8',
					'description' => 'báo lỗi game lần 1',
					'status' => '1',
			]);
		GameErrors::create([
					
					'game_id' => '8',
					'status' => '1',
					'description' => 'Báo lỗi game lần 2',
			]);
		GameErrors::create([
					'game_id' => '8',
					'status' => '0',
					'description' => 'Báo lỗi game lần 3',
			]);
		GameErrors::create([
					'game_id' => '8',
					'status' => '0',
					'description' => 'Báo lỗi game lần 4',
			]);
	}
}
