<?php
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class AdminError extends Eloquent
{

	    protected $table = 'errors';
	    protected $fillable = ['link', 'type', 'count'];

	    public function errorLogs()
	    {
	    	return $this->hasMany('AdminErrorLog', 'error_id', 'id');
	    }
}
?>