<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Type extends Eloquent implements SluggableInterface
{
	use SoftDeletingTrait;
    use SluggableTrait;
    protected $table = 'types';
    protected $fillable = ['name', 'description', 'slug', 'image_url', 'status'];
    protected $dates = ['deleted_at'];

    protected $sluggable = array(
        'build_from' => 'name',
        'save_to'    => 'slug',
    );

    public function games()
    {
        return $this->belongsToMany('Game', 'game_types', 'type_id', 'game_id');
    }

    public function gametypes()
    {
        return $this->hasMany('GameType', 'type_id', 'id');
    }

    public function parenttypes()
    {
        return $this->hasMany('ParentType', 'type_id', 'id');
    }

    public function categoryparents()
    {
        return $this->belongsToMany('CategoryParent', 'parent_types', 'type_id', 'category_parent_id');
    }
}