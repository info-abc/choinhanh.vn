<?php

class SeoTestTableSeeder extends Seeder {

	public function run()
	{
		AdminSeo::create([
			'model_name'=> 'Test',
			'model_id' => 1,
			'description_site' => 'This is des parent 1',
		]);
	}
}