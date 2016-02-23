<?php

class CommentTalbeSeeder extends Seeder {

	public function run()
	{
		Comment::create([
					'user_id' => '1',
					'status' => '1',
					'model_name' => 'Game',
					'model_id' => '8',
					'description'=> 'Game hay vãi',
			]);
		Comment::create([
					'user_id' => '1',
					'status' => '0',
					'model_name' => 'Game',
					'model_id' => '8',
					'description'=> 'Tải game nay về chơi thích quá! ace tải về nhé!',
			]);
		Comment::create([
					'user_id' => '1',
					'status' => '0',
					'model_name' => 'Game',
					'model_id' => '8',
					'description'=> 'Game chán!',
			]);
	}
}
