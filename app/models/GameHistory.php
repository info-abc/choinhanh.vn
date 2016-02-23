<?php
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class GameHistory extends Eloquent
{

	use SoftDeletingTrait;
    protected $table = 'game_histories';
    protected $fillable = ['game_id','user_id','time_play'];
    protected $dates = ['deleted_at'];

	public function game() 
    {
        return $this->belongsTo('Game', 'game_id', 'id');
    }

    public function user() 
    {
        return $this->belongsTo('User', 'user_id', 'id');
    }
}
