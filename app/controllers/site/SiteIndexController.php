<?php

class SiteIndexController extends SiteController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//return View::make('maintance');
		if(getDevice() == MOBILE) {
			return View::make('site.htmlpage.index_mobile');
		} else {
			return View::make('site.htmlpage.index_pc');
		}
		// $device = null;
		// return View::make('site.index')->with(compact('device'));
	}

	public function hometest()
	{
		if(getDevice() == MOBILE) {
			// $path = public_path().FOLDER_HTML_CODE.'/index_mobile.php';
	  //   	$text = file_get_contents($path);
			return View::make('site.htmlpage.index_mobile');
		} else {
			// $path = public_path().FOLDER_HTML_CODE.'/index_pc.php';
	  //   	$text = file_get_contents($path);
			return View::make('site.htmlpage.index_pc');
		}
		// return $text;
	}

	public function home()
	{
		return View::make('site.index');
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


}
