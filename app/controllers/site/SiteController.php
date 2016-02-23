<?php

class SiteController extends HomeController {

	public function __construct() {

		if (Cache::has('menu'))
        {
            $menu = Cache::get('menu');
        } else {
        	$menu = CategoryParent::where('status', ACTIVE)->where('position', CONTENT)->orderBy('weight_number', 'asc')->get();
            Cache::put('menu', $menu, CACHETIME);
        }
        $menuHeader = CategoryParent::where('status', ACTIVE)->where('position', MENU)->orderBy('weight_number', 'asc')->get();
		if (Cache::has('script'.SEO_SCRIPT))
        {
            $script = Cache::get('script'.SEO_SCRIPT);
        } else {
        	$script = AdminSeo::where('model_name', SEO_SCRIPT)->first();
            Cache::put('script'.SEO_SCRIPT, $script, CACHETIME);
        }
		if($script) {
			View::share('script', $script);
		}
		View::share('menu', $menu);
		View::share('menuHeader', $menuHeader);
	}

	public function returnPage404()
	{
		return View::make('404');
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
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

	public function login()
    {
    	$checkLogin = CommonSite::isLogin();
        if($checkLogin) {
    		return Redirect::action('SiteIndexController@index');
        } else {
            return View::make('site.user.login');
        }
    }

    public function doLogin()
    {
        $rules = array(
            'user_name'   => 'required',
            'password'   => 'required',
        );
        $input = Input::except('_token');
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return Redirect::action('SiteController@login')
                // ->withErrors($validator);
            	->with('error', 'Sai tên truy cập hoặc mật khẩu');
        } else {
            if(Auth::user()->attempt($input)) {
            	if(Auth::user()->get()->status == INACTIVE) {
            		dd('Tài khoản của bạn đã bị khóa');
            	}
            	$inputUser = CommonSite::ipDeviceUser();
            	CommonNormal::update(Auth::user()->get()->id, $inputUser, 'User');
        		return Redirect::action('SiteIndexController@index');
            }
            else {
                return Redirect::route('login')->with('error', 'Sai tên truy cập hoặc mật khẩu');
            }
        }
    }

    public function logout()
    {
    	$checkLogin = CommonSite::isLogin();
        if($checkLogin) {
        	Auth::user()->logout();
	        //Session::flush();
	        return Redirect::route('login');
        } else {
            return Redirect::action('SiteIndexController@index');
        }
    }

}
