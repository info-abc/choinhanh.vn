<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class CommonModel extends Eloquent
{
	use SoftDeletingTrait;
    protected $table = 'common_models';
    protected $fillable = ['model_id', 'model_name'];
    protected $dates = ['deleted_at'];

    public function advertisePositions()
    {
        return $this->hasMany('AdvertisePosition', 'common_model_id', 'id');
    }
}