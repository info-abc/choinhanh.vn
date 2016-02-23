<?php
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class AdminErrorLog extends Eloquent
{

	    protected $table = 'error_logs';
	    protected $fillable = ['error_id', 'agent', 'referer'];

	    public function error()
	    {
	    	return $this->belongsTo('AdminError', 'error_id', 'id');
	    }
}
?>