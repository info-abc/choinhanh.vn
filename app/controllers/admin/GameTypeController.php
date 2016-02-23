<?php

class GameTypeController extends AdminController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// $input['type_id'] =null;
		// $input['parent_id'] =null;
		$input['type_id'] = '';
		$input['parent_id'] = '';
		$data = CommonSearch::searchTypeGame($input);
		return View::make('admin.gametype.index')->with(compact('data'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.gametype.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array(
			'name' => 'required',
		);
		$input = Input::except('_token');
		$validator = Validator::make($input,$rules);
		if($validator->fails()) {
			return Redirect::action('GameTypeController@create')
	            ->withErrors($validator);
        } else {
			$id = CommonNormal::create($input);

			CommonSeo::createSeo('Type', $id, FOLDER_SEO_GAMETYPE);

			return Redirect::action('GameTypeController@index') ;
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
		$inputType = Type::find($id);
		$inputSeo = AdminSeo::where('model_id', $id)->where('model_name', 'Type')->first();
		return View::make('admin.gametype.edit')->with(compact('inputType', 'inputSeo'));
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
	            'name'   => 'required'
	        );
        } else {
        	$rules = array();
        }
        $input = Input::except('_token');
		$validator = Validator::make($input,$rules);
		if($validator->fails()) {
			return Redirect::action('GameTypeController@edit', $id)
	            ->withErrors($validator);
        } else {

        	//SEO cant update
        	if(!Admin::isSeo()) {
				$inputCategory = Input::only('name');
				CommonNormal::update($id,$inputCategory);
			}

			CommonSeo::updateSeo('Type', $id, FOLDER_SEO_GAMETYPE);

			return Redirect::action('GameTypeController@index') ;
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
		$count = Type::find($id)->gametypes()->count();
		if($count > 0)
		{
			return Redirect::action('GameTypeController@index')->with('message', 'Thể loại này tồn tại game không xóa được!');
		}
		$parent = Type::find($id->games()->detach());				
		CommonNormal::delete($id);	
        return Redirect::action('GameTypeController@index');
	}

	/**
	* Search type game
	*
	*
	*/
	public function search()
	{
		$input  = Input::except('_token');
		$data = CommonSearch::searchTypeGame($input);
		return View::make('admin.gametype.index')->with(compact('data'));
	}

}
