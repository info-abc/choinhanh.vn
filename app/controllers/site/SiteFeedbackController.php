<?php

class SiteFeedbackController extends SiteController {

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
		return View::make('site.feedback.index');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		$input = Input::except('_token');
		// dd($input);
		$rules = array(
			'name'  => 'required',
            'email'      => 'required|email',
            'title'      => 'required',
            'description'    => 'required'
		);
		$validator = Validator::make($input,$rules);
		if($validator->fails()) {
			return Redirect::action('SiteFeedbackController@create')
	            ->withErrors($validator);
        } else {
      		$input['status'] = INACTIVE;
      		$input['ip'] = getIpAddress();
      		$input['device'] = getDevice();
        	$id = CommonNormal::create($input, 'feedback');
        	if($id) {
        		return Redirect::action('SiteFeedbackController@create')->with('message', 'Bạn gửi góp ý thành công!');
        	} else {
        		dd('Error');
        	}

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

	/**
	* Show the form error game the specified resource
	*
	* @param int $id
	* @return Response
	*/
	public function errorGame($id)
	{

		$input_errorGame = Game::find($id);
		return View::make('site.feedback.error_game')->with(compact('input_errorGame'));
	}

	/**
	* ErrorGame a newly created resource in ErrorGame.
	*
	* @param int $id
	* @return Response
	*/
	public function createErrorGame($id)
	{
		$input = Input::except('_token');
		$rules = array(
            'description'    => 'required'
		);
		$validator = Validator::make($input,$rules);
		if($validator->fails()) {
			return Redirect::action('SiteFeedbackController@errorGame', $id)
	            ->withErrors($validator);
        } else {

        	$input['game_id'] = $id;
      		$input['status'] = INACTIVE;
      		$input['ip'] = getIpAddress();
      		$input['device'] = getDevice();
        	$id_errorgame = CommonNormal::create($input, 'feedback_game');
        	if($id_errorgame) {
        		return Redirect::action('SiteFeedbackController@errorGame',$id)->with('message', 'Báo lỗi game thành công!');
        	} else {
        		dd('Error');
        	}

        }

	}

	/**
	* Show the form policy the specified resource
	*
	* @param int $id
	* @return Response
	*/
	public function policy()
	{
		$input_policy = Policy::where('type_policy', POLICY)->get()->first();
		return View::make('site.feedback.policy')->with(compact('input_policy'));
	}

	public function sendErrorGame()
	{
		$input = array();
		$input['description'] = Input::get('description');
		$rules = array(
            'description' => 'required'
		);
		$validator = Validator::make($input,$rules);
		if($validator->fails()) {
			echo 0;
        } else {
        	$input['game_id'] = Input::get('id');
      		$input['status'] = INACTIVE;
      		$input['ip'] = getIpAddress();
      		$input['device'] = getDevice();
        	$id_errorgame = CommonNormal::create($input, 'feedback_game');
        	if($id_errorgame) {
        		echo 1;
        	} else {
        		echo 0;
        	}

        }

	}

}
