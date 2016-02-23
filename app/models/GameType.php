<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class GameType extends Eloquent
{
	use SoftDeletingTrait;
    protected $table = 'game_types';
    protected $fillable = ['type_id', 'game_id'];
    protected $dates = ['deleted_at'];

	public function game() 
    {
        return $this->belongsTo('Game', 'game_id', 'id');
    }

    public function type() 
    {
        return $this->belongsTo('Type', 'type_id', 'id');
    }
}