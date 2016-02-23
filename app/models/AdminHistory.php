<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class AdminHistory extends Eloquent
{
	use SoftDeletingTrait;
    protected $table = 'histories';
    protected $fillable = ['model_name', 'model_id', 'last_time',
    	'device', 'last_ip'];
    protected $dates = ['deleted_at'];

    public function logedits()
    {
    	return $this->hasMany('LogEdit', 'history_id', 'id');
    }

}