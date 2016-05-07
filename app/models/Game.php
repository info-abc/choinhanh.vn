<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Game extends Eloquent implements SluggableInterface
{
	use SoftDeletingTrait;
    use SluggableTrait;
    protected $table = 'games';
    protected $fillable = ['parent_id', 'name', 'description',
	    'image_url', 'link_url', 'count_view', 'count_play',
	    'count_vote', 'count_download', 'vote_average',
	     'weight_number', 'score_status', 'start_date', 'status',
         'support_detail', 'gname', 'link_download',
         'link_upload_game', 'slide_id', 'slug', 'type_main','width','height','total_play_download_before_weekly','total_play_download_current_weekly',
         'total_play_dowload_before_month','total_play_dowload_current_month','update_week', 'screen', 'link_game_redirect', 'link_download_ios', 'link_download_winphone'];
    protected $dates = ['deleted_at'];

    protected $sluggable = array(
        'build_from' => 'name',
        'save_to'    => 'slug',
    );

    public function votes()
    {
        return $this->hasMany('Vote', 'game_id', 'id');
    }

    public function gamerelations()
    {
        return $this->hasMany('GameRelation', 'game_id', 'id');
    }

    public function categoryparents()
    {
        return $this->belongsToMany('CategoryParent', 'game_category_parents', 'game_id', 'category_parent_id');
    }

    public function gametypes()
    {
        return $this->hasMany('GameType', 'game_id', 'id');
    }

    public function types()
    {
        return $this->belongsToMany('Type', 'game_types', 'game_id', 'type_id');
    }

    public function slide()
    {
        return $this->belongsTo('AdminSlide', 'slide_id', 'id');
    }
    public function gamehistories()
    {
        return $this->hasMany('GameHistory', 'game_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany('User', 'game_histories', 'game_id', 'user_id');
    }

    public function gameTags()
    {
        return $this->hasMany('GameTag', 'game_id', 'id');
    }

    public function tags() 
    {
        return $this->belongsToMany('AdminTag', 'game_tags', 'game_id', 'tag_id');
    }

}