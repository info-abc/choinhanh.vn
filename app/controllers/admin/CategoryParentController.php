<?php

class CategoryParentController extends AdminController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$categoryParents = CategoryParent::where('position', MENU)->orderBy('created_at',  'desc')->paginate(PAGINATE);
		return View::make('admin.category_parent.index')->with(compact('categoryParents'));
	}
	public function contentIndex()
	{
		$categoryParents = CategoryParent::where('position', CONTENT)->orderBy('created_at',  'desc')->paginate(PAGINATE);
		return View::make('admin.category_parent.index')->with(compact('categoryParents'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.category_parent.create');
	}

	public function contentCreate()
	{

		return View::make('admin.category_parent.create');
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
			return Redirect::action('CategoryParentController@create')
	            ->withErrors($validator)
	            ->withInput(Input::except('password'));
        } else {
			$inputCategory = Input::only('name', 'position', 'weight_number', 'arrange', 'status', 'status_child');
			$id = CommonNormal::create($inputCategory);
			CommonSeo::createSeo('CategoryParent', $id, FOLDER_SEO_PARENT);
			if ($input['position'] != CONTENT) {
				AdminManager::createParentType(Input::get('type_id'),Input::get('weight_number_gametype'),$id, 'ParentType');
				return Redirect::action('CategoryParentController@index') ;
			}else{
				//insert data to game category parent
				$game_category_parent['category_parent_id']= $id;
				$game_category_parent['game_id']= Input::get('game_id');				
				CommonNormal::create($game_category_parent,'GameRelation');

				// CREATE HTMLPAGE
				$this->createHtmlPage($id);
			}
			return Redirect::action('CategoryParentController@contentIndex') ;
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
		$inputCategory = CategoryParent::find($id);
		$inputSeo = AdminSeo::where('model_id', $id)->where('model_name', 'CategoryParent')->first();
		return View::make('admin.category_parent.edit')->with(compact('inputCategory', 'inputSeo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function contentedit($id)
	{

		$inputCategory = CategoryParent::find($id);
		$inputSeo = AdminSeo::where('model_id', $id)->where('model_name', 'CategoryParent')->first();
		$inputgame_category_parent = GameRelation::where('category_parent_id', $id)->first();
		return View::make('admin.category_parent.edit')->with(compact('inputCategory', 'inputSeo','inputgame_category_parent'));
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
			return Redirect::action('CategoryController@edit',$id)
	            ->withErrors($validator)
	            ->withInput(Input::except('name'));
        }
        if(!Admin::isSeo())
        {
			$inputCategory = Input::only('name', 'position', 'weight_number', 'arrange', 'status', 'status_child');
			CommonNormal::update($id,$inputCategory);
		}
		CommonSeo::updateSeo('CategoryParent', $id, FOLDER_SEO_PARENT);
		if ($input['position'] != CONTENT) {
			AdminManager::updateParentType(Input::get('type_id'),Input::get('weight_number_gametype'), $id, 'ParentType');
			return Redirect::action('CategoryParentController@index') ;
		}else{
				//insert data to game category parent
				$game_category_parent['category_parent_id']= $id;
				$game_category_parent['game_id']= Input::get('game_id');				
				GameRelation::where('category_parent_id', $id)->update($game_category_parent);

				// CREATE HTMLPAGE
				$this->createHtmlPage($id);
			}
		return Redirect::action('CategoryParentController@contentIndex') ;
		
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$dataParent = CategoryParent::find($id)->first();
		
		if($dataParent->position !=  CONTENT)
		{
			$countgame =  countBoxGame($id);
			if(!$countgame)
			{
				CommonNormal::delete($id);
				return Redirect::action('CategoryParentController@contentIndex');
			}
			return Redirect::action('CategoryParentController@contentIndex')->with('message', 'Chuyên mục này tồn tại game không xóa được!');
		}
		CommonNormal::delete($id);
		if($dataParent->position ==  CONTENT)
		{
			dd(991);
			return Redirect::action('CategoryParentController@index');
		} 
       
	}

	public function createHtmlPage($id)
	{
		// CREATE HTMLPAGE
		$viewPath = app_path().'/views/site/htmlpage';
		switch($id) {
			case GAME_NEW:
				$viewMobile = 'site.game.gamenew_mobile';
				$fileMobile = 'page_gamenew_mobile.blade.php';
				$viewPc = 'site.game.gamenew_pc';
				$filePc = 'page_gamenew_pc.blade.php';
				break;
			case GAME_ANDROID:
				$viewMobile = 'site.game.showlistandroid_mobile';
				$fileMobile = 'page_showlistandroid_mobile.blade.php';
				$viewPc = 'site.game.showlistandroid_pc';
				$filePc = 'page_showlistandroid_pc.blade.php';
				break;
			case GAME_PLAY_MANY:
				$viewMobile = 'site.game.gameplaymany_mobile';
				$fileMobile = 'page_gameplaymany_mobile.blade.php';
				$viewPc = 'site.game.gameplaymany_pc';
				$filePc = 'page_gameplaymany_pc.blade.php';
				break;
			default:
				$categoryParent = CategoryParent::find($id);
				$html = View::make('site.game.category_mobile')->with(compact('categoryParent'))->render();
		    	$filePath = $viewPath.'/'.'categoryParent_'.$categoryParent->slug.'_mobile.blade.php';
		    	file_put_contents($filePath, $html);
		    	$html = View::make('site.game.category_pc')->with(compact('categoryParent'))->render();
		    	$filePath = $viewPath.'/'.'categoryParent_'.$categoryParent->slug.'_pc.blade.php';
		    	file_put_contents($filePath, $html);
		    	return;
				break;
		}
    	$html = View::make($viewMobile)->render();
    	$filePath = $viewPath.'/'.$fileMobile;
    	file_put_contents($filePath, $html);
    	$html = View::make($viewPc)->render();
    	$filePath = $viewPath.'/'.$filePc;
    	file_put_contents($filePath, $html);
    	return;
	}

}
