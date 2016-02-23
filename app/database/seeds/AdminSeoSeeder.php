<?php

class AdminSeoSeeder extends Seeder {

	public function run()
	{
		AdminSeo::create([
			'model_name'=> 'CategoryParent',
			'model_id' => 1,
			'description_site' => 'This is des parent 1',
		]);
		AdminSeo::create([
			'model_name'=> 'CategoryParent',
			'model_id' => 2,
			'description_site' => 'This is des parent 2',
		]);
		AdminSeo::create([
			'model_name'=> 'CategoryParent',
			'model_id' => 3,
			'description_site' => 'This is des parent 3',
		]);
		AdminSeo::create([
			'model_name'=> 'CategoryParent',
			'model_id' => 4,
			'description_site' => 'This is des parent 4',
		]);
		AdminSeo::create([
			'model_name'=> 'CategoryParent',
			'model_id' => 5,
			'description_site' => 'This is des parent 5',
		]);
		//type game 
		AdminSeo::create([
			'model_name'=> 'Type',
			'model_id' => 1,
			'description_site' => 'This is type game',
		]);
		AdminSeo::create([
			'model_name'=> 'Type',
			'model_id' => 2,
			'description_site' => 'This is type game',
		]);
		AdminSeo::create([
			'model_name'=> 'Type',
			'model_id' => 3,
			'description_site' => 'This is type game',
		]);
		//seo
		AdminSeo::create([
			'model_name'=> SEO_SCRIPT,
			'header_script' => 
			'<meta name="resource-type" content="Document" /> 
			<meta name="generator" content="choinhanh.vn" />
			<meta name="copyright" content="Công ty Cổ phần ABC" />',

			'footer_script' => 
			'<meta name="resource-type" content="Document" /> 
			<meta name="generator" content="choinhanh.vn" />
			<meta name="copyright" content="Công ty Cổ phần ABC" />',
		]);

		AdminSeo::create([
			'model_name'=> SEO_META,
			'title_site' => 'choinhanh.vn',
			'description_site' => 'Tổng hợp các game hay nhât',
			'keyword_site' => 'choinhanh',			
		]);
		
	}
}