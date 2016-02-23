<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class GameVote extends Eloquent
{
	use SoftDeletingTrait;
    protected $table = 'votes';
    protected $fillable = ['game_id', 'vote_rate'];
    protected $dates = ['deleted_at'];

}