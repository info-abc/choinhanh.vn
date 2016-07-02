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
			'name'   => 'required|unique:type_news'            
		);
		$input = Input::except('_token');
		$validator = Validator::make($input, $rules);
		if($validator->fails()) {
			return Redirect::action('NewsTypeController@create')
	            ->withErrors($validator);
        } else {
			$id = CommonNormal::create($input);

			// insert seo
			CommonSeo::createSeo('TypeNew', $id, FOLDER_SEO_NEWS_TYPE);

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
		$inputSeo = AdminSeo::where('model_id', $id)->where('model_name', 'TypeNew')->first();
		return View::make('admin.typenew.edit')->with(compact('inputTypeNew', 'inputSeo'));
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
		$validator = Validator::make($input, $rules);
		if($validator->fails()) {
			return Redirect::action('NewsTypeController@edit', $id)
	            ->withErrors($validator);
        } else {
        	CommonNormal::update($id, $input);

        	CommonSeo::updateSeo('TypeNew', $id, FOLDER_SEO_NEWS_TYPE);

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
