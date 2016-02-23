<?php

class AdminSlideController extends AdminController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$slides = AdminSlide::orderBy('id', 'desc')->paginate(PAGINATE_SLIDE);
		return View::make('admin.slider.index')->with(compact('slides'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.slider.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$input = Input::except('_token', 'image_url');
		$input['type_name'] = SLIDE_TYPE_NAME;
		if($input['config_time'] == '') {
			$input['config_time'] = 1;
		}
		$slideId = AdminSlide::create($input)->id;
		$inputAll = Input::all();
		$listImage = $inputAll['image_url'];
		$this->commonImage($inputAll, $slideId);
		// foreach ($inputAll['image_url'] as $key => $value) {
		// 	if ($value) {
		// 		$path = UPLOAD_IMAGE_SLIDE;
		// 		$destinationPath = public_path().$path.'/'.'image'.$slideId;
		// 		$filename = $value->getClientOriginalName();
		// 		$uploadSuccess   =  $value->move($destinationPath, $filename);
		// 		$adminImage['slider_id'] = $slideId;
		// 		$adminImage['image_url'] = $filename;
		// 		$imageRelateId[] = AdminImage::firstOrCreate($adminImage)->id;
		// 	}
		// }
		return Redirect::action('AdminSlideController@index');
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
		$slide = AdminSlide::find($id);
		return View::make('admin.slider.edit')->with(compact('slide'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::except('_token', '_method');
		if ($input['image_url'][0]) {
			AdminImage::where('slider_id', $id)->delete();
			$this->commonImage($input, $id);
		}
		else{
			$images = $input['image'];
			if ($images) {
				foreach ($images as $key => $image) {
					if ($images[$key]) {
						$path = UPLOAD_IMAGE_SLIDE;
						$destinationPath = public_path().$path.'/image' . '/' . $id;
						$filename = $image->getClientOriginalName();
						$uploadSuccess   =  $image->move($destinationPath, $filename);
						AdminImage::find($key)->update(['image_url' => $filename]);
					}
				}
			}
			
		}
		AdminSlide::find($id)->update(Input::except('_token', '_method', 'image_url', 'image'));
		return Redirect::action('AdminSlideController@index');
	}

	public function commonImage($inputAll, $slideId)
	{
		foreach ($inputAll['image_url'] as $key => $value) {
			if ($value) {
				$path = UPLOAD_IMAGE_SLIDE;
				$destinationPath = public_path().$path.'/image' . '/' . $slideId;
				$filename = $value->getClientOriginalName();
				$uploadSuccess   =  $value->move($destinationPath, $filename);
				$adminImage['slider_id'] = $slideId;
				$adminImage['image_url'] = $filename;
				$imageRelateId[] = AdminImage::create($adminImage)->id;
			}
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
		AdminSlide::find($id)->delete();
		return Redirect::action('AdminSlideController@index');
	}

	public function deleteSlide($id)
	{
		AdminImage::find($id)->delete();
	}

	public function search()
	{
		$input = Input::all();
		if (!$input['keyword']) {
			return Redirect::action('AdminSlideController@index');
		}
		$slides = AdminSlide::where('name', 'like', '%'.$input['keyword'].'%')->paginate(PAGINATE_SLIDE);
		// dd($input);
		return View::make('admin.slider.index')->with(compact('slides'));
	}

}
