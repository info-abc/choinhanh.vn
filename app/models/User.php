<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
	use SoftDeletingTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');
	protected $fillable = array('user_name', 'email', 'password', 
		'uid', 'uname', 'first_name', 'last_name', 'image_url',
		'full_name', 'status', 'ip', 'device', 'phone', 'google_id', 'google_name','fb_access_token');
    protected $dates = ['deleted_at'];

    public function gamehistories()
    {
        return $this->hasMany('GameHistory', 'user_id', 'id');
    }
    public function games()
    {
        return $this->belongsToMany('Game', 'game_histories', 'user_id', 'game_id');
    }
}
