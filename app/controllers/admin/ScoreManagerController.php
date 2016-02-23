<?php

class ScoreManagerController extends AdminController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$inputScore = Score::orderBy('id', 'desc')->paginate(PAGINATE);
		return View::make('admin.score.index')->with(compact('inputScore'));
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
		$input = Input::except('_token');
		dd($input);
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
        return Redirect::action('ScoreManagerController@index');
	}

	//search data
	public function search()
	{
		$input = Input::all();
		$inputScore = CommonSearch::searchScore($input);
		return View::make('admin.score.index')->with(compact('inputScore'));
	}

	public function updateScore(){

		$scoreID = Input::get('id');
		$statusScore = Input::get('status');
		foreach($scoreID as $key => $value) {
			$input = array(
				'status' => $statusScore[$key],
				);
			CommonNormal::update($value, $input);
		}
		dd(1);
	}
}
