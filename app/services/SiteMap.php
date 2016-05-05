<?php
class SiteMap
{
	public static function getTypeUrlSiteMap()
	{
		return Type::all();
	}
	public static function getGameUrlSiteMap()
	{
    	$now = Carbon\Carbon::now();

    	$parentId = CategoryParent::join('game_category_parents', 'game_category_parents.category_parent_id', '=', 'category_parents.id')
						// ->select('game_category_parents.game_id')
						->distinct()
						->where('category_parents.status', DISABLED)
						->lists('game_category_parents.game_id');
		if(!$parentId) {
			$parentId = [];
		}
		$games = Game::where('status', ENABLED)
				->where('start_date', '<=', $now)
				->whereNotIn('parent_id', $parentId)
				->orderBy('start_date', 'desc')
				->get();
		return $games;
	}
	public static function getNewUrlSiteMap()
	{
		$now = Carbon\Carbon::now();
		$news = AdminNew::where('start_date', '<=', $now)
				->orderBy('start_date', 'desc')
				->get();
		return $news;
	}
}
