<?php
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class GameErrors extends Eloquent
{

	use SoftDeletingTrait;
    protected $table = 'game_errors';
    protected $fillable = ['game_id','description','device','ip','status'];
    protected $dates = ['deleted_at'];

	 
}
