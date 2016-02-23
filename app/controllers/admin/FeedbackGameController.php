<?php 

class FeedbackGameController extends AdminController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$inputFeedbackGame = GameErrors::where('status', INACTIVE)->orderBy('id', 'desc')->paginate(PAGINATE);
		return View::make('admin.feedback_game.index')->with(compact('inputFeedbackGame'));
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
		$status_feedback_game = GameErrors::find($id);
		if($status_feedback_game->status == ACTIVE)
		{
			$input['status'] = INACTIVE;
			CommonNormal::update($id, ['status' => $input['status']]);
		}else{
			$input['status'] = ACTIVE;
			CommonNormal::update($id, ['status' => $input['status']]);
		}

		return Redirect::action('FeedbackGameController@index') ;
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
		CommonNormal::delete($id);
        return Redirect::action('FeedbackGameController@index');
	}

	/**
	 * Seach Feedback game.
	 *
	 * @param  
	 * @return Response
	 */
	public function search(){
		$input = Input::all();
		$inputFeedbackGame = CommonSearch::seachFeedbackGame($input);
		return View::make('admin.feedback_game.index')->with(compact('inputFeedbackGame'));
	}
	// Edit weight number and status Comment index page
	public function updateIndexData()
	{
		$input = array();
		$commentId = Input::get('feedback_game_id');
		foreach($commentId as $key => $value) {
			$input['status'] = ACTIVE;
			CommonNormal::update($value, $input);
		}
		dd(1);
	}
	public function updateInActive()
	{
		$input = array();
		$commentId = Input::get('feedback_game_id');
		foreach($commentId as $key => $value) {
			$input['status'] = INACTIVE;
			CommonNormal::update($value, $input);
		}
		dd(1);
	}

}
