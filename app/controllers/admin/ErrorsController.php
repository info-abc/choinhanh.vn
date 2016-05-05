<?php

class ErrorsController extends AdminController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data = AdminError::orderBy('count', 'desc')->paginate(PAGINATE);
		return View::make('admin.errorlog.index', array('data' => $data));
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
		AdminErrorLog::where('error_id', $id)->delete();
		AdminError::destroy($id);
		return Redirect::action('ErrorsController@index');
	}

	public function search()
	{
		$input = Input::all();
		$data = CommonLog::searchError($input);
		return View::make('admin.errorlog.index')->with(compact('data'));
	}

	public function deleteErrors()
	{
		$errorId = Input::get('error_id');
		AdminErrorLog::whereIn('id', $errorId)->delete();
		AdminError::whereIn('id', $errorId)->delete();
		return 1;
	}

	public function deleteAllErrors()
	{
		AdminErrorLog::truncate();
		AdminError::truncate();
	}

}
