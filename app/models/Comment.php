<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Comment extends Eloquent
{
	use SoftDeletingTrait;
    protected $table = 'comments';
    protected $fillable = ['user_id', 'status', 'model_name', 
	    'model_id', 'description'];
    protected $dates = ['deleted_at'];


}