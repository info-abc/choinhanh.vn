<?php
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class GameSession extends Eloquent
{

    protected $table = 'sessions';
    protected $fillable = ['session_id','start_time', 'game_id'];

}
