<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class LogEdit extends Eloquent
{
	use SoftDeletingTrait;
    protected $table = 'log_edits';
    protected $fillable = ['history_id', 'editor_id', 'editor_name',
    	'editor_time', 'editor_ip', 'action'];
    protected $dates = ['deleted_at'];

    public function history()
    {
    	return $this->belongsTo('AdminHistory', 'history_id', 'id');
    }
}