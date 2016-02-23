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
		if (Cache::has('categoryParent_'.$slug))
        {
            $categoryParent = Cache::get('categoryParent_'.$slug);
        } else {
            $categoryParent = CategoryParent::findBySlug($slug);
            Cache::put('categoryParent_'.$slug, $categoryParent, CACHETIME);
        }
		if (Cache::has('type_'.$slug))
        {
            $type = Cache::get('type_'.$slug);
        } else {
            $type = Type::findBySlug($slug);
            Cache::put('type_'.$slug, $type, CACHETIME);
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
		//TODO 404
		return CommonLog::logErrors(ERROR_TYPE_404);
	}

	public function detailGame($type, $slug)
	{
		// http://minigame.de/be-trai/game-ban-ga-hay-va-chan.html
		if (Cache::has('game_'.$slug))
        {
            $game = Cache::get('game_'.$slug);
        } else {
            $game = Game::findBySlug($slug);
            Cache::put('game_'.$slug, $game, CACHETIME);
        }
		$play = Input::get('play');
		if($game) {
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
    	return View::make('site.game.showlistandroid');
    }

    public function getListGameVote()
    {
    	return View::make('site.game.gamevotemany');
    }

    public function getListGameplay()
    {
    	return View::make('site.game.gameplaymany');
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

    		} else {
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
    		}
    	}
    }

    public function score()
    {
    	$gname = Input::get('gname');
    	$score = Input::get('score');
    	if($user_id = Auth::user()->get()->id) {
    		$game = Game::where('gname', $gname)
    					->where('score_status', SAVESCORE)
    					->first();
    		if($game) {
    			$game_id = $game->id;
    			$input = array(
    				'user_id' => $user_id,
    				'gname' => $gname,
    				'game_id' => $game_id,
    				'score' => $score
    				);
    			Score::create($input);
    		}
    	}
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
        	echo $key+1 . '.<a href="'. $url .'">' . $game->name . '</a><br>';
        	if($key == 32) {
        		echo '- end 1->33 -<br>';
        	}
        	if($key == 65) {
        		echo '- end 33->66 -<br>';
        	}
        }
        return 'end';
    }

}
