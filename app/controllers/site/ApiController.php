<?php

class ApiController extends SiteController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// $types = Type::all();
		$typeIdBlack = array(3);
		$types = Type::whereNotIn('id', $typeIdBlack)->get();
		foreach ($types as $key => $type) {
			$data[$key]['type_name'] = $type->name;
			$data[$key]['data_type'] = $this->getGame($type);
		}
		$data = $this->getGameHardCode();
		return Response::json(array('code' => 'ok', 'data' => $data));
	}

	public function getGame($type)
	{
		$now = Carbon\Carbon::now();
		$typeIdBlack = array(3);
		$listGameBlack = $this->blackListGame();
		$listGame = DB::table('games')
			->join('game_types', 'game_types.game_id', '=', 'games.id')
			->join('types', 'types.id', '=', 'game_types.type_id')
			->select('games.name', 'games.link_url', 'games.image_url', 'games.screen')
			->distinct()
			->where('types.id', $type->id)
			->whereNull('games.deleted_at')
			->where('games.status', ENABLED)
			->where('games.parent_id', '=', GAMEHTML5)
			->where('games.start_date', '<=', $now)
			->whereNotIn('types.id', $typeIdBlack)
			->whereNotIn('games.id', $listGameBlack)
			->get();
		$list = $this->commonGame($listGame);
		return $list;
	}

	public function search()
	{
		$input = Input::all();
		$listIdHardCode = $this->getGameIdHardCode();
		$listGameBlack = $this->blackListGame();
		if ($input['keyword'] == '') {
			$listGame = Game::where('parent_id', GAMEHTML5)
				->whereNotIn('id', $listGameBlack)
				//hard code follow bussiness
				->whereIn('id', $listIdHardCode)
				//
				->get();
		}
		else {
			$listGame = Game::where(function ($query) use ($input) {
				if ($input['keyword'] != '') {
					$inputSlug = convert_string_vi_to_en($input['keyword']);
					$inputSlug = strtolower( preg_replace('/[^a-zA-Z0-9]+/i', '-', $inputSlug) );
					$query = $query->where('slug', 'like', '%'.$inputSlug.'%');
				}
			})
			->where('parent_id', GAMEHTML5)
			//hard code follow bussiness
			->whereIn('id', $listIdHardCode)
			//
			->whereNotIn('id', $listGameBlack)
			->get();
		}
		$data = $this->commonGame($listGame);
		return Response::json(array('code' => 'ok', 'data' => $data));

	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function commonGame($listGame)
	{
		$list = array();
		foreach ($listGame as $key => $value) {
			$avatar = url(UPLOAD_GAME_AVATAR. '/' .$value->image_url);
			$list[$key]['game_url'] = url(UPLOAD_GAME. '/' . $value->link_url);
			$list[$key]['game_name'] = $value->name;
			$list[$key]['game_avatar'] = $avatar;
			$list[$key]['game_screen'] = $value->screen;
		}
		return $list;
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function blackListGame()
	{
		return array(84, 79, 76, 81, 24, 80, 68, 21, 74, 71, 69, 70, 28, 220, 209, 37, 26, 83, 86, 85, 46);
	}
	public function getGameHardCode()
	{
		$data = array(
		   [
			'type_name' => 'Bạn gái', 'data_type' => [
			 ['game_url' => 'http://choinhanh.vn/game_native/boi-tinh-yeu/index.html',
			  'game_name' => 'Bói tình yêu',
			  'game_avatar' => 'http://choinhanh.vn/images/game_avatar/boi-tinh-yeu-1449204379.jpg',
			  'game_screen' => 2
			 ],
			 ['game_url' => 'http://choinhanh.vn/game_native/vuon-dau-cua-mia/index.html', 
			  'game_name' => 'Vườn dâu của Mia',
			  'game_avatar' => 'http://choinhanh.vn/images/game_avatar/vuon-dau-cua-mia-1451444834.jpg',
			  'game_screen' => 2
			 ]
			]
		   ],
		   [
			'type_name' => 'Đua xe', 'data_type' => [
			 ['game_url' => 'http://choinhanh.vn/game_native/anh-hung-duong-pho/index.html', 
			  'game_name' => 'Anh hùng đường phố',
			  'game_avatar' => 'http://choinhanh.vn/images/game_avatar/anh-hung-duong-pho-1451445594.jpg',
			  'game_screen' => 1
			 ]
			]
		   ],
		   [
			'type_name' => 'Trí tuệ', 'data_type' => [
			 ['game_url' => 'http://choinhanh.vn/game_native/giai-ma-o-gach/index.html', 
			  'game_name' => 'Giải mã ô gạch',
			  'game_avatar' => 'http://choinhanh.vn/images/game_avatar/giai-ma-o-gach-1451449428.jpg',
			  'game_screen' => 1
			 ],
			 ['game_url' => 'http://choinhanh.vn/game_native/sudoku-cuoi-cung/index.html', 
			  'game_name' => 'Sudoku 2016',
			  'game_avatar' => 'http://choinhanh.vn/images/game_avatar/sudoku-cuoi-cung-1451449060.jpg',
			  'game_screen' => 1
			 ],
			 ['game_url' => 'http://choinhanh.vn/game_native/ten-trom-the-ky/index.html', 
			  'game_name' => 'Tên trộm thế kỷ',
			  'game_avatar' => 'http://choinhanh.vn/images/game_avatar/ten-trom-the-ky-1449202229.jpg',
			  'game_screen' => 2
			 ],
			 ['game_url' => 'http://choinhanh.vn/game_native/tim-duong-giai-cuu/index.html', 
			  'game_name' => 'Giải cứu công chúa',
			  'game_avatar' => 'http://choinhanh.vn/images/game_avatar/tim-duong-giai-cuu-1449204090.jpg',
			  'game_screen' => 1
			 ]
			]
		   ],

		   [
			'type_name' => 'Vui nhộn', 'data_type' => [
			 ['game_url' => 'http://choinhanh.vn/games/ban-ca-an-xu/game.html', 
			  'game_name' => 'Bắn cá ăn xu',
			  'game_avatar' => 'http://choinhanh.vn/images/game_avatar/ban-ca-an-xu-1449201291.jpg',
			  'game_screen' => 2
			 ]
			]
		   ],
		   [
			'type_name' => 'Thể thao', 'data_type' => [
			 ['game_url' => 'http://choinhanh.vn/games/tran-bong-ky-la/game.html', 
			  'game_name' => 'Bóng đá đầu to',
			  'game_avatar' => 'http://choinhanh.vn/images/game_avatar/tran-bong-ky-la-1449203097.jpg',
			  'game_screen' => 2
			 ]
			]
		   ],
		  );
		return $data;
	}

	public function getGameIdHardCode()
	{
		$listId = array(13, 204, 213, 226, 335, 78, 331, 88, 338);
		return $listId;
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


}
