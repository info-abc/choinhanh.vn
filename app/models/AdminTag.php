<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class AdminTag extends Eloquent implements SluggableInterface
{
	use SoftDeletingTrait;
	use SluggableTrait;
    protected $table = 'tags';
    protected $fillable = ['name', 'slug', 'status', 'weight_number', 'title'];
    protected $dates = ['deleted_at'];


    protected $sluggable = array(
        'build_from' => 'name',
        'save_to'    => 'slug',
    );

    public function gameTags()
    {
        return $this->hasMany('GameTag', 'tag_id', 'id');
    }

    public function games() 
    {
        return $this->belongsToMany('Game', 'game_tags', 'tag_id', 'game_id');
    }
    
}