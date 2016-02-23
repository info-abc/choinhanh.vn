<?php

class UserController extends AdminController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$inputUser = User::orderBy('id', 'desc')->paginate(PAGINATE);
		return View::make('admin.user.index')->with(compact('inputUser'));
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
		$statusUser = User::find($id);
	
		if($statusUser->status == ACTIVE)
		{
			$input['status'] = INACTIVE;
			CommonNormal::update($id, ['status' => $input['status']]);
		}else{
			$input['status'] = ACTIVE;
			CommonNormal::update($id, ['status' => $input['status']]);
		}

		return Redirect::action('UserController@index') ;
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
			'password'   => 'required',
			'repassword' => 'required|same:password'

		);
		$input = Input::except('_token');
		$validator = Validator::make($input,$rules);
		if($validator->fails()) {
			return Redirect::action('UserController@changePassword',$id)
	            ->withErrors($validator)
	            ->withInput(Input::except('password'));
        } else {
        	// dd(Hash::make($input['password']));
        		$inputPass['password'] = Hash::make($input['password']);
        		CommonNormal::update($id, $inputPass);
        	
        	
        }
        return Redirect::action('UserController@index') ;
		
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
		return Redirect::action('UserController@index');
	}

	//search data
	public function search()
	{
		$input = Input::all();
		$inputUser = CommonSearch::seachUser($input);
		
		return View::make('admin.user.index')->with(compact('inputUser'));
	}

	//change password
	public function changePassword($id)
	{
		$inputUser = User::find($id);
		return View::make('admin.user.changepassword')->with(compact('inputUser'));
	}

}
