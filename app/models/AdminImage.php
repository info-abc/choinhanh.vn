<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class AdminImage extends Eloquent
{
	use SoftDeletingTrait;
    protected $table = 'images';
    protected $fillable = ['slider_id', 'image_url', 'name'];
    protected $dates = ['deleted_at'];

    public function slide()
    {
    	return $this->belongsTo('AdminSlide', 'slider_id', 'id');
    }

}