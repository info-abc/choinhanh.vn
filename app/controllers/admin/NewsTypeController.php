<?php 

class NewsTypeController extends AdminController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$inputNewType = TypeNew::orderBy('id', 'asc')->paginate(PAGINATE);

		return View::make('admin.typenew.index')->with(compact('inputNewType'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.typenew.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array(
			'name'   => 'required'            
		);
		$input = Input::except('_token');
		$validator = Validator::make($input,$rules);
		if($validator->fails()) {
			return Redirect::action('NewstypeController@create')
	            ->withErrors($validator)
	            ->withInput(Input::except('name'));
        } else {
        	$inputNameTypeNew = Input::only('name');
			CommonNormal::create($inputNameTypeNew);
			return Redirect::action('NewsTypeController@index');
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
		$inputTypeNew = TypeNew::find($id);
		return View::make('admin.typenew.edit')->with(compact('inputTypeNew'));
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
            'name'   => 'required'
        );
        $input = Input::except('_token');
		$validator = Validator::make($input,$rules);
		if($validator->fails()) {
			return Redirect::action('NewsTypeController@edit', $id)
	            ->withErrors($validator);
        } else {
        	$inputNameTypeNew = Input::only('name');
        	CommonNormal::update($id,$inputNameTypeNew);
			return Redirect::action('NewsTypeController@index');
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
		return Redirect::action('NewsTypeController@index');
	}


}
