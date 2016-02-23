<?php 

class RelationController extends AdminController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$inputRelation = Relation::orderBy('id', 'asc')->paginate(PAGINATE);	
		return View::make('admin.relation.index')->with(compact('inputRelation'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$arrCategoryParent = CategoryParent::orderBy('id', 'desc')->get();
		$arrCategory = Game::where('parent_id',  null)->get();
		return View::make('admin.relation.create')->with(compact('arrCategoryParent'),compact('arrCategory'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{				

		$inputRelation = Input::except('_token', 'model_name','relation_name');
		$inputRelation['model_name'] = getModelNameRelation('model_name');
		$inputRelation['relation_name'] = getModelNameRelation('relation_name');
		CommonNormal::create($inputRelation);
		return Redirect::action('RelationController@index') ;	
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
		$inputRelation = Relation::find($id);
		return View::make('admin.relation.edit')->with(compact('inputRelation'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//dd(Input::all());
		$inputRelation = Input::except('_token', 'model_name','relation_name');
		$inputRelation['model_name'] = getModelNameRelation('model_name');
		$inputRelation['relation_name'] = getModelNameRelation('relation_name');
		CommonNormal::update($id, $inputRelation);
		return Redirect::action('RelationController@index') ;	
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
        return Redirect::action('RelationController@index');
	}
	public function ajax()
	{
		$type_model = Input::get('category');
		if($type_model == MENU_RELATION)
			$parent = CategoryParent::where('position',MENU_RELATION)->lists('name','id');
		elseif($type_model == CONTENT_RELATION){
			$parent = CategoryParent::where('position',CONTENT_RELATION)->lists('name','id');
		}
		else{
			$parent = Type::lists('name','id');
		}
		return Response::json($parent);
	}
	public function ajaxedit($id)
		{
			$type_model = Input::get('category');
			if($type_model == MENU_RELATION)
				$parent = CategoryParent::where('position', MENU_RELATION)->lists('name','id');
			elseif ($type_model == CONTENT_RELATION) 
				$parent = CategoryParent::where('position',CONTENT_RELATION)->lists('name','id');
			else
				$parent = Type::lists('name','id');
			return Response::json($parent);
		}
}
