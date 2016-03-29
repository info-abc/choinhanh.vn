<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class GameTag extends Eloquent
{
    protected $table = 'game_tags';
    protected $fillable = ['tag_id', 'game_id'];

}