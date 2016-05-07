<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class CategoryParent extends Eloquent implements SluggableInterface
{
	use SoftDeletingTrait;
    use SluggableTrait;
    protected $table = 'category_parents';
    protected $fillable = ['name', 'position', 'description', 'weight_number', 'slug', 'arrange', 'status', 'status_child'];
    protected $dates = ['deleted_at'];

    protected $sluggable = array(
        'build_from' => 'name',
        'save_to'    => 'slug',
    );

    public function categoryparentrelations()
    {
        return $this->hasMany('GameRelation', 'category_parent_id', 'id');
    }
    public function games()
    {
        return $this->belongsToMany('Game', 'game_category_parents', 'category_parent_id', 'game_id');
    }

    public function parenttypes()
    {
        return $this->hasMany('ParentType', 'category_parent_id', 'id');
    }
    public function types()
    {
        return $this->belongsToMany('Type', 'parent_types', 'category_parent_id', 'type_id');
    }
}