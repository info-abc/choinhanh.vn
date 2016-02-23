<?php 

class SeoController extends AdminController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$seoScript = AdminSeo::whereNull('model_id')->where('model_name', SEO_SCRIPT)->first();
		$seoMeta = AdminSeo::whereNull('model_id')->where('model_name', SEO_META)->first();
		$inputSeo = AdminSeo::whereNull('model_id')->get();
		return View::make('admin.seo.index')->with(compact('inputSeo', 'seoScript', 'seoMeta'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.seo.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::except('_token');
		if (!$input['header_script'] && !$input['footer_script']) {
			return Redirect::action('SeoController@create')->with('message', 'Phải nhập thông tin header hoặc footer');
		}
		$input['model_name'] = SEO_SCRIPT;
		CommonNormal::create($input);
		return Redirect::action('SeoController@index');
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
		$inputSeo = AdminSeo::find($id);
		return View::make('admin.seo.edit')->with(compact('inputSeo'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::except('_token');
		if (!$input['header_script'] && !$input['footer_script']) {
			return Redirect::action('SeoController@edit',$id)->with('message', 'Phải nhập thông tin header hoặc footer');
		}
		CommonNormal::update($id, $input);
		return Redirect::action('SeoController@index');
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
		return Redirect::action('SeoController@index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function seoMeta()
	{
		return View::make('admin.seo.addseometa');
	}

	/**
	* Add seo meta
	*
	*/
	public function addSeoMeta()
	{
		CommonSeo::createSeo(SEO_META, null , FOLDER_SEO);
		return Redirect::action('SeoController@index');
	}

	/**
	* Show form edit meta
	* @param id
	* @return Response
	*/
	public function editSeoMeta($id)
	{
		$inputSeo = AdminSeo::find($id);
		return View::make('admin.seo.editMeta')->with(compact('inputSeo'));
	}

	/**
	* Edit seo meta
	* @param id
	* @return Response
	*/
	public function doEditSeoMeta($id)
	{
		CommonSeo::updateSeo(SEO_META, null, FOLDER_SEO);
		return Redirect::action('SeoController@index');
	}


}
