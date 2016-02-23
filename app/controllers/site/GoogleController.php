<?php

class GoogleController extends BaseController {

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

	public function logingoogle()
    {
        $code = Input::get( 'code' );

        // get google service
        $googleService = GoogleOAuth::consumer();

        // check if code is valid

        // if code is provided get user data and sign in
        if ( !empty( $code ) ) {

            // This was a callback request from google, get the token
            $token = $googleService->requestAccessToken( $code );

            // Send a request with it
            $result = json_decode( $googleService->request( 'https://www.googleapis.com/oauth2/v1/userinfo' ), true );

            // Check to see if user already exists
            if($user = User::where('email', '=', $result['email'])->first())
            {
                Auth::user()->login($user);
                // If user isn't activated redirect them
                if ($user->status == 0)
                {
                    dd('ok');
                }
                $input = CommonSite::ipDeviceUser();
            	$user->update($input);
                return Redirect::action('SiteIndexController@index');
            }
            else
            {
                // Create new user waiting for approval
                $input = CommonSite::inputRegister();
	            $input['email'] = $result['email'];
	            $input['google_id'] = $result['id'];
	            $input['google_name'] = $result['name'];
	        	$userId = User::create($input)->id;
			$user = User::find($userId);
			Auth::user()->login($user);
                return Redirect::action('SiteIndexController@index');
                // return Redirect::back()->withErrors(['Your account have been created. It is awaiting activation by your manager']);
            }


        }
        // if not ask for permission first
        else {
            // get googleService authorization
            $url = $googleService->getAuthorizationUri();
            // return to google login url
            return Redirect::to( (string)$url );
        }

    }

}
