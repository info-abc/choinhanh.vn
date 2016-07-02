<?php
class CommonGame
{
	public static function uploadAction($fileUpload, $isFile = NULL, $issetFile = NULL, $isUnique = NULL)
	{
		if(Input::hasFile($fileUpload)){
			$file = Input::file($fileUpload);
			$filename = $file->getClientOriginalName();
			$extension = $file->getClientOriginalExtension();
			if(isset($isUnique)) {
				$filename = changeFileNameImage($filename);
			}
			if($isFile != '') {
				$pathUpload = self::getPathFile($extension);
			} else {
				$pathUpload = public_path().UPLOAD_GAME_AVATAR;
			}
			$uploadSuccess = $file->move($pathUpload, $filename);
		}
		if(isset($uploadSuccess)) {
			if(isset($isFile) && $extension == 'zip') {
				$pathUnzip = public_path().UPLOAD_GAME;
				Zipper::make($pathUpload.'/'.$filename)->extractTo($pathUnzip);
			}
			return $filename;
		}
		if($issetFile) {
			return $issetFile;
		}
	}

	public static function getPathFile($extension = null)
	{
		if($extension) {
			if($extension == 'zip') {
				return public_path().UPLOAD_GAMEZIP;
			}
			if($extension == 'swf') {
				return public_path().UPLOAD_FLASH;
			}
			if($extension == 'apk') {
				return public_path().UPLOAD_GAMEOFFLINE;
			}
		}
		return null;
	}

	public static function inputActionGame($id = NULL)
	{
		if($id) {
			$issetFile = self::getIssetFile($id, TRUE);
			$issetAvatar = self::getIssetFile($id);
		} else {
			$issetFile = '';
			$issetAvatar = '';
		}
		$inputGame = array();
		$inputGame['image_url'] = self::uploadAction('image_url', '', $issetAvatar,  IS_UPLOAD_UNIQUE);
		$inputGame['link_upload_game'] = self::uploadAction('link_upload_game', IS_UPLOAD_FILE, $issetFile);
		$inputGame['name'] = Input::get('name');
		$inputGame['description'] = Input::get('description');
		$inputGame['link_download'] = Input::get('link_download');
		$inputGame['link_download_ios'] = Input::get('link_download_ios');
		$inputGame['link_download_winphone'] = Input::get('link_download_winphone');
		//check link upload game , link_url
		if(Input::get('link_url')) {
			$inputGame['link_url'] = Input::get('link_url');
		} elseif(!Input::get('link_url') && $inputGame['link_upload_game']) {
			$inputGame['link_url'] = getFilename($inputGame['link_upload_game']);
		}
		$inputGame['parent_id'] = Input::get('parent_id');
		$inputGame['weight_number'] = Input::get('weight_number');
		if($inputGame['weight_number'] == '') {
			$inputGame['weight_number'] = 0;
		}
		$inputGame['start_date'] = Input::get('start_date');
		if($inputGame['start_date'] == '') {
			$inputGame['start_date'] = Carbon\Carbon::now();
		}
		$inputGame['status'] = Input::get('status');
		$inputGame['score_status'] = Input::get('score_status');
		$inputGame['gname'] = Input::get('gname');
		$inputGame['slide_id'] = Input::get('slide_id');
		$inputGame['type_main'] = Input::get('type_main');
		$inputGame['width'] = Input::get('width');
		$inputGame['height'] = Input::get('height');
		$inputGame['screen'] = Input::get('screen');
		$inputGame['link_game_redirect'] = Input::get('link_game_redirect');
		return $inputGame;
	}

	public static function getIssetFile($id, $isFile = NULL)
	{
		if($isFile){
			$result = Game::find($id)->link_upload_game;
		} else {
			$result = Game::find($id)->image_url;
		}
		if ($result) {
			return $result;
		}
		return NULL;
	}

	public static function searchAdminGame($input)
	{
		$orderBy = self::searchAdminGameSortBy($input);
		$data = Game::where(function ($query) use ($input) {
			if ($input['keyword'] != '') {
				$inputSlug = convert_string_vi_to_en($input['keyword']);
				$inputSlug = strtolower( preg_replace('/[^a-zA-Z0-9]+/i', '-', $inputSlug) );
				$query = $query->where('slug', 'like', '%'.$inputSlug.'%');
							// ->orWhere('name', 'like', '%'.$input['keyword'].'%');
			}
			if($input['parent_id'] != '') {
				$query = $query->where('parent_id', $input['parent_id']);
			}
			if($input['parent_id'] == '') {
				$query = $query->whereNotNull('parent_id');
			}
			// if($input['category_parent_id'] != '') {
			// 	$list = CategoryParent::find($input['category_parent_id'])->categoryparentrelations->lists('game_id');
			// 	$query = $query->whereIn('id', $list);
			// }
			if($input['type_id'] != '') {
				$listType = Type::find($input['type_id'])->gametypes->lists('game_id');
				$query = $query->whereIn('id', $listType);
			}
			if($input['status'] != '') {
				$query = $query->where('status', $input['status']);
			}
			if($input['start_date'] != ''){
				$query = $query->where('start_date', '>=', $input['start_date']);
			}
			if($input['end_date'] != ''){
				$query = $query->where('start_date', '<=', $input['end_date'] . ' 23:59:59');
			}
			if(isset($input['status_seo']) && $input['status_seo'] != '')
			{
				$listSeo = AdminSeo::where('model_name', 'Game')->where('status_seo', $input['status_seo'])->lists('model_id');
				$query = $query->whereIn('id', $listSeo);
			}
		})
		// ->lists('id');
		// return $data;
		// dd($data);
		->orderBy($orderBy[0], $orderBy[1])
		->paginate(PAGINATE);
		//dd(DB::getQueryLog());
		return $data;
	}

