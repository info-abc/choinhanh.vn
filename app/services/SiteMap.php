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
						->where('category_parents.status', CATEGORYPARENT_STATUS_0)
						->lists('game_category_parents.game_id');
		if(!$parentId) {
			$parentId = [];
		}
		$games = Game::where('status', ENABLED)
				->where('start_date', '<=', $now)
				->whereNotNull('parent_id')
				->whereNotIn('parent_id', $parentId)
				->orderBy('start_date', 'desc')
				->get();
		return $games;
	}
	public static function getNewUrlSiteMap()
	{
		$now = Carbon\Carbon::now();
		$news = AdminNew::join('type_news', 'type_news.id', '=', 'news.type_new_id')
				->select('news.*', 'type_news.name as type_name', 'type_news.slug as type_slug')
				->where('news.start_date', '<=', $now)
				->orderBy('news.start_date', 'desc')
				->get();
		return $news;
	}

}
