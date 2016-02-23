<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class AdminSlide extends Eloquent
{
	use SoftDeletingTrait;
    protected $table = 'sliders';
    protected $fillable = ['type_name', 'type', 'autoplay', 'pagination',
         'navigation', 'name', 'config_speed', 'config_time'
    ];
    protected $dates = ['deleted_at'];

    public function images()
    {
        return $this->hasMany('AdminImage', 'slider_id', 'id');
    }
    public function games()
    {
        return $this->hasMany('Game', 'slide_id', 'id');
    }

}