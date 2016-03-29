<?php

class SiteTagController extends SiteController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getTag($slug)
	{
		$tag = AdminTag::findBySlug($slug);
		if($tag) {
			$games = $tag->games;
			return View::make('site.tag.index')->with(compact('games', 'tag'));
		} else {
			return Redirect::action('SiteController@returnPage404');
		}
	}

}
