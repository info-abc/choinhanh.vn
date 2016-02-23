<?php

class ManagerController extends AdminController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data = Admin::orderBy('id', 'asc')->paginate(PAGINATE);
		return View::make('admin.manager.index')->with(compact('data'));
	}

	public function search()
	{
		$input = Input::all();
		if (!$input['keyword'] && !$input['role_id'] && $input['status'] && $input['start_date'] && $input['end_date']) {
			return Redirect::action('ManagerController@index');
		}
		$data = AdminManager::searchUserOperation($input);
		return View::make('admin.manager.index')->with(compact('data'));
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.manager.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array(
			'username'   => 'required|unique:admins,deleted_at,NULL|unique_delete',
            'password'   => 'required',
            'email'      => 'required|email|unique:admins,deleted_at,NULL|unique_delete',
            'role_id'    => 'required',
		);
		$input = Input::except('_token');
		$validator = Validator::make($input,$rules);
		if($validator->fails()) {
			return Redirect::action('ManagerController@create')
	            ->withErrors($validator)
	            ->withInput(Input::except('password'));
        } else {
        	$input['password'] = Hash::make($input['password']);
        	$input['status'] = ACTIVE;
        	$input += CommonSite::ipDeviceUser() ;
        	$id = CommonNormal::create($input);
        	//create history
			$history_id = CommonLog::insertHistory('Admin', $id);

        	if($id) {
        		return Redirect::action('ManagerController@index');
        	} else {
        		dd('Error');
        	}
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
		$currentUserId = Auth::admin()->get()->id;
		$currentRoleId = Auth::admin()->get()->role_id;
		if($currentRoleId <> ADMIN) {
			if($id <> $currentUserId) {
				dd('error permission');
			}
		}

		$data = Admin::find($id);
        return View::make('admin.manager.edit', array('data'=>$data));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules = array();
		$rules = array(
            'username'   => 'required',
            // 'password'   => 'required',
            'email'      => 'required|email',
            'role_id'    => 'required',
        );
        if (!Admin::isAdmin()) {
        	unset($rules['role_id']);
        }
        $input = Input::except('_token');

		$validator = Validator::make($input,$rules);
		if($validator->fails()) {
			return Redirect::action('ManagerController@edit', $id)
	            ->withErrors($validator)
	            ->withInput(Input::except('password'));
        } else {
        	if($input['password'] != '') {
        		$input['password'] = Hash::make($input['password']);
        	} else {
        		$input['password'] = Auth::admin()->get()->password;
        	}
        	$input += CommonSite::ipDeviceUser() ;
        	CommonNormal::update($id, $input);
        	$currentUserId = Auth::admin()->get()->id;
			$currentRoleId = Auth::admin()->get()->role_id;
			// todo cuongnt
			//update history
			$history_id = CommonLog::updateHistory('Admin', $id);
			CommonLog::insertLogEdit('Admin', $id, $history_id, EDIT);
			//end update history
			if($currentRoleId <> ADMIN) {
				return Redirect::action('ManagerController@edit', $id);
			}
    		return Redirect::action('ManagerController@index');
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
		CommonNormal::delete($id);
        return Redirect::action('ManagerController@index');
	}


	public function history($id)
	{
		$historyId = CommonLog::getIdHistory('Admin', $id);
		if ($historyId) {
			$history = AdminHistory::find($historyId);
			$logEdit = LogEdit::where('history_id', $history->id)->where('action', LOGIN)->get();
			return View::make('admin.manager.history')->with(compact('logEdit'));
		}
		return Redirect::action('ManagerController@index')->with('message', 'Lịch sử admin này đã bị xoá');
		
	}

	public function deleteHistory($id)
	{
		$history = AdminHistory::find($id);
		if ($history) {
			$history->logedits()->where('history_id', $id)->where('action', LOGIN)->delete();
			$history->delete();
			return Redirect::action('ManagerController@index')->with('message', 'Xoá lịch sử thành công');
		}
		return Redirect::action('ManagerController@index');
	}

	public function searchHistory()
	{
		$input = Input::all();
		$logEdit = CommonSearch::searchlogHistory($input);
		return View::make('admin.manager.history')->with(compact('history', 'logEdit'));
	}

	public function changePassword($id){
		$currentUserId = Auth::admin()->get()->id;
		$currentRoleId = Auth::admin()->get()->role_id;
		if($currentRoleId <> ADMIN) {
			if($id <> $currentUserId) {
				dd('error permission');
			}
		}

		$data = Admin::find($id);
        return View::make('admin.manager.changepassword')->with(compact('data'));
	}

	public function updatePassword($id){
		$rules = array(
			'password'   => 'required',
			'repassword' => 'required|same:password'
		);
		$input = Input::except('_token');
		$validator = Validator::make($input,$rules);
		if($validator->fails()) {
			return Redirect::action('ManagerController@changePassword',$id)
	            ->withErrors($validator)
	            ->withInput(Input::except('password'));
        } else {
        		$inputPass['password'] = Hash::make($input['password']);
        		CommonNormal::update($id, $inputPass);
        }
        return Redirect::action('ManagerController@changePassword', $id)->with('message', 'Đổi mật khẩu thành công!');
	}

}
