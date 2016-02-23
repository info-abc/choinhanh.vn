<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Relation extends Eloquent
{
	use SoftDeletingTrait;
    protected $table = 'relations';
    protected $fillable = ['model_id', 'model_name', 'relation_id', 'relation_name'];
    protected $dates = ['deleted_at'];

}