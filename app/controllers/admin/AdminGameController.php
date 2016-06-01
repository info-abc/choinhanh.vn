<?php

class AdminGameController extends AdminController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data = Game::where('parent_id', '!=', '')->orderBy('start_date', 'desc')->paginate(PAGINATE);
		return View::make('admin.game.index')->with(compact('data'));
	}

	public function search()
	{
		$input = Input::all();
		$data = CommonGame::searchAdminGame($input);
		return View::make('admin.game.index')->with(compact('data'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.game.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array(
			'name' => 'required|unique:games',
			'parent_id' => 'required'
		);
		//if(Input::get('parent_id') == GAMEOFFLINE && empty(Input::get('link_download')) ) {
			//$rules['link_download'] = 'required';
		//}
		if(in_array(Input::get('parent_id'), [GAMEHTML5, GAMEFLASH])) {
			$rules = array_merge($rules, array('type_id' => 'required', 'type_main' => 'required'));
		}
		if(Input::get('score_status') == SAVESCORE) {
			$rules['gname'] = 'required';
		}

		$input = Input::except('_token');
		$validator = Validator::make($input,$rules);
		if($validator->fails()) {
			return Redirect::action('AdminGameController@create')
	            ->withErrors($validator)->withInput($input);
        } else {

        	// $folderName = substr($filename, 0, -4);
        	//unzip game file , public/games/link_url/
        	// $result = File::makeDirectory($pathUpload.'/'.$folderName, 0755);

			$inputGame = CommonGame::inputActionGame();

			//insert slide_id

        	//insert game
			$id = CommonNormal::create($inputGame);

			$data = Game::find($id);

			if($data) {
				RelationBox::insertRelationship($data, 'types', Input::get('type_id'));
				// RelationBox::insertRelationship($data, 'categoryparents', Input::get('category_parent_id'));
				RelationBox::insertRelationship($data, 'tags', Input::get('tag_id'));
			}
			//insert histories: model_name, model_id, last_time, device, last_ip
			$history_id = CommonLog::insertHistory('Game', $id);

			//insert log_edits: history_id, Auth::admin()->get()->id; editor_name, editor_time, editor_ip
			CommonLog::insertLogEdit('Game', $id, $history_id, CREATE);

			//SEO
			CommonSeo::createSeo('Game', $id, FOLDER_SEO_GAME);

			// CREATE HTMLPAGE
			$this->createHtmlPageGame($data);

			return Redirect::action('AdminGameController@index')->with('message', 'Đã thêm');
        }
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
		$inputGame = Game::find($id);
		$inputSeo = AdminSeo::where('model_id', $id)->where('model_name', 'Game')->first();
		if(!Admin::isSeo()){
			return View::make('admin.game.edit')->with(compact('inputGame', 'inputSeo'));
		} else {
			return View::make('admin.game.editForSeo')->with(compact('inputGame', 'inputSeo'));
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		if(!Admin::isSeo()) {
			$rules = array(
				'name' => 'required',
				'parent_id' => 'required'
			);
			//if(Input::get('parent_id') == GAMEOFFLINE && empty(Input::get('link_download')) ) {
				//$rules['link_download'] = 'required';
			//}
			if(in_array(Input::get('parent_id'), [GAMEHTML5, GAMEFLASH])) {
				$rules = array_merge($rules, array('type_id' => 'required', 'type_main' => 'required'));
			}
			if(Input::get('score_status') == SAVESCORE) {
				$rules['gname'] = 'required';
			}
		} else {
			$rules = array();
		}

		$input = Input::except('_token');
		$validator = Validator::make($input, $rules);
		if($validator->fails()) {
			return Redirect::action('AdminGameController@edit', $id)
	            ->withErrors($validator)
	            ->withInput($input);
        } else {

        	//SEO cant update game
        	if(!Admin::isSeo()) {

				$inputGame = CommonGame::inputActionGame($id);
				
				//update slide_id

	        	//update game
				CommonNormal::update($id, $inputGame);

				$data = Game::find($id);

				if($data) {
					RelationBox::updateRelationship($data, 'types', Input::get('type_id'));
					// RelationBox::updateRelationship($data, 'categoryparents', Input::get('category_parent_id'));
					RelationBox::updateRelationship($data, 'tags', Input::get('tag_id'));
				}
			}

			//update histories: model_name, model_id, last_time, device, last_ip
			$history_id = CommonLog::updateHistory('Game', $id);

			//update log_edits: history_id, Auth::admin()->get()->id; editor_name, editor_time, editor_ip
			CommonLog::insertLogEdit('Game', $id, $history_id, EDIT);

			//SEO
			CommonSeo::updateSeo('Game', $id, FOLDER_SEO_GAME);

			// CREATE HTMLPAGE
			$this->createHtmlPageGame($data);

			return Redirect::action('AdminGameController@index')->with('message', 'Đã sửa');
        }
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$data = Game::find($id);
		if ($data) {
			$history_id = CommonLog::updateHistory('Game', $id);
			CommonLog::insertLogEdit('Game', $id, $history_id, REMOVE);

			RelationBox::deleteRelationship($data, 'types');
			RelationBox::deleteRelationship($data, 'categoryparents');
			RelationBox::deleteRelationship($data, 'tags');

			CommonNormal::delete($id);

	        return Redirect::action('AdminGameController@index')->with('message', 'Đã xóa');
		}
		return Redirect::action('AdminGameController@index')->with('message', 'Game không tồn tại');
	}

	public function history($id)
	{
		$historyId = CommonLog::getIdHistory('Game', $id);
		if ($historyId) {
			$history = AdminHistory::find($historyId);
			$logEdit = $history->logedits;
			return View::make('admin.game.history')->with(compact('history', 'logEdit'));
		}
		return Redirect::action('AdminGameController@index')->with('message', 'Lịch sử game này đã bị xoá');
	}

	public function deleteHistory($id)
	{
		$history = AdminHistory::find($id);
		if ($history) {
			$history->logedits()->where('history_id', $id)->delete();
			$history->delete();
			return Redirect::action('AdminGameController@index')->with('message', 'Xoá lịch sử thành công');
		}
		return Redirect::action('AdminGameController@index')->with('message', 'Đã xóa');
	}

	// Delete all game selected
	public function deleteSelected()
	{
		$gamesId = Input::get('game_id');
		foreach($gamesId as $key => $value) {
			$data = Game::find($value);
			if($data) {
				$history_id = CommonLog::updateHistory('Game', $value);
				CommonLog::insertLogEdit('Game', $value, $history_id, REMOVE);
				RelationBox::deleteRelationship($data, 'types');
				RelationBox::deleteRelationship($data, 'categoryparents');
				CommonNormal::delete($value);
			}
		}
		dd(1);
	}

	// Edit weight number and status game index page
	public function updateIndexData()
	{
		$gamesId = Input::get('game_id');
		$weightNumber = Input::get('weight_number');
		$statusGame = Input::get('statusGame');
		$count_play = Input::get('count_play');
		foreach($gamesId as $key => $value) {
			$input = array(
				'weight_number' => $weightNumber[$key],
				'status' => $statusGame[$key],
				'count_play' => $count_play[$key]
				);
			CommonNormal::update($value, $input);
		}
		dd(1);
	}

	public function statisticGame(){
		$data = Game::where('parent_id', '!=', '')->orderBy('id', 'desc')->paginate(PAGINATE);
		return View::make('admin.game.statistic')->with(compact('data'));
	}

	public function searchStatisticGame()
	{
		$input = Input::all();
		$data = CommonGame::searchAdminGame($input);
		return View::make('admin.game.statistic')->with(compact('data'));
	}

	public function createHtmlPageGame($game)
	{
		// CREATE HTMLPAGE
		$viewPath = app_path().'/views/site/htmlpage';
		if(in_array($game->parent_id, [GAMEFLASH, GAMEHTML5])) {
			// game play
	    	$html = View::make('site.game.onlinemobile_cronjob')->with(compact('game'))->render();
	    	$filePath = $viewPath.'/'.'game_play_'.$game->slug.'_mobile.blade.php';
	    	file_put_contents($filePath, $html);

	    	$html = View::make('site.game.onlineweb_cronjob')->with(compact('game'))->render();
	    	$filePath = $viewPath.'/'.'game_play_'.$game->slug.'_pc.blade.php';
	    	file_put_contents($filePath, $html);
		} else {
			// game download
	    	$html = View::make('site.game.downloadmobile_cronjob')->with(compact('game'))->render();
	    	$filePath = $viewPath.'/'.'game_download_'.$game->slug.'_mobile.blade.php';
	    	file_put_contents($filePath, $html);

	    	$html = View::make('site.game.downloadweb_cronjob')->with(compact('game'))->render();
	    	$filePath = $viewPath.'/'.'game_download_'.$game->slug.'_pc.blade.php';
	    	file_put_contents($filePath, $html);
		}
		return;
	}


}
