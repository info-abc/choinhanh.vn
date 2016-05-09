<?php

class GameController extends SiteController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function listGame($slug)
	{
		if($slug == 'online') {
			$slug = 'game-online';
		}
		if (Cache::has('categoryParent_'.$slug))
        {
            $categoryParent = Cache::get('categoryParent_'.$slug);
        } else {
            // $categoryParent = CategoryParent::findBySlug($slug);
            $categoryParent = CategoryParent::where('slug', $slug)
            					->where('status', '!=', CATEGORYPARENT_STATUS_0)
            					->first();
            Cache::put('categoryParent_'.$slug, $categoryParent, CACHETIME);
        }

		if (Cache::has('type_'.$slug))
        {
            $type = Cache::get('type_'.$slug);
        } else {
            $type = Type::findBySlug($slug);
            Cache::put('type_'.$slug, $type, CACHETIME);
        }
        if (Cache::has('tag_'.$slug))
        {
            $tag = Cache::get('tag_'.$slug);
        } else {
            $tag = AdminTag::findBySlug($slug);
            Cache::put('tag_'.$slug, $tag, CACHETIME);
        }

		if($categoryParent) {
			// $games = CommonGame::boxGameByCategoryParent($categoryParent);
			// $count = ceil(count($games->get())/PAGINATE_BOXGAME);
			// return View::make('site.game.category')->with(compact('games', 'categoryParent', 'count'));
			return View::make('site.game.category')->with(compact('categoryParent'));
		}
		if($type) {
			// $games = CommonGame::boxGameByType($type);
			// $count = ceil(count($games->get())/PAGINATE_BOXGAME);
			// return View::make('site.game.type')->with(compact('games', 'type', 'count'));
			return View::make('site.game.type')->with(compact('type'));
		}
		if($tag) {
			// $games = CommonGame::boxGameByType($type);
			// $count = ceil(count($games->get())/PAGINATE_BOXGAME);
			// return View::make('site.game.type')->with(compact('games', 'type', 'count'));
			return View::make('site.tag.index')->with(compact('tag'));
		}

		//TODO 404
		return CommonLog::logErrors(ERROR_TYPE_404);
	}

	public function detailGame($type, $slug)
	{
		$categoryParent = CategoryParent::where('status', '!=', CATEGORYPARENT_STATUS_0)->lists('slug');
		if(!in_array('game-'.$type, $categoryParent) && Type::findBySlug($type) == null) {
			if(AdminTag::findBySlug($type) == null) {
				return CommonLog::logErrors(ERROR_TYPE_404);
			}
		}

		// http://minigame.de/be-trai/game-ban-ga-hay-va-chan.html
		if (Cache::has('game_'.$slug))
        {
            $game = Cache::get('game_'.$slug);
        } else {
            $game = Game::findBySlug($slug);
            Cache::put('game_'.$slug, $game, CACHETIME);
        }

        //an game android / online...
        if(!in_array($game->parent_id, [GAMEFLASH, GAMEHTML5])) {
        	return Response::view('404', array(), 404);
        }

		$play = Input::get('play');
		if($game) {
			if(getDevice() == MOBILE) {
				if($game->parent_id == GAMEFLASH) {
					return Redirect::to($game->link_game_redirect);
				}
			}

			$count_view = $game->count_view+1;
			$game->update(array('count_view' => $count_view));
			if(getDevice() == COMPUTER) {
				$count_play = $game->count_play+1;
				$game->update(array('count_play' => $count_play));
				// cuongnt todo add count week and count month
				// week
				$date_week = $game->update_week ;
				$date_current = date('Y/m/d');
				$datecountweek = date('w');
				$month_week = date('m', strtotime($date_week));
				$month_current = date('m');
				// $end_date = strtotime("+7 day", $date_week);
				$arrayupdate = array();
				if(!$date_week)
				{
					$date_week_update = date('Y-m-d', strtotime($date_week. ' -'. $datecountweek + 1 .'days'));
					$game->update(array('update_week' => $date_week_update));
				}
				$date_week = date('Y/m/d', strtotime($date_week. ' + 7 days'));
				if($date_week >  $date_current)
				{
					$game->update(array('total_play_download_current_weekly' => $game->total_play_download_current_weekly + 1));
				}else
				{
					$game->update(array('update_week' => $date_current, 'total_play_download_before_weekly' => $game->total_play_download_current_weekly,
										'total_play_download_current_weekly' => '0'));
				}
				// month
				if( $month_current == $month_week)
				{
					$game->update(array('total_play_dowload_current_month' => $game->total_play_dowload_current_month + 1));
				}else
				{
					$game->update(array('total_play_dowload_before_month' => $game->total_play_dowload_current_month,
										'total_play_dowload_current_month' => '0'));
				}

			}
 			return $this->getViewGame($game->parent_id, $game, $play);
		}
		return CommonLog::logErrors(ERROR_TYPE_404);
	}

	public function getViewGame($parentId = null, $game = null, $play = null)
    {

    	if($parentId && $game) {
    		if(getDevice() == MOBILE) {
    			if(!(in_array($game->parent_id, [GAMEFLASH, GAMEHTML5]))) {
	    			return View::make('site.game.downloadmobile')->with(compact('game'));
	    		} else {
	    			if($play == 'true') {
	    				return View::make('site.game.onlinemobileplay')->with(compact('game'));
	    			}
	    			return View::make('site.game.onlinemobile')->with(compact('game'));
	    		}
    		} else {
    			if(!(in_array($game->parent_id, [GAMEFLASH, GAMEHTML5]))) {
	    			return View::make('site.game.downloadweb')->with(compact('game'));
	    		} else {
	    			$gametop = $this->listGameTop();
	    			if($play == 'true') {
	    				//return View::make('site.game.onlinemobileplay')->with(compact('game'));
	    				return View::make('site.game.onlinewebplay')->with(compact('game'));
	    			}
	    			return View::make('site.game.onlineweb')->with(compact('game', 'gametop'));
	    		}
    		}
    	}
    }

    public function voteGame()
    {
    	$input = array();
    	$input['game_id'] = Input::get('id');
    	$input['vote_rate'] = Input::get('rate');
    	GameVote::create($input);
    	$voteCount = GameVote::where('game_id', $input['game_id'])->count();
    	$voteAverage = GameVote::where('game_id', $input['game_id'])->avg('vote_rate');
    	$inputGame = array();
    	$inputGame['count_vote'] = $voteCount;
    	$inputGame['vote_average'] = round($voteAverage, 1);
    	Game::find($input['game_id'])->update($inputGame);
    	echo '<p><strong>Kết quả đánh giá: ' . $inputGame['vote_average'] . '/5</strong></p>';
    	Session::put('voterate'.$input['game_id'], '1');
    }

    /*
    * Get list game android
    * @ return listAndroid
    */
    public function getListGameAndroid()
    {
    	return Response::view('404', array(), 404);
    	// return View::make('site.game.showlistandroid');
    }
    // binh chon nhieu
    public function getListGameVote()
    {
    	return View::make('site.game.gamevotemany');
    }
    // choi nhieu
    public function getListGameplay()
    {
    	return View::make('site.game.gameplaymany');
    }
    // moi nhat
    public function getListGamenew()
    {
    	return View::make('site.game.gamenew');
    }
    // trang tai ve
    public function downloadPage()
    {
    	$boxList = CategoryParent::where('status_child', ACTIVE)
					->where('position', CONTENT)
					->orderBy('weight_number', 'asc')
					->get();
    	return View::make('site.game.downloadPage')->with(compact('boxList'));
    }

    public function countPlay()
    {
    	$id = Input::get('id');
    	$game = Game::find($id);
    	if($game) {
    		if(!(in_array($game->parent_id, [GAMEFLASH, GAMEHTML5]))) {
    			$count_play = $game->count_play+1;
				$game->update(array('count_play' => $count_play));

					// cuongnt todo add count week and count month
					// week
					$date_week = $game->update_week ;
					$date_current = date('Y/m/d');
					$datecountweek = date('w');
					$month_week = date('m', strtotime($date_week));
					$month_current = date('m');
					// $end_date = strtotime("+7 day", $date_week);
					$arrayupdate = array();
					if(!$date_week)
					{
						$date_week_update = date('Y-m-d', strtotime($date_week. ' -'. $datecountweek + 1 .'days'));
						$game->update(array('update_week' => $date_week_update));
					}
					$date_week = date('Y/m/d', strtotime($date_week. ' + 7 days'));
					if($date_week >  $date_current)
					{
						$game->update(array('total_play_download_current_weekly' => $game->total_play_download_current_weekly + 1));
					}else
					{
						$game->update(array('update_week' => $date_current, 'total_play_download_before_weekly' => $game->total_play_download_current_weekly,
											'total_play_download_current_weekly' => '0'));
					}
					//month
					if( $month_current == $month_week)
					{
						$game->update(array('total_play_dowload_current_month' => $game->total_play_dowload_current_month + 1));
					}else
					{
						$game->update(array('total_play_dowload_before_month' => $game->total_play_dowload_current_month,
											'total_play_dowload_current_month' => '0'));
					}
    		}
    	}
    	dd(1);
    }

    public function countDownload()
    {
    	$id = Input::get('id');
    	$game = Game::find($id);
    	if($game) {
    		$session = GameSession::where('game_id', $id)->first();
    		if(!$session) {
    			$this->sessionCountDownload($id, $game);
    		} else {
    			if($session->session_id == Session::getId()) {    				
	    			$start_time = strtotime($session->start_time);
	    			$current_time = strtotime(Carbon\Carbon::now());
	    			if($current_time - $start_time > TIMELIMITED) {
	    				$session->update(array('start_time' => Carbon\Carbon::now()));
		    			$count_download = $game->count_download+1;
						$game->update(array('count_download' => $count_download));

						// cuongnt todo add count week and count month
						// week
						$date_week = $game->update_week ;
						$date_current = date('Y/m/d');
						$datecountweek = date('w');
						$month_week = date('m', strtotime($date_week));
						$month_current = date('m');
						// $end_date = strtotime("+7 day", $date_week);
						$arrayupdate = array();
						if(!$date_week)
						{
							$date_week_update = date('Y-m-d', strtotime($date_week. ' -'. $datecountweek + 1 .'days'));
							$game->update(array('update_week' => $date_week_update));
						}
						$date_week = date('Y/m/d', strtotime($date_week. ' + 7 days'));
						if($date_week >  $date_current)
						{
							$game->update(array('total_play_download_current_weekly' => $game->total_play_download_current_weekly + 1));
						}else
						{
							$game->update(array('update_week' => $date_current, 'total_play_download_before_weekly' => $game->total_play_download_current_weekly,
												'total_play_download_current_weekly' => '0'));
						}
						//month
						if( $month_current == $month_week)
						{
							$game->update(array('total_play_dowload_current_month' => $game->total_play_dowload_current_month + 1));
						}else
						{
							$game->update(array('total_play_dowload_before_month' => $game->total_play_dowload_current_month,
												'total_play_dowload_current_month' => '0'));
						}
	    			}
    			} else {
    				$this->sessionCountDownload($id, $game);
    			}

    		}
    	}
    }

    public function sessionCountDownload($id, $game)
    {
    	GameSession::create(array('session_id' => Session::getId(), 'game_id' => $id, 'start_time' => Carbon\Carbon::now()));
		$count_download = $game->count_download+1;
		$game->update(array('count_download' => $count_download));

		// cuongnt todo add count week and count month
		// week
		$date_week = $game->update_week ;
		$date_current = date('Y/m/d');
		$datecountweek = date('w');
		$month_week = date('m', strtotime($date_week));
		$month_current = date('m');
		// $end_date = strtotime("+7 day", $date_week);
		$arrayupdate = array();
		if(!$date_week)
		{
			$date_week_update = date('Y-m-d', strtotime($date_week. ' -'. $datecountweek + 1 .'days'));
			$game->update(array('update_week' => $date_week_update));
		}
		$date_week = date('Y/m/d', strtotime($date_week. ' + 7 days'));
		if($date_week >  $date_current)
		{
			$game->update(array('total_play_download_current_weekly' => $game->total_play_download_current_weekly + 1));
		}else
		{
			$game->update(array('update_week' => $date_current, 'total_play_download_before_weekly' => $game->total_play_download_current_weekly,
								'total_play_download_current_weekly' => '0'));
		}
		//month
		if( $month_current == $month_week)
		{
			$game->update(array('total_play_dowload_current_month' => $game->total_play_dowload_current_month + 1));
		}else
		{
			$game->update(array('total_play_dowload_before_month' => $game->total_play_dowload_current_month,
								'total_play_dowload_current_month' => '0'));
		}
    }

    public function score()
    {
    	return CommonGame::saveScores();
    }

    public function importMenu()
    {
    	$menu = CategoryParent::where('position', MENU)
			->orderBy('weight_number', 'asc')->get();
		if(getDevice() == MOBILE) {
			return View::make('site.common.menu_import', array('menu' => $menu));
		} else {
			return null;
		}
    }

    public function importBxh()
    {
		$currentUrl = Input::get('currentUrl');
		$link_url = Input::get('link_url');
		if($link_url) {
			$game = Game::where('link_url', $link_url)->first();
			if($game) {
				return View::make('site.common.score_import', array('id' => $game->id));
			}
		}
    	return null;
    }

	public function getPage404($type, $slug, $word)
    {
		if ($word) {
			if(strpos(Request::url(), '/games/')) {
				return CommonLog::logErrors(ERROR_TYPE_MISSING);
			} else {
				return CommonLog::logErrors(ERROR_TYPE_404);
			}
		}
    }

    public function listReportGame()
    {
    	return View::make('site.game.total_report_game_month')->with(compact(''));
    }

    public function listGameTop()
    {
    	$now = Carbon\Carbon::now();
        $games = Game::whereNotNull('parent_id')
        		->where('start_date','<', $now)
                ->where('status', ENABLED)
                ->where('parent_id', GAMEHTML5)
                ->orWhere('parent_id', GAMEFLASH)
                ->limit(GAMETOP)
                ->orderBy(DB::raw('RAND()'))
                ->orderBy('count_play', 'desc')
                ->limit(GAMETOP_LIMITED)
                ->get();
        return View::make('site.game.topgame')->with(compact('games'));
    }

    public function listGameHtml5()
    {
    	$games = Game::whereNotNull('parent_id')
                ->where('parent_id', GAMEHTML5)
                ->orderBy('id', 'desc')
                ->get();
        foreach($games as $key => $game) {
        	$url = CommonGame::getUrlGame($game);
        	$url2 = url('games/'.$game->link_url.'/game.html');
        	echo $key+1 . '.<a href="'. $url .'">' . $game->name . '</a> - ' . $url2 . '<br>';
        }
        return 'end';
    }

    public function listGameFlash()
    {
    	$games = Game::whereNotNull('parent_id')
                ->where('parent_id', GAMEFLASH)
                ->orderBy('id', 'desc')
                ->get();
        foreach($games as $key => $game) {
        	// $url = CommonGame::getUrlGame($game);
        	$url = url('games-flash/'.$game->link_url);
        	echo $key+1 . '.<a href="'. $url .'">' . $game->name . '</a> - ' . $url . '<br>';
        }
        return 'end';
    }

    public function saveScore($slug)
    {
    	$input = Input::all();
    	$user = Auth::user()->get();
    	if(isset($user)) {
    		return CommonGame::saveScoresGame($input, $user->id);
    	}
    	else {
    		//return login site with session gname, gscore
			Session::put('gname', $input['gname']);
			Session::put('gscore', $input['gscore']);
			return Redirect::action('SiteController@login');
    	}
    	// return 
    }

}
