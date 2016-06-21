<?php

class SlugController extends SiteController {

	public function listData($slug)
	{
		if($slug == 'tin-tuc') {
			return Redirect::action('SiteNewsController@index');
		}
		$typeNew = TypeNew::findBySlug($slug);
		if($typeNew) {
			return self::listNews($typeNew);
		}
		return CommonLog::logErrors(ERROR_TYPE_404);
	}

	public function detailData($type, $slug)
	{
		$typeNew = TypeNew::findBySlug($type);
		$inputNew = AdminNew::findBySlug($slug);
		if(!$typeNew) {
			return CommonLog::logErrors(ERROR_TYPE_404);
		}
		if($inputNew->type_new_id != $typeNew->id){
            return CommonLog::logErrors(ERROR_TYPE_404);
        }
		if($inputNew) {
			return self::showDetail($typeNew, $inputNew);
		}
		return CommonLog::logErrors(ERROR_TYPE_404);
	}

	public function listNews($typeNew)
	{
		$now = date('Y-m-d');
		$inputListNews = AdminNew::where('start_date', '<=', Carbon\Carbon::now())
			->where('type_new_id', $typeNew->id)
			->orderBy('id', 'desc')
			->paginate(FRONENDPAGINATE);
		return View::make('site.News.listNews')->with(compact('inputListNews', 'typeNew'));
	}

	public function showDetail($typeNew, $inputNew)
	{
		$now = date('Y-m-d');
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
		// return View::make('site.News.showNews')->with(compact('inputNew', 'inputRelated', 'inputHot', 'typeNew'));

		if(getDevice() == MOBILE) {
			return View::make('site.htmlpage.news_'.$typeNew->slug.'_'.$inputNew->slug.'_mobile');
		} else {
			return View::make('site.htmlpage.news_'.$typeNew->slug.'_'.$inputNew->slug.'_pc');
		}

	}

}
