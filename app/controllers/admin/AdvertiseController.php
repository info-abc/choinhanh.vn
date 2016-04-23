<?php

class AdvertiseController extends AdminController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$advertise = Advertise::whereIn('position', [HEADER, Footer])
						->get();
		return View::make('admin.adverties.index')->with(compact('advertise'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.adverties.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::except('_token');
		if ($input['ad-select'] == 1) {
			$id = Advertise::create($input)->id;
			$imageUrl = CommonSeo::uploadImage($id, UPLOAD_ADVERTISE, 'image_url', 'header_footer');
			Advertise::find($id)->update(array('image_url' => $imageUrl));
			return Redirect::action('AdvertiseController@index')->with('message', 'tạo mới thành công');
		}
		else {
			$id = Advertise::create($input)->id;
			return Redirect::action('AdvertiseController@index')->with('message', 'tạo mới thành công');
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
		$advertise = Advertise::find($id);
		return View::make('admin.adverties.edit')->with(compact('advertise'));
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
		$advertise = Advertise::find($id);
		if ($input['ad-select'] == 1) {
			$imageUrl = CommonSeo::uploadImage($id, UPLOAD_ADVERTISE, 'image_url', 'header_footer', $advertise->image_url);
			$input['image_url'] = $imageUrl;
			$advertise->update($input);
		}
		else {
			$advertise->update($input);
		}
		// $imageUrl = CommonSeo::uploadImage($id, UPLOAD_ADVERTISE, 'image_url', 'header_footer', $advertise->image_url);
		// $input['image_url'] = $imageUrl;
		// $advertise->update($input);
		return Redirect::action('AdvertiseController@index')->with('message', 'Thay đổi thành công');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Advertise::find($id)->delete();
		return Redirect::action('AdvertiseController@index')->with('message', 'Xoá thành công');
	}

	public function indexChild()
	{
		$advertisePosition = AdvertisePosition::all();
		return View::make('admin.adverties.child_index')->with(compact('advertisePosition'));
	}

	public function createChild()
	{
		return View::make('admin.adverties.child_create');
	}
	public function storeChild()
	{
		$input = Input::except('_token');
		if ($input['ad-select'] == 1) {
			$inputChild['image_url'] = $input['image_url'];
			$inputChild['image_link'] = $input['image_link'];
			$inputChild['is_mobile'] = $input['is_mobile'];
			$inputChild['position'] = CHILD_PAGE;
			$id = Advertise::create($inputChild)->id;
			$commonModelId = CommonModel::create(array('model_name' => 'CategoryParent', 'model_id' => Input::get('model_id')))->id;
			$imageUrl = CommonSeo::uploadImage(Input::get('model_id'), UPLOAD_ADVERTISE, 'image_url', 'content');
			Advertise::find($id)->update(array('image_url' => $imageUrl));
			AdvertisePosition::create(array(
				'common_model_id' => $commonModelId,
				'advertisement_id' => $id,
				'name' => BOTTOM,
				'status' => Input::get('status'),
			));
			return Redirect::action('AdvertiseController@indexChild')->with('message', 'tạo mới thành công');
		}
		else {
			$inputChild['adsense'] = Input::get('adsense');
			$inputChild['position'] = CHILD_PAGE;
			$inputChild['is_mobile'] = $input['is_mobile'];
			$id = Advertise::create($inputChild)->id;
			$commonModelId = CommonModel::create(array('model_name' => 'CategoryParent', 'model_id' => Input::get('model_id')))->id;
			AdvertisePosition::create(array(
				'common_model_id' => $commonModelId,
				'advertisement_id' => $id,
				'name' => BOTTOM,
				'status' => Input::get('status'),
			));
			return Redirect::action('AdvertiseController@indexChild')->with('message', 'tạo mới thành công');
		}

	}
	public function editChild($id, $modelId)
	{
		$advertise =  Advertise::find($id);
		$relate = AdvertisePosition::where('common_model_id', $modelId)->where('advertisement_id', $id)->first();
		return View::make('admin.adverties.child_edit')->with(compact('advertise','modelId', 'relate'));
	}
	public function updateChild($id, $modelId)
	{
		$status = Input::get('status');
		$input = Input::except('_token', '_method', 'status', 'position');
		$advertise = Advertise::find($id);
		// dd($input);
		if ($input['ad-select'] == 1) {
			$imageUrl = CommonSeo::uploadImage(CommonModel::find($modelId)->model_id, UPLOAD_ADVERTISE, 'image_url', 'content', $advertise->image_url);
			$input['image_url'] = $imageUrl;
			$advertise->update($input);
			CommonModel::find($modelId)->update(['model_id' => Input::get('model_id')]);
			AdvertisePosition::where('common_model_id', $modelId)
								->where('advertisement_id', $id)
								->first()
								->update(['status' => $status]);
			return Redirect::action('AdvertiseController@indexChild')->with('message', 'Tạo mới thành công');

		}
		else {
			$input['adsense'] = Input::get('adsense');
			$advertise->update($input);
			CommonModel::find($modelId)->update(['model_id' => Input::get('model_id')]);
			AdvertisePosition::where('common_model_id', $modelId)
								->where('advertisement_id', $id)
								->first()
								->update(['status' => $status]);
			return Redirect::action('AdvertiseController@indexChild')->with('message', 'Tạo mới thành công');
		}

	}

	public function destroyChild($id)
	{
		$adverties = Advertise::find($id);
		$adverties->commonModels()->detach();
		$adverties->delete();
		return Redirect::action('AdvertiseController@indexChild')->with('message', 'Xoá thành công');
	}

}
