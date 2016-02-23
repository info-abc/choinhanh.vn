<?php 

class SiteCommentController extends SiteController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$input = Input::except('_token');
		$input['user_id'] = Auth::user()->get()->id;
		

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
		$game = Game::find($id);
		$input = Input::except('_token');
		if($input['description']) {
			$input['user_id'] = Auth::user()->get()->id;
			$input['model_name'] = 'Game';
			$input['model_id'] = $id;
			$input['status'] = INACTIVE;
			CommonNormal::create($input,'comment');
			return  Redirect::to(CommonGame::getUrlGame($game))->with('comment', COMMENT_MESSAGE);
		}
		return  Redirect::to(CommonGame::getUrlGame($game))->with('comment', COMMENT_NO_MESSAGE);
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