	public static function searchAdminGameSortBy($input)
	{
		$sortBy = 'start_date';
		$sort = 'desc';
		if(isset($input['sortByCountView']) && $input['sortByCountView'] != '') {
			if($input['sortByCountView'] == 'count_view_asc') {
				$sortBy = 'count_view';
				$sort = 'asc';
			}
			if($input['sortByCountView'] == 'count_view_desc') {
				$sortBy = 'count_view';
				$sort = 'desc';
			}
		}
		if($input['sortByCountPlay'] != '') {
			if($input['sortByCountPlay'] == 'count_play_asc') {
				$sortBy = 'count_play';
				$sort = 'asc';
			}
			if($input['sortByCountPlay'] == 'count_play_desc') {
				$sortBy = 'count_play';
				$sort = 'desc';
			}
		}
		if(isset($input['sortByCountVote']) && $input['sortByCountVote'] != '') {
			if($input['sortByCountVote'] == 'count_vote_asc') {
				$sortBy = 'count_vote';
				$sort = 'asc';
			}
			if($input['sortByCountVote'] == 'count_vote_desc') {
				$sortBy = 'count_vote';
				$sort = 'desc';
			}
		}
		if(isset($input['sortByCountDownload']) && $input['sortByCountDownload'] != '') {
			if($input['sortByCountDownload'] == 'count_download_asc') {
				$sortBy = 'count_download';
				$sort = 'asc';
			}
			if($input['sortByCountDownload'] == 'count_download_desc') {
				$sortBy = 'count_download';
				$sort = 'desc';
			}
		}
		// weight_number
		if($input['sortByweightNumber'] != '') {
			if($input['sortByweightNumber'] == 'weight_number_asc') {
				$sortBy = 'weight_number';
				$sort = 'asc';
			}
			if($input['sortByweightNumber'] == 'weight_number_desc') {
				$sortBy = 'weight_number';
				$sort = 'desc';
			}
		}
		return [$sortBy, $sort];
	}


	// get games, orderBy arrange category parent, paging
	public static function boxGameByCategoryParent($data, $device = null, $paginate = null)
	{
		if($device == null) {
			$device = getDevice();
		} else {
			$device = getDevice($device);
		}
		$now = Carbon\Carbon::now();
		$arrange = getArrange($data->arrange);
		$game = $data->games->first();
		if($game) {
			if($paginate) {
				if($device == MOBILE) {
					$listGame = Game::where('parent_id', '!=', GAMEFLASH)
						->where('status', ENABLED)
						->where('parent_id', $game->id)
						->where('start_date', '<=', $now)
						->orderBy($arrange, 'desc')
						->paginate(PAGINATE_LISTGAME);
				} else {
					$listGame = Game::where('parent_id', $game->id)
						->where('status', ENABLED)
						->where('start_date', '<=', $now)
						->orderBy($arrange, 'desc')
						->paginate(PAGINATE_LISTGAME);
				}
			} else {
				if($device == MOBILE) {
					$listGame = Game::where('parent_id', '!=', GAMEFLASH)
						->where('status', ENABLED)
						->where('parent_id', $game->id)
						->where('start_date', '<=', $now)
						->orderBy($arrange, 'desc');
				} else {
					$listGame = Game::where('parent_id', $game->id)
						->where('status', ENABLED)
						->where('start_date', '<=', $now)
						->orderBy($arrange, 'desc');
				}
			}
			return $listGame;
		}
		return null;
	}

	public static function boxGameByType($data, $device = null, $paginate = null)
	{
		if($device == null) {
			$device = getDevice();
		} else {
			$device = getDevice($device);
		}
		$now = Carbon\Carbon::now();
		$games = Type::find($data->id)->gametypes->lists('game_id');
		if($games) {
			if($paginate) {
				if($device == MOBILE) {
					$listGame = Game::whereIn('id', $games)
						->where('status', ENABLED)
						->where('parent_id', '=', GAMEHTML5)
						->where('start_date', '<=', $now)
						->orderBy('id', 'desc')
						->paginate(PAGINATE_LISTGAME);
				} else {

					$listGame = Game::whereIn('id', $games)
						->where('status', ENABLED)
						->where('start_date', '<=', $now)
						->whereIn('parent_id', [GAMEHTML5, GAMEFLASH])
						->orderBy('id', 'desc')
						->paginate(PAGINATE_LISTGAME);
				}
			} else {
				if($device == MOBILE) {
					$listGame = Game::whereIn('id', $games)
						->where('status', ENABLED)
						->where('parent_id', '=', GAMEHTML5)
						->where('start_date', '<=', $now);
				} else {
					$listGame = Game::whereIn('id', $games)
						->where('status', ENABLED)
						->where('start_date', '<=', $now)
						->whereIn('parent_id', [GAMEHTML5, GAMEFLASH]);
				}
			}
			return $listGame;
		}
		return null;
	}

