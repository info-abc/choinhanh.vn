<?php 

class PolicyController extends AdminController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$inputpolicy = Policy::orderBy('id', 'desc')->paginate(PAGINATE);
		return View::make('admin.policy.index')->with(compact('inputpolicy'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.policy.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array(
            'title'   => 'required'
        );
		$input = Input::except('_token');
		$validator = Validator::make($input,$rules);
		if($validator->fails()) {
			return Redirect::action('PolicyController@create')
	            ->withErrors($validator);
        } else {
			CommonNormal::create($input);
			return Redirect::action('PolicyController@index');
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
		$inputpolicy = Policy::find($id);
		return View::make('admin.policy.edit')->with(compact('inputpolicy'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules = array(
            'title'   => 'required'
        );
		$input = Input::except('_token');
		$validator = Validator::make($input,$rules);
		if($validator->fails()) {
			return Redirect::action('PolicyController@edit', $id)
	            ->withErrors($validator);
        } else {
			CommonNormal::update($id, $input);
			return Redirect::action('PolicyController@index');
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
		CommonNormal::delete($id);
		return Redirect::action('PolicyController@index');
	}


}
