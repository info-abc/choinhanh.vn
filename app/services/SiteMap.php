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
		$games = Game::where('status', ENABLED)
				->where('start_date', '<=', $now)
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
