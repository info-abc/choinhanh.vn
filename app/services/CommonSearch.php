<?php
class CommonSearch
{
	//seach comment
	public static function searchComment($input)
	{
		$data = Comment::where(function ($query) use ($input)
		{
			if($input['user_name'] != '') {
				$listUser = User::where('user_name', 'like', '%'.$input['user_name'].'%')->lists('id');
				$query = $query->whereIn('user_id', $listUser);
			}
			if ($input['game_name'] != '') {

				$listGame = Game::where('name', 'like', '%'.$input['game_name'].'%')->lists('id');
				$query = $query->whereIn('model_id', $listGame);
			}
			if ($input['status'] != '') {
				$query = $query->where('status', $input['status']);
			}
			if($input['start_date'] != ''){
				$query = $query->where('created_at', '>=', $input['start_date']);
			}
			if($input['end_date'] != ''){
				$query = $query->where('created_at', '<=', $input['end_date'].' 23:59:59');
			}
		})->orderBy('id', 'desc')->paginate(PAGINATE);
		return $data;
	}

	//search score
	public static function searchScore($input)
	{
		$orderBy = self::searchScoreSortBy($input);
		$data = Score::where(function ($query) use ($input)
		{
			if($input['user_name'] != '') {
				$listUser = User::where('user_name', 'like', '%'.$input['user_name'].'%')->lists('id');
				$query = $query->whereIn('user_id', $listUser);
			}
			if ($input['game_name'] != '') {
				$listGame = Game::where('name', 'like', '%'.$input['game_name'].'%')->lists('id');
				$query = $query->whereIn('game_id', $listGame);
			}
			if($input['status'] != '')
				$query = $query->where('status', $input['status']);
			if($input['start_date'] != ''){
				$query = $query->where('created_at', '>=', $input['start_date']);
			}
			if($input['end_date'] != ''){
				$query = $query->where('created_at', '<=', $input['end_date'].' 23:59:59');
			}
		})->orderBy($orderBy[0], $orderBy[1])
		->paginate(PAGINATE);
		return $data;
	}
	public static function searchScoreSortBy($input){
		$sortBy = 'id';
		$sort = 'desc';
		if($input['sortByScore'] != '') {
			if($input['sortByScore'] == 'score_asc') {
				$sortBy = 'score';
				$sort = 'asc';
			}
			if($input['sortByScore'] == 'score_desc') {
				$sortBy = 'score';
				$sort = 'desc';
			}
		// dd(123);
		return [$sortBy, $sort];
		}
		return [$sortBy, $sort];
	}

	//feedback search
	public static function seachFeedback($input){
		$data = Feedback::where(function ($query) use ($input)
		{
			if($input['name'] != '') {
				$query = $query->where('name','like' ,'%'.$input['name'].'%');
			}
			if ($input['email'] != '') {
				$query = $query->where('email','like' ,'%'.$input['email'].'%');
			}
			if ($input['title'] != '') {
				$query = $query->where('title','like' ,'%'.$input['title'].'%');
			}
			if ($input['status'] != '') {
				$query = $query->where('status', $input['status']);
			}
			if($input['start_date'] != ''){
				$query = $query->where('created_at', '>=', $input['start_date']);
			}
			if($input['end_date'] != ''){
				$query = $query->where('created_at', '<=', $input['end_date'].' 23:59:59');
			}
		})->orderBy('id', 'desc')->paginate(PAGINATE);
		return $data;
	}

	//feedback game search
	public static function seachFeedbackGame($input){
		$data = GameErrors::where(function ($query) use ($input)
		{
			if($input['name'] != '') {
				$listGame = Game::where('name', 'like', '%'.$input['name'].'%')->lists('id');
				$query = $query->whereIn('game_id', $listGame);
			}
			if ($input['status'] != '') {
				$query = $query->where('status', $input['status']);
			}
			if($input['start_date'] != ''){
				$query = $query->where('created_at', '>=', $input['start_date']);
			}
			if($input['end_date'] != ''){
				$query = $query->where('created_at', '<=', $input['end_date'].' 23:59:59');
			}
		})->orderBy('id', 'desc')->paginate(PAGINATE);
		return $data;
	}

	//User search
	public static function seachUser($input){
		$data = User::where(function ($query) use ($input)
		{
			if($input['user_name'] != '') {
				$listGame = $query->where('user_name', 'like', '%'.$input['user_name'].'%');
			}

			if($input['start_date'] != ''){
				$query = $query->where('created_at', '>=', $input['start_date']);
			}
			if($input['end_date'] != ''){
				$query = $query->where('created_at', '<=', $input['end_date'].' 23:59:59');
			}
			if($input['from_update_at'] != ''){
				$query = $query->where('updated_at', '>=', $input['from_update_at']);
			}
			if($input['to_update_at'] != ''){
				$query = $query->where('updated_at', '<=', $input['to_update_at']);
			}
		})->orderBy('id', 'desc')->paginate(PAGINATE);
		return $data;
	}
	//fronend search game
	public static function searchGame($input){

		$data = Game::where(function ($query) use ($input)
		{
			if(getDevice() == MOBILE)
			{
				$query = $query->where('parent_id', '!=', GAMEFLASH);
			}
			if($input['search'] != '') {
				// $condition = array( '%'.$input['search'].'%' );
				// $query = $query->whereRaw( 'games.name like ?', $condition);
				$inputSlug = convert_string_vi_to_en($input['search']);
				$inputSlug = strtolower( preg_replace('/[^a-zA-Z0-9]+/i', '-', $inputSlug) );
				$query = $query->where('slug', 'like', '%'.$inputSlug.'%');
							// ->orWhere('name', 'like', '%'.$input['search'].'%');
			}
			$query = $query->where('status', ENABLED);
			$query = $query->whereNull('deleted_at');
			$query = $query->where('start_date', '<=', Carbon\Carbon::now());
			// dd($query->get()->toArray());
			// dd(DB::getQueryLog());
		})
		->whereNotNull('parent_id')->paginate(FRONENDPAGINATE);
		return $data;
	}
	//backend search history
	public static function searchlogHistory($input){
		$data = LogEdit::where(function ($query) use ($input)
		{
				$query = $query->where('editor_name', Auth::admin()->get()->username);
				$query = $query->where('action', LOGIN);
			if($input['start_date'] != '')
				$query = $query->where('updated_at', '>=', convertDateTime($input['start_date']));
			if($input['end_date'] != '')
				$query = $query->where('updated_at', '<=', convertDateTime($input['end_date']));

		})->orderBy('id', 'desc')->get();
		return $data;
	}
	//backend search type game
	public static function searchTypeGame($input){
		$data  = DB::table('types')
					->join('game_types', 'types.id', '=', 'game_types.type_id') 
					->join('games', 'game_types.game_id', '=', 'games.id')
					->whereNull('types.deleted_at')
					->whereNull('game_types.deleted_at')
					->whereNull('games.deleted_at');
				if($input['type_id'])
				{
					$data = $data->where('types.id', $input['type_id']);
				}
				if($input['parent_id'])
				{
					$data = $data->where('games.parent_id', $input['parent_id']);
				}
				$data = $data->select(DB::raw('types.id, types.name, count(*) count_game, 
											SUM(games.count_view) as count_view, SUM(games.count_play) as count_play,
					 						SUM(games.count_download) as count_download'))
					->groupBy('types.name')
					->get();
		return $data;
	}
}
