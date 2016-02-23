<?php
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Feedback extends Eloquent
{

	use SoftDeletingTrait;
	    protected $table = 'feedbacks';
	    protected $fillable = ['user_id', 'name', 'email' ,'title','description','device','ip','status'];
	    protected $dates = ['deleted_at'];

	}
?>