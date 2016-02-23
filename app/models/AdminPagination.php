<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class AdminPagination extends Eloquent
{
	use SoftDeletingTrait;
    protected $table = 'paginations';
    protected $fillable = ['model_name', 'model_id',
    	'paginate_number', 'status'];
    protected $dates = ['deleted_at'];

}