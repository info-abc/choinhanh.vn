<?php
class CategoryController extends AdminController {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$categories = Game::where('parent_id', NULL)->orderBy('created_at',  'desc')->paginate(PAGINATE);
		return View::make('admin.category.index')->with(compact('categories'));
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$listCategory_patent = CategoryParent::lists('name', 'id');
		return View::make('admin.category.create')->with(compact('listCategory_patent'));
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
			return Redirect::action('CategoryController@create')
	            ->withErrors($validator)
	            ->withInput(Input::except('password'));
        } else {
			$inputCategory = Input::only('name');
			$input['game_id'] = CommonNormal::create($inputCategory);
			// if (Input::get('category_parent_id')) {
			// 	foreach (Input::get('category_parent_id') as $value) {
			// 		$input['category_parent_id'] = $value;
			// 		CommonNormal::create($input, 'GameRelation');
			// 	}
			// }
			return Redirect::action('CategoryController@index') ;
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

	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$game = Game::find($id);
		return View::make('admin.category.edit')->with(compact('game'));
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
	            ->withInput(Input::except('password'));
        } else {
        	//update gamerelation
        	// $listId = GameRelation::where('game_id', $id)->lists('id');
			// foreach ($listId as $gameRelationId){
			// 	GameRelation::destroy($gameRelationId);
			// }
			// $listParentId = Input::get('category_parent_id');
			// if (Input::get('category_parent_id')){
			// 	foreach ($listParentId as $parentId) {
			// 		$updateGameRelation['game_id'] = $id;
			// 		$updateGameRelation['category_parent_id'] = $parentId;
			// 		GameRelation::create($updateGameRelation);
			// 	}
			// }
        	//update game
			$inputCategory['name'] = $input['name'];
			Game::find($id)->update($inputCategory);
        }
        return Redirect::action('CategoryController@index');
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
        return Redirect::action('CategoryController@index');
	}
}