	public static function boxGameByCategoryParentIndex($data, $device = null)
	{
		$now = Carbon\Carbon::now();
		$arrange = getArrange($data->arrange);
		$game = $data->games->first();
		if($game) {
			if(getDevice($device) == MOBILE) {
				if (Cache::has('listGameMobile'.$game->id.$arrange))
				{
					$listGame = Cache::get('listGameMobile'.$game->id.$arrange);
				} else {
					$listGame = DB::table('games')
						->join('types', 'types.id', '=', 'games.type_main')
						->join('games as category', 'category.id', '=', 'games.parent_id')
						->select('games.id', 'games.name', 'games.slug', 'games.description'
								, 'games.parent_id', 'games.type_main', 'games.image_url'
								, 'games.count_play', 'games.count_download', 'games.vote_average'
								, 'types.name as type_name', 'types.slug as type_slug'
								, 'category.slug as category_slug')
						->distinct()
						->where('games.parent_id', '!=', GAMEFLASH)
						->where('games.parent_id', $game->id)
						->where('games.status', ENABLED)
						->where('games.start_date', '<=', $now)
						->whereNull('games.deleted_at');
				if($data->arrange == GAME_NEWEST){
					$listGame = $listGame->orderBy('games.'.$arrange, 'desc')
						->get();
				}
				else{
					$listGame = $listGame->orderByRaw(DB::raw("games.weight_number = '0', games.weight_number"))->orderBy('games.'.$arrange, 'desc')->get();
					}
					Cache::put('listGameMobile'.$game->id.$arrange, $listGame, CACHETIME);
				}
			} else {
				if (Cache::has('listGamePC'.$game->id.$arrange))
				{
					$listGame = Cache::get('listGamePC'.$game->id.$arrange);
				} else {
					if (in_array($game->id, [GAMEFLASH, GAMEHTML5])) {
						$listGame = DB::table('games')
						->join('types', 'types.id', '=', 'games.type_main')
						->join('games as category', 'category.id', '=', 'games.parent_id')
						->select('games.id', 'games.name', 'games.slug', 'games.description'
								, 'games.parent_id', 'games.type_main', 'games.image_url'
								, 'games.count_play', 'games.count_download', 'games.vote_average'
								, 'types.name as type_name', 'types.slug as type_slug'
								, 'category.slug as category_slug')
						->distinct()
						// ->where('games.parent_id', $game->id)
						->where('games.status', ENABLED)
						->where('games.start_date', '<=', $now)
						->whereIn('games.parent_id', [GAMEFLASH, GAMEHTML5])
						->whereNull('games.deleted_at');
					}
					else{
						$listGame = DB::table('games')
						->join('types', 'types.id', '=', 'games.type_main')
						->join('games as category', 'category.id', '=', 'games.parent_id')
						->select('games.id', 'games.name', 'games.slug', 'games.description'
								, 'games.parent_id', 'games.type_main', 'games.image_url'
								, 'games.count_play', 'games.count_download', 'games.vote_average'
								, 'types.name as type_name', 'types.slug as type_slug'
								, 'category.slug as category_slug')
						->distinct()
						->where('games.parent_id', $game->id)
						->where('games.status', ENABLED)
						->where('games.start_date', '<=', $now)
						->whereNull('games.deleted_at');
					}
					if($data->arrange == GAME_NEWEST){
						$listGame = $listGame->orderBy('games.'.$arrange, 'desc')
							->get();
					} else{
						$listGame = $listGame->orderByRaw(DB::raw("games.weight_number = '0', games.weight_number"))->orderBy('games.'.$arrange, 'desc')->get();
					}
					Cache::put('listGamePC'.$game->id.$arrange, $listGame, CACHETIME);
				}
			}
			return $listGame;
		}
		return null;
	}

	public static function boxGameByTag($data, $device = null, $paginate = null)
	{
		if($device == null) {
			$device = getDevice();
		} else {
			$device = getDevice($device);
		}
		$now = Carbon\Carbon::now();
		$gameIds = AdminTag::find($data->id)->gameTags->lists('game_id');
		if($gameIds) {
			if($paginate) {
				if($device == MOBILE) {
					$listGame = Game::whereIn('id', $gameIds)
						->where('status', ENABLED)
						->where('parent_id', '=', GAMEHTML5)
						->where('start_date', '<=', $now)
						->orderBy('start_date', 'desc')
						->orderBy('id', 'desc')
						->paginate(PAGINATE_LISTGAME);
				} else {

					$listGame = Game::whereIn('id', $gameIds)
						->where('status', ENABLED)
						->where('start_date', '<=', $now)
						->whereIn('parent_id', [GAMEHTML5, GAMEFLASH])
						->orderBy('start_date', 'desc')
						->orderBy('id', 'desc')
						->paginate(PAGINATE_LISTGAME);
				}
			} else {
				if($device == MOBILE) {
					$listGame = Game::whereIn('id', $gameIds)
						->where('status', ENABLED)
						->where('parent_id', '=', GAMEHTML5)
						->where('start_date', '<=', $now);
				} else {
					$listGame = Game::whereIn('id', $gameIds)
						->where('status', ENABLED)
						->where('start_date', '<=', $now);
						// ->whereIn('parent_id', [GAMEHTML5, GAMEFLASH]);
				}
			}
			return $listGame;
		}
		return null;
	}

	// url game
	public static function getUrlGame($game, $slug = null, $noCache = null)
	{
		if($game) {
			if($slug) {
				return url('game-' . $slug . '/' . $game->slug);
			}
			if (!(in_array($game->parent_id, [GAMEFLASH, GAMEHTML5]))) {
				if($noCache == null) {
					if (Cache::has('category'.$game->parent_id))
					{
						$category = Cache::get('category'.$game->parent_id);
					} else {
						$category = Game::find($game->parent_id);
						Cache::put('category'.$game->parent_id, $category, CACHETIME);
					}
				} else {
					$category = Game::find($game->parent_id);
				}
				return $url = url('/' . $category->slug . '/' . $game->slug);
			}
			if($noCache == null) {
				if (Cache::has('type'.$game->type_main))
				{
					$type = Cache::get('type'.$game->type_main);
				} else {
					$type = Type::find($game->type_main);
					Cache::put('type'.$game->type_main, $type, CACHETIME);
				}
			} else {
				$type = Type::find($game->type_main);
			}
			if($type) {
				$url = url('game-' . $type->slug . '/' . $game->slug);
				return $url;
			} else {
				dd('Đường dẫn sai');
			}
		} else {
			return url('/');
		}
	}

	// url download game
	public static function getUrlDownload($game = null, $type = null)
	{
		if($game) {
			if($type == 'android') {
				if($game->link_download != '') {
					return url($game->link_download);
				}
			}
			if($type == 'ios') {
				if($game->link_download_ios != '') {
					return url($game->link_download_ios);
				}
			}
			if($type == 'winphone') {
				if($game->link_download_winphone != '') {
					return url($game->link_download_winphone);
				}
			}
			if($game->link_url != '') {
				$checkHttp = strpos($game->link_url, 'http://');
				$checkHttps = strpos($game->link_url, 'https://');
				if($checkHttp !== false || $checkHttps !== false) {
					return $game->link_url;
				} else {
					return url(UPLOAD_GAMEOFFLINE . '/' . $game->link_url);
				}
			}
		}
		return '#';
	}

	// Other games by parent_id with limit
	public static function getRelateGame($parentId, $limit, $typeId)
	{
		$now = Carbon\Carbon::now();
		if($parentId && $limit && $typeId) {
			if(getDevice() == MOBILE) {
				if (Cache::has('listGameRelateMobile'.$parentId))
				{
					$listGame = Cache::get('listGameRelateMobile'.$parentId);
				} else {
					$listGame = Game::where('parent_id', $parentId)
						->where('status', ENABLED)
						->where('start_date', '<=', $now)
						->where('parent_id', '!=', GAMEFLASH)
						->where('type_main', $typeId)
						->orderBy(DB::raw('RAND()'))
						->limit($limit)->get();
					Cache::put('listGameRelateMobile'.$parentId, $listGame, CACHETIME);
				}
			} else {
				if (Cache::has('listGameRelate'.$parentId))
				{
					$listGame = Cache::get('listGameRelate'.$parentId);
				} else {
					$listGame = Game::where('parent_id', $parentId)
						->where('status', ENABLED)
						->where('start_date', '<=', $now)
						->where('type_main', $typeId)
						->orderBy(DB::raw('RAND()'))
						->limit($limit)->get();
					Cache::put('listGameRelate'.$parentId, $listGame, CACHETIME);
				}
			}
			return $listGame;
		}
		return null;
	}

	// link to file folder play game online
	public static function getLinkGame($game = null)
	{
		if($game) {
			// $ext = getExtension($game->link_upload_game);
			$filename = getFilename($game->link_upload_game);
			if($game->parent_id == GAMEFLASH) {
				if($game->link_url != '') {
					$checkHttp = strpos($game->link_url, 'http://');
					$checkHttps = strpos($game->link_url, 'https://');
					if($checkHttp !== false || $checkHttps !== false) {
						$link = $game->link_url;
					} else {
						$link = url(UPLOAD_FLASH . '/' . $game->link_url); // . '.swf'
					}
				} else {
					$link = url(UPLOAD_FLASH . '/' . $game->link_upload_game);
				}
				$box = self::getBoxGame($link, $game);
				return $box;
			}
			if($game->parent_id == GAMEHTML5) {
				if($game->link_url != '') {
					$checkHttp = strpos($game->link_url, 'http://');
					$checkHttps = strpos($game->link_url, 'https://');
					if($checkHttp !== false || $checkHttps !== false) {
						$link = $game->link_url;
						$linkGameHtml = $game->link_url;
					} else {
						$link = url(UPLOAD_GAME . '/' . $game->link_url);
						$linkGameHtml = $link . '/game.html';
					}
				} else {
					$link = url(UPLOAD_GAME . '/' . $filename);
					$linkGameHtml = $link . '/game.html';
				}
				$box = self::getBoxGame($link, $game, $linkGameHtml);
				return $box;
			}
		}
		return null;
	}

	public static function getBoxGame($link, $game, $linkGameHtml = '')
	{
		$width = (isset($game->width) && $game->width != '')?($game->width):'640';
		$height = (isset($game->height) && $game->height != '')?($game->height):'480';

		$ad = AdCommon::getAd(POSITION_GAMEDETAIL);
		if(!empty($ad)) {
			$adsense = $ad->adsense;
		} else {
			$adsense = '';
		}

		if($adsense != '') {
			if($game->parent_id == GAMEFLASH) {
				$box = '<div id="game-ad">
					<object
						classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" 
						codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" 
						width="'.$width.'" height="'.$height.'" 
						id="preloader" 
						align="middle">
						<param name="allowScriptAccess" value="always" />
						<param name="allowFullScreen" value="false" />
					    <param name="movie" value="'. url('games-flash/ima3_preloader_1.5.swf') .'" type="application/x-shockwave-flash"></param>
					    <param name="quality" value="high" />
					    <param name="bgcolor" value="#ffffff" />
					    <param name="wmode" value="transparent"></param>
					    <param name="flashvars" value="'.$adsense.'" />
					    <embed src="'. url('games-flash/ima3_preloader_1.5.swf') .'" 
				          	type="application/x-shockwave-flash" 
							quality="high" bgcolor="#000000" 
							width="'.$width.'" height="'.$height.'" 
							name="preloader" 
				          	align="middle" allowScriptAccess="always" 
				          	allowFullScreen="false" 
				          	flashVars="'.$adsense.'" 
				          	pluginspage="http://www.adobe.com/go/getflashplayer" 
				          	wmode="direct">
					    </embed>
					</object>
				</div>
				<div id="game-container" style="display:none;">
					<object
						classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" 
						codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" 
						width="'.$width.'" height="'.$height.'" 
						id="preloader" 
						align="middle">
						<param name="allowScriptAccess" value="always" />
						<param name="allowFullScreen" value="false" />
					    <param name="movie" value="'.$link.'" type="application/x-shockwave-flash"></param>
					    <param name="quality" value="high" />
					    <param name="bgcolor" value="#ffffff" />
					    <param name="wmode" value="transparent"></param>
					    <param name="flashvars" value="'.$adsense.'" />
					    <embed src="'.$link.'" 
				          	type="application/x-shockwave-flash" 
							quality="high" bgcolor="#000000" 
							width="'.$width.'" height="'.$height.'" 
							name="preloader" 
				          	align="middle" allowScriptAccess="always" 
				          	allowFullScreen="false" 
				          	flashVars="'.$adsense.'" 
				          	pluginspage="http://www.adobe.com/go/getflashplayer" 
				          	wmode="direct">
					    </embed>
					</object>
				</div>
				<script type="text/javascript">
					function removeAdSwf() {
						console.log(1);
						document.getElementById("game-ad").innerHTML = "";
						// document.getElementById("preloader").style.visibility = "hidden";
						document.getElementById("game-container").style.display="block";
					}
					function noAdsReturned() {
						console.log(2);
						document.getElementById("game-ad").innerHTML = "";
						// document.getElementById("preloader").style.visibility = "hidden";
						document.getElementById("game-container").style.display="block";
					}
				</script>';
				return $box;
			}

			if($game->parent_id == GAMEHTML5) {
				if($linkGameHtml != '') {
					$link = $linkGameHtml;
				} else {
					$link = $link . '/game.html';
				}
				$box = '<div id="game-ad">
					<object
						classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" 
						codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" 
						width="'.$width.'" height="'.$height.'" 
						id="preloader" 
						align="middle">
						<param name="allowScriptAccess" value="always" />
						<param name="allowFullScreen" value="false" />
					    <param name="movie" value="'. url('games-flash/ima3_preloader_1.5.swf') .'" type="application/x-shockwave-flash"></param>
					    <param name="quality" value="high" />
					    <param name="bgcolor" value="#ffffff" />
					    <param name="wmode" value="transparent"></param>
					    <param name="flashvars" value="'.$adsense.'" />
					    <embed src="'. url('games-flash/ima3_preloader_1.5.swf') .'" 
				          	type="application/x-shockwave-flash" 
							quality="high" bgcolor="#000000" 
							width="'.$width.'" height="'.$height.'" 
							name="preloader" 
				          	align="middle" allowScriptAccess="always" 
				          	allowFullScreen="false" 
				          	flashVars="'.$adsense.'" 
				          	pluginspage="http://www.adobe.com/go/getflashplayer" 
				          	wmode="direct">
					    </embed>
					</object>
				</div>
				<div id="game-container" style="display:none; margin: 10px auto; width: '.$width.'px; height: '.$height.'px;">
					<iframe name="my-iframe" id="my-iframe" width="100%" src="'.$link.'" height="100%" scrolling="no" frameborder="0" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true" webkit-playsinline="true" seamless="seamless" style="-webkit-transform: scale(1, 1);
					-o-transform: scale(1, 1);
					-ms-transform: scale(1, 1);
					transform: scale(1, 1);
					-moz-transform-origin: top left;
					-webkit-transform-origin: top left;
					-o-transform-origin: top left;
					-ms-transform-origin: top left;
					transform-origin: top left;
					frameborder: 0px;">
					</iframe>
				</div>
				<script type="text/javascript">
					function removeAdSwf() {
						console.log(1);
						document.getElementById("game-ad").innerHTML = "";
						// document.getElementById("preloader").style.visibility = "hidden";
						document.getElementById("game-container").style.display="block";
						document.getElementById("my-iframe").contentWindow.location.reload();
					}
					function noAdsReturned() {
						console.log(2);
						document.getElementById("game-ad").innerHTML = "";
						// document.getElementById("preloader").style.visibility = "hidden";
						document.getElementById("game-container").style.display="block";
						document.getElementById("my-iframe").contentWindow.location.reload();
					}
				</script>';
				return $box;
			}
		} else {
			if($game->parent_id == GAMEFLASH) {
				$box = '<embed type="application/x-shockwave-flash" src="' . $link .'" width="'.$width.'" height="'.$height.'" style="undefined" id="game" name="game" quality="high" wmode="direct">';
				return $box;
			}

			if($game->parent_id == GAMEHTML5) {
				if($linkGameHtml != '') {
					$link = $linkGameHtml;
				} else {
					$link = $link . '/game.html';
				}
				$box = '<div style="margin: 10px auto; width: '.$width.'px; height: '.$height.'px;">
						<iframe name="my-iframe" id="my-iframe" width="100%" src="'.$link.'" height="100%" scrolling="no" frameborder="0" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true" webkit-playsinline="true" seamless="seamless" style="-webkit-transform: scale(1, 1);
						-o-transform: scale(1, 1);
						-ms-transform: scale(1, 1);
						transform: scale(1, 1);
						-moz-transform-origin: top left;
						-webkit-transform-origin: top left;
						-o-transform-origin: top left;
						-ms-transform-origin: top left;
						transform-origin: top left;
						frameborder: 0px;">
						</iframe>
					</div>';
				return $box;
			}
		}
		
	}

	//get link play game for games HTML5
	public static function getLinkPlayGameHtml5($game = null, $gameUrl = null, $play = null)
	{
		// if(isset($play) && isset($gameUrl)) {
		// 	return $gameUrl.'?play=true';
		// }
		if($game) {
			$filename = getFilename($game->link_upload_game);
			if($game->parent_id == GAMEHTML5) {
				if($game->link_url != '') {
					$checkHttp = strpos($game->link_url, 'http://');
					$checkHttps = strpos($game->link_url, 'https://');
					if($checkHttp !== false || $checkHttps !== false) {
						$link = $game->link_url;
						//play game
						if(isset($play) && isset($gameUrl)) {
							return $gameUrl.'?play=true';
						}
					} else {
						$link = url(UPLOAD_GAME . '/' . $game->link_url);
					}
				} else {
					$link = url(UPLOAD_GAME . '/' . $filename);
				}
				return $link;
			}
		}
		return View::make('404');
	}

	public static function getStyle()
	{
		if(getDevice() == MOBILE) {
			$style = 'width: 100%; height: 100%;';
		} else {
			$style = 'width: 100%; height: 450px;';
		}
		return $style;
	}

	public static function getSlide()
	{
		return AdminSlide::lists('name', 'id');
	}

	public static function getGameScore($gameId)
	{
		$score = Score::where('game_id', $gameId)
					->orderBy('score', 'desc')
					->groupBy('user_id')
					->limit(GAMESCORE_LIMITED)
					->get();
		if($score) {
			return $score;
		} else {
			return null;
		}
	}

	public static function getGameMost()
	{
		$now = Carbon\Carbon::now();
		$games = Game::whereNotNull('parent_id')
				->where('status', ENABLED)
				->where('parent_id', GAMEHTML5)
				->where('start_date', '<=', $now)
				->orderBy('count_play', 'desc')
				->orderBy('start_date', 'desc')
				->limit(PAGINATE_BOXGAME)
				->get();
		return $games;
	}

	/**
	* Get list game for binh chon nhieu + hay nhat + download
	* @return list game
	*
	*/
	public static function getListGame($view = null, $device = null)
	{
		$games = null;
		if($device == null) {
			$device = getDevice();
		} else {
			$device = getDevice($device);
		}
		$now = Carbon\Carbon::now();
		if($device == MOBILE) {
			$games = Game::whereNotNull('parent_id')
				->where('status', ENABLED)
				->where('start_date', '<=', $now);
			if($view != 'android') {
				$games = $games->whereIn('parent_id', [GAMEFLASH, GAMEHTML5]);
			}
				// ->where('parent_id', GAMEHTML5)
				// ->orWhere(function($games)
	   //          {
	   //          	$games->where('parent_id', GAMEFLASH);
	   //          	$games->where('link_game_redirect', '!=', '');
	   //          });
		} else {
			$games = Game::whereNotNull('parent_id')
				->where('status', ENABLED)
				->where('start_date', '<=', $now);
		}
		//check game category
		if($view == 'android') {
			$games = $games->where('parent_id', GAMEOFFLINE);
		}
		//to do: vote, play for gamehtml5 only
		if($view == 'vote' || $view == 'play') {
			$games = $games->whereIn('parent_id', [GAMEFLASH, GAMEHTML5]);
		}
		return $games;
	}

	public static function getUrlCategoryParent($id)
	{
		if($id == GAME_NEW) {
			return action('GameController@getListGamenew');
		}
		if($id == GAME_ANDROID) {
			return action('GameController@getListGameAndroid');
		}
		if($id == GAME_PLAY_MANY) {
			return action('GameController@getListGameplay');
		}

		return '#';
	}

	public static function getGameByType($typeId, $noCache = null, $device = null)
	{
		$listGame = null;
		if($device == null) {
			$device = getDevice();
		} else {
			$device = getDevice($device);
		}
		if($noCache == null) {
			if (Cache::has('getGameByType_'.$typeId))
	        {
	            $listGame = Cache::get('getGameByType_'.$typeId);
	        } else {
	        	$now = Carbon\Carbon::now();
				$gameIds = Type::find($typeId)->gametypes->lists('game_id');
				if($gameIds) {
					if($device == MOBILE) {
						$listGame = Game::whereIn('id', $gameIds)
							->where('status', ENABLED)
							->where('parent_id', '=', GAMEHTML5)
							->where('start_date', '<=', $now);
					} else {
						$listGame = Game::whereIn('id', $gameIds)
							->where('status', ENABLED)
							->where('start_date', '<=', $now)
							->whereIn('parent_id', [GAMEHTML5, GAMEFLASH]);
					}
					$listGame = $listGame->orderBy('start_date', 'desc')
									->limit(6)
									->get();
					Cache::put('getGameByType_'.$typeId, $listGame, CACHETIME);
				}
	        }
		} else {
			$now = Carbon\Carbon::now();
			$gameIds = Type::find($typeId)->gametypes->lists('game_id');
			if($gameIds) {
				if($device == MOBILE) {
					$listGame = Game::whereIn('id', $gameIds)
						->where('status', ENABLED)
						->where('parent_id', '=', GAMEHTML5)
						->where('start_date', '<=', $now);
				} else {
					$listGame = Game::whereIn('id', $gameIds)
						->where('status', ENABLED)
						->where('start_date', '<=', $now)
						->whereIn('parent_id', [GAMEHTML5, GAMEFLASH]);
				}
				$listGame = $listGame->orderBy('start_date', 'desc')
								->limit(6)
								->get();
			}
		}
		return $listGame;
	}

	public static function getBoxMiniGame($noCache = null, $device = null)
	{
		if($noCache == null) {
			if (Cache::has('getBoxMiniGame'))
	        {
	            $result = Cache::get('getBoxMiniGame');
	        } else {
	        	$result = array();
				$types = Type::all();
				if($types) {
					foreach($types as $key => $value) {
						$games = self::getGameByType($value->id);
						$result[$key] = array(
							'type_id' => $value->id,
							'type_name' => $value->name,
							'type_slug' => $value->slug,
							'games' => $games
						);
					}
				}
	            Cache::put('getBoxMiniGame', $result, CACHETIME);
	        }
		} else {
			$result = array();
			$types = Type::all();
			if($types) {
				foreach($types as $key => $value) {
					$games = self::getGameByType($value->id, $noCache, $device);
					$result[$key] = array(
						'type_id' => $value->id,
						'type_name' => $value->name,
						'type_slug' => $value->slug,
						'games' => $games
					);
				}
			}
		}
		return $result;
	}

	public static function getRelated($game, $device = null)
	{
		if($device == null) {
			$device = getDevice();
		} else {
			$device = getDevice($device);
		}
		$games = '';
		$now = Carbon\Carbon::now();
		if($device == MOBILE) {
			$limit = GAME_RELATED_MOBILE;
		} else {
			$limit = GAME_RELATED_WEB;
		}
		$tags = GameTag::where('game_id', $game->id)->lists('tag_id');
		$games = Game::join('game_tags', 'game_tags.game_id', '=', 'games.id')
			->join('tags', 'tags.id', '=', 'game_tags.tag_id')
			->select('games.*')
			->distinct()
			->where('games.id', '!=', $game->id)
			->where('games.status', ENABLED)
			->where('games.start_date', '<=', $now);
		if($device == MOBILE) {
			$games = $games->where('games.parent_id', '!=', GAMEFLASH)
				->whereIn('game_tags.tag_id', $tags)
				->orderBy(DB::raw('RAND()'))
				->take($limit)
				->get();
		} else {
			$games = $games->whereIn('game_tags.tag_id', $tags)
				->orderBy(DB::raw('RAND()'))
				->take($limit)
				->get();
		}
		$dataListCount = count($games);
		$dataListGame = self::getDataListGames($dataListCount, $limit, $game, $now, $games, $device);
		return [$games, $dataListGame];
	}

	public static function getDataListGames($dataListCount, $limit, $game, $now, $games, $device = null)
	{
		$dataListGame = '';
		if($dataListCount < $limit) {
			$dataListLimit = $limit - $dataListCount;
			if($device == MOBILE) {
				$dataListGame = Game::where('status', ENABLED)
					->where('parent_id', '!=', GAMEFLASH)
					->where('start_date', '<=', $now)
					->where('games.id', '!=', $game->id)
					->where('type_main', $game->type_main)
		    		->orderBy('start_date', 'desc')
		    		->take($dataListLimit)
		    		->get();
			} else {
				$dataListGame = Game::where('status', ENABLED)
					->where('start_date', '<=', $now)
					->where('games.id', '!=', $game->id)
					->where('type_main', $game->type_main)
					// ->whereNotIn('id', $games->lists('games.id'))
		    		->orderBy('start_date', 'desc')
		    		->take($dataListLimit)
		    		->get();
			}
		}
		return $dataListGame;
	}

