
<?php
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Policy extends Eloquent
{

	use SoftDeletingTrait;
	    protected $table = 'policy';
	    protected $fillable = ['title', 'description','type_policy','status'];
	    protected $dates = ['deleted_at'];

	}
?>