<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ParentType extends Eloquent
{
	use SoftDeletingTrait;
    protected $table = 'parent_types';
    protected $fillable = ['type_id', 'category_parent_id', 'weight_number'];
    protected $dates = ['deleted_at'];
    
    public function type() 
    {
        return $this->belongsTo('Type', 'type_id', 'id');
    }

    public function categoryparent() 
    {
        return $this->belongsTo('CategoryParent', 'category_parent_id', 'id');
    }
}