<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class AdminSeo extends Eloquent
{
	use SoftDeletingTrait;
    protected $table = 'seos';
    protected $fillable = ['model_name', 'model_id', 'title_site',
    	'description_site', 'keyword_site', 'title_fb',
    	'description_fb', 'image_url_fb', 'header_script','footer_script','status_seo'];
    protected $dates = ['deleted_at'];

}