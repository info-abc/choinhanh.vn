<?php
class SocialLogin
{
	public static function checkLoginGoogle()
	{
		// $googleService = GoogleOAuth::consumer();

  //       if(Input::has("code")){
  //           $code = Input::get("code");
  //           $accessToken = $googleService->requestAccessToken($code);
  //           $user = new User;
  //           $user->google_access_token = $accessToken;
  //           $user->save();
  //           dd(123);
  //           return Redirect::route('login');
  //           // return Redirect::to("/dang-nhap");
  //       }
  //       // dd(321);ss
  //       if(!GoogleOAuth::hasAuthorized()){
  //           // die("Not authorized yet");
  //           return Redirect::route('login');
  //       }
  //       $result = json_decode( $googleService->request( 'https://www.googleapis.com/oauth2/v1/userinfo' ), true );
  //       dd($result);
  //       if($user = User::where('google_id', $result['id'])->first()) {
  //           // $input = CommonSite::ipDeviceUser();
  //           // $user->update($input);
  //       	return $user->id;
  //       }
  //       else {
  //           $input = CommonSite::inputRegister();
  //           $input['email'] = $result['email'];
  //           $input['google_id'] = $result['id'];
  //           $input['google_name'] = $result['name'];
  //       	$userId = User::create($input)->id;
  //       	return $userId;
  //       }
  //       return null;
        $code = Input::get( 'code' );

        // get google service
        $googleService = OAuth::consumer( 'Google' );

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
                $user = User::find($user['id']);
                Auth::login($user);
                // If user isn't activated redirect them
                if ($user->status == 0)
                {
                    dd('ok');
                }
                return Redirect::back()->withErrors(['Sorry You have not been approved', 'Speak to your manager']);
            }
            else
            {
                // Create new user waiting for approval
                $new_user = new User();
                $new_user->email = $result['email'];
                $new_user->google_name = $result['name'];
                $new_user->google_id = $result['id'];
                $new_user->status = 1;
                $new_user->google_access_token = $token;
                $new_user->save();
                return Redirect::back()->withErrors(['Your account have been created. It is awaiting activation by your manager']);
            }


        }
        // if not ask for permission first
        else {
            // get googleService authorization
            $url = $googleService->getAuthorizationUri();
            dd($url);
            // return to google login url
            return Redirect::to( (string)$url );
        }

	}

}