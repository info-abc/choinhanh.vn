<?php

class FeedbackTableSeeder extends Seeder {

	public function run()
	{
		Feedback::create([
					'user_id' => '1',
					'email' => 'tuancuong@gmail.com',
					'name' => 'tuancuong',
					'title' => 'đây là góp ý',
					'description' => 'đấy là mô tả góp ý 1',
					'status' => '1',
			]);
		Feedback::create([
					
					'email' => 'trantung@gmail.com',
					'name' => 'trần tùng',
					'title' => 'đây là góp ý 2',
					'description' => 'đấy là mô tả góp ý 2',
					'status' => '1',
			]);
		Feedback::create([
					'email' => 'cuongtv@gmail.com',
					'name' => 'Việt Cường',
					'title' => 'đây là góp ý 3',
					'description' => 'đấy là mô tả góp ý 3',
					'status' => '0',
			]);
		Feedback::create([
					'email' => 'sivn@gmail.com',
					'name' => 'văn sĩ',
					'title' => 'đây là góp ý 4',
					'description' => 'đấy là mô tả góp ý 4',
					'status' => '0',
			]);
	}
}