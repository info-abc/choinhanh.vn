<?php 

class AdminTagController extends AdminController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data = AdminTag::orderBy('id', 'desc')->paginate(PAGINATE);
		return View::make('admin.tags.index')->with(compact('data'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.tags.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array(
			'name'   => 'required|unique:tags'            
		);
		$input = Input::except('_token');
		$validator = Validator::make($input,$rules);
		if($validator->fails()) {
			return Redirect::action('AdminTagController@create')
	            ->withErrors($validator)
	            ->withInput(Input::except('name'));
        } else {
        	$inputTag = Input::only('name');
        	$inputTag['status'] = ACTIVE;
        	$inputTag['weight_number'] = 0;
			CommonNormal::create($inputTag);
			return Redirect::action('AdminTagController@index');
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
		$inputTag = AdminTag::find($id);
		return View::make('admin.tags.edit')->with(compact('inputTag'));
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
			return Redirect::action('AdminTagController@edit', $id)
	            ->withErrors($validator);
        } else {
        	$inputTag = Input::only('name');
        	CommonNormal::update($id, $inputTag);
			return Redirect::action('AdminTagController@index');
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
		return Redirect::action('AdminTagController@index');
	}


}
