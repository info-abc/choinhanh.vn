<?php 

class CommentController extends AdminController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$inputComment =  Comment::where('status', INACTIVE)->orderBy('id', 'desc')->paginate(PAGINATE);
		return View::make('admin.comment.index')->with(compact('inputComment'));

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
		$statusComment = Comment::find($id);
	
		if($statusComment->status == ACTIVE)
		{
			$input['status'] = INACTIVE;
			CommonNormal::update($id, ['status' => $input['status']]);
		}else{
			$input['status'] = ACTIVE;
			CommonNormal::update($id, ['status' => $input['status']]);
		}

		return Redirect::action('CommentController@index') ;
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		
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
        return Redirect::action('CommentController@index');
	}

	// Delete all Comment selected
	public function deleteSelected()
	{
		$commentId = Input::get('comment_id');
		foreach($commentId as $key => $value) {
			$data = Comment::find($value);
				CommonNormal::delete($value);
		}
		dd(1);
	}

	// Edit weight number and status Comment index page
	public function updateIndexData()
	{
		$input = array();
		$commentId = Input::get('comment_id');
		foreach($commentId as $key => $value) {
			$input['status'] = ACTIVE;
			CommonNormal::update($value, $input);
		}
		dd(1);
	}
	public function updateCommentInactive()
	{
		$input = array();
		$commentId = Input::get('comment_id');
		foreach($commentId as $key => $value) {
			$input['status'] = INACTIVE;
			CommonNormal::update($value, $input);
		}
		dd(1);
	}
	//search data
	public function search()
	{
		$input = Input::all();
		$inputComment = CommonSearch::searchComment($input);
		return View::make('admin.comment.index')->with(compact('inputComment'));
	}

}