	public static function saveScores()
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
    		return 1;
    	}
    	return 0;
	}

	public static function saveScoresGame($input, $userId)
	{
		$game = Game::where('gname', $input['gname'])
				->where('score_status', SAVESCORE)
				->first();
		if($game) {
			$gameScore = Score::where('game_id', $game->id)
							->where('user_id', $userId)
							->first();
			if ($gameScore) {
				$inputData = array(
    				'score' => $input['gscore']
    				);
    			$gameScore->update($inputData);
			}
			else {
				$gameId = $game->id;
    			$inputData = array(
    				'user_id' => $userId,
    				'gname' => $input['gname'],
    				'game_id' => $gameId,
    				'score' => $input['gscore']
    				);
				Score::create($inputData);
			}
			// return Redirect::action('SiteIndexController@index');
			return Redirect::to('http://choinhanh.vn');
		}
		else {
			// return Redirect::action('SiteIndexController@index');
			return Redirect::to('http://choinhanh.vn');
		}
	}

	public static function getBoxGameRight($orderBy = null)
	{
		$now = Carbon\Carbon::now();
		if(getDevice() == MOBILE) {
			$games = Game::where('status', ENABLED)
						->where('start_date', '<=', $now)
						->where('parent_id', '!=', GAMEFLASH);
		} else {
			$games = Game::where('status', ENABLED)
						->where('start_date', '<=', $now)
						->whereIn('parent_id', [GAMEFLASH, GAMEHTML5]);
		}
		if($orderBy == null) {
			$games = $games->orderBy(DB::raw('RAND()'));
		} else {
			$games = $games->orderBy($orderBy, 'desc');
		}
		$games = $games->limit(GAMETOP_LIMITED)->get();
		return $games;
	}

	public static function boxGameByCategoryParentIndex2($data)
	{
		$now = Carbon\Carbon::now();
		$arrange = getArrange($data->arrange);
		$game = $data->games->first();
		if($game) {
			$listGame = DB::table('games')
				->join('types', 'types.id', '=', 'games.type_main')
				->join('games as category', 'category.id', '=', 'games.parent_id')
				->select('games.id', 'games.name', 'games.slug', 'games.description'
						, 'games.parent_id', 'games.type_main', 'games.image_url'
						, 'games.count_play', 'games.count_download', 'games.vote_average'
						, 'types.name as type_name', 'types.slug as type_slug'
						, 'category.slug as category_slug')
				->distinct()
				->where('games.parent_id', '!=', GAMEFLASH)
				->where('games.parent_id', $game->id)
				->where('games.status', ENABLED)
				->where('games.start_date', '<=', $now)
				->whereNull('games.deleted_at');
			if($data->arrange == GAME_NEWEST){
				$listGame = $listGame->orderBy('games.'.$arrange, 'desc')->get();
			} else {
				$listGame = $listGame->orderByRaw(DB::raw("games.weight_number = '0', games.weight_number"))->orderBy('games.'.$arrange, 'desc')->get();
			}
			return $listGame;
		}
		return null;
	}

	public static function boxGameByCategoryParentIndex3($data)
	{
		$now = Carbon\Carbon::now();
		$arrange = getArrange($data->arrange);
		$game = $data->games->first();
		if($game) {
			if (in_array($game->id, [GAMEFLASH, GAMEHTML5])) {
				$listGame = DB::table('games')
				->join('types', 'types.id', '=', 'games.type_main')
				->join('games as category', 'category.id', '=', 'games.parent_id')
				->select('games.id', 'games.name', 'games.slug', 'games.description'
						, 'games.parent_id', 'games.type_main', 'games.image_url'
						, 'games.count_play', 'games.count_download', 'games.vote_average'
						, 'types.name as type_name', 'types.slug as type_slug'
						, 'category.slug as category_slug')
				->distinct()
				->where('games.status', ENABLED)
				->where('games.start_date', '<=', $now)
				->whereIn('games.parent_id', [GAMEFLASH, GAMEHTML5])
				->whereNull('games.deleted_at');
			}
			else{
				$listGame = DB::table('games')
				->join('types', 'types.id', '=', 'games.type_main')
				->join('games as category', 'category.id', '=', 'games.parent_id')
				->select('games.id', 'games.name', 'games.slug', 'games.description'
						, 'games.parent_id', 'games.type_main', 'games.image_url'
						, 'games.count_play', 'games.count_download', 'games.vote_average'
						, 'types.name as type_name', 'types.slug as type_slug'
						, 'category.slug as category_slug')
				->distinct()
				->where('games.parent_id', $game->id)
				->where('games.status', ENABLED)
				->where('games.start_date', '<=', $now)
				->whereNull('games.deleted_at');
			}
			if($data->arrange == GAME_NEWEST){
				$listGame = $listGame->orderBy('games.'.$arrange, 'desc')->get();
			} else{
				$listGame = $listGame->orderByRaw(DB::raw("games.weight_number = '0', games.weight_number"))->orderBy('games.'.$arrange, 'desc')->get();
			}
			return $listGame;
		}
		return null;
	}

	public static function countGameTag($tagId, $gametype)
	{
		$gametag = AdminTag::join('game_tags', 'game_tags.tag_id', '=', 'tags.id')
					->join('games', 'games.id', '=', 'game_tags.game_id')
					->where('game_tags.tag_id', $tagId)
					->where('games.parent_id', $gametype)
					->count();
		return $gametag;
	}

	public static function getListGameTop()
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
        return $games;
    }

    public static function getLinkGameDirect($game = null)
	{
		if($game) {
			// $ext = getExtension($game->link_upload_game);
			$filename = getFilename($game->link_upload_game);
			if($game->parent_id == GAMEFLASH) {
				if($game->link_url != '') {
					$checkHttp = strpos($game->link_url, 'http://');
					$checkHttps = strpos($game->link_url, 'https://');
					if($checkHttp !== false || $checkHttps !== false) {
						$link = $game->link_url;
					} else {
						$link = url(UPLOAD_FLASH . '/' . $game->link_url); // . '.swf'
					}
				} else {
					$link = url(UPLOAD_FLASH . '/' . $game->link_upload_game);
				}
			}
			if($game->parent_id == GAMEHTML5) {
				if($game->link_url != '') {
					$checkHttp = strpos($game->link_url, 'http://');
					$checkHttps = strpos($game->link_url, 'https://');
					if($checkHttp !== false || $checkHttps !== false) {
						$link = $game->link_url;
					} else {
						$link = url(UPLOAD_GAME . '/' . $game->link_url);
						$link = $link . '/game.html';
					}
				} else {
					$link = url(UPLOAD_GAME . '/' . $filename);
					$link = $link . '/game.html';
				}
			}
		}
		return $link;
	}

	public static function loadGameBoxQuery($view, $orderBy, $device=null)
	{
		if($device == null) {
			$device = getDevice();
		} else {
			$device = getDevice($device);
		}
		$now = Carbon\Carbon::now();
		if($device == MOBILE) {
			$listGame = Game::whereNotNull('parent_id')
				->where('status', ENABLED)
				->where('start_date', '<=', $now)
				->whereIn('parent_id', [GAMEFLASH, GAMEHTML5]);
		} else {
			$listGame = Game::whereNotNull('parent_id')
				->where('status', ENABLED)
				->where('start_date', '<=', $now);
		}
		//check game category
		if($view == 'android') {
			$listGame = $listGame->where('parent_id', GAMEOFFLINE);
		}
		//to do: vote, play for gamehtml5 only
		if($view == 'vote' || $view == 'play') {
			$listGame = $listGame->whereIn('parent_id', [GAMEFLASH, GAMEHTML5]);
		}
		return $listGame;
	}

	public static function loadGameBox($view, $orderBy, $device=null, $i=0)
	{
		$view = (Input::get('view'))?Input::get('view'):$view;
		$orderBy = (Input::get('orderBy'))?Input::get('orderBy'):$orderBy;
		$device = (Input::get('device'))?Input::get('device'):$device;
		if(Input::get('i')) {
			$i = Input::get('i');
			$i--;
		}
		$listGame = self::loadGameBoxQuery($view, $orderBy, $device);
		$listGame = $listGame->orderBy($orderBy, 'desc')
					->take(PAGINATE_BOXGAME)
					->skip($i * PAGINATE_BOXGAME)
					->get();
		// return View::make('site.game.gamebox')->with(compact('listGame'));
		return View::make('site.game.gamebox_cronjob')->with(compact('listGame', 'device'));
	}

	public static function countGameBox($view, $orderBy)
	{
		$listGame = self::loadGameBoxQuery($view, $orderBy);
		$count = ceil(count($listGame->get())/PAGINATE_BOXGAME);
		return $count;
	}

}
