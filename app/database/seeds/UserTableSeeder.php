<?php

class UserTableSeeder extends Seeder {

	public function run()
	{
		User::create([
					'user_name' => 'trantung',
					'status'=>'1',
					'email'=>'trantunghn196@gmail.com',
					'password'=>Hash::make('123456'),
			]);
		User::create([
					'user_name' => 'tuancuong',
					'status'=>'1',
					'email'=>'tuancuong@gmail.com',
					'password'=>Hash::make('123456'),
			]);
		User::create([
					'user_name' => 'dung',
					'status'=>'1',
					'email'=>'dung@gmail.com',
					'password'=>Hash::make('123456'),
			]);
	}

}