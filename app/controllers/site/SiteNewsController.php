<?php

class SiteNewsController extends SiteController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$now = date('Y-m-d');
		$inputListNews = AdminNew::where('start_date', '<=', Carbon\Carbon::now())->orderBy('id', 'desc')
		->paginate(FRONENDPAGINATE);
		$typeNew = null;
		return View::make('site.News.listNews')->with(compact('inputListNews', 'typeNew'));
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
	public function show($slug)
	{
		$now = date('Y-m-d');
		$inputNew = AdminNew::findBySlug($slug);
		if(!$inputNew) {
			return CommonLog::logErrors(ERROR_TYPE_404);
		}
		$input['count_view'] = getZero($inputNew->count_view) + 1;
		CommonNormal::update($inputNew->id, $input, 'AdminNew');
		
		// //tin lien quan
		// $inputRelated = AdminNew::where('type_new_id', $inputNew->type_new_id)
		// 	->where('start_date', '<=', $now)
		// 	->where('start_date', '<=', $inputNew->start_date)
		// 	->where('id', '!=', $inputNew->id)
		// 	->orderBy(DB::raw('RAND()'))
		// 	->limit(PAGINATE_RELATED)
		// 	->get();
		// //tin dang doc
		// $inputHot = AdminNew::where('start_date', '<=', $now)
		// 	->where('id', '!=', $inputNew->id)
		// 	->orderBy('start_date', 'desc')
		// 	->limit(PAGINATE_RELATED)
		// 	->get();
		// return View::make('site.News.showNews')->with(compact('inputNew', 'inputRelated', 'inputHot'));

		if(getDevice() == MOBILE) {
			return View::make('site.htmlpage.news_tin-tuc_'.$slug.'_mobile');
		} else {
			return View::make('site.htmlpage.news_tin-tuc_'.$slug.'_pc');
		}
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
