<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Role extends Eloquent
{
	use SoftDeletingTrait;
    protected $table = 'roles';
    protected $fillable = ['name', 'description'];
    protected $dates = ['deleted_at'];

    public function admins()
    {
        return $this->hasMany('Admin', 'role_id', 'id');
    }
}