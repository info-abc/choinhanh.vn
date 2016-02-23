<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class GameRelation extends Eloquent
{
	use SoftDeletingTrait;
    protected $table = 'game_category_parents';
    protected $fillable = ['category_parent_id', 'game_id'];
    protected $dates = ['deleted_at'];

    public function game() 
    {
        return $this->belongsTo('Game', 'game_id', 'id');
    }

    public function categoryparent() 
    {
        return $this->belongsTo('CategoryParent', 'category_parent_id', 'id');
    }
}