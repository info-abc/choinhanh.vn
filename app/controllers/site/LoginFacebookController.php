<?php 

class LoginFacebookController extends \BaseController {

	private $fb;
	public function __construct(FacebookHelper $fb){
		$this->fb = $fb;
	}
	/*
	* Login Facebook
	*
	*/
	public function loginfb()
	{
		return Redirect::to($this->fb->getUrlLogin());
	}

	public function callback()
	{
		if(!$this->fb->generateSessionFromRedirect())
			return Redirect::to('/')->with('message', 'Error login facebook');
		$user_fb = $this->fb->getGraph();
		 // dd($user_fb);
		$user = User::where('uid', $user_fb->getProperty('id'))->first();
		if(empty($user))
		{
			$user = new User;
			$user->uid = $user_fb->getProperty('id');
			$user->uname = $user_fb->getProperty('name');
			$user->email = $user_fb->getProperty('email');
			$user->phone = $user_fb->getProperty('phone');
			$user->status =ACTIVE;
			$device = CommonSite::ipDeviceUser();
			$user->ip = $device['ip'];
			$user->device = $device['device'];
			$user->save();
		}
		$user->fb_access_token = $this->fb->getToken();
		$user->save();
		Auth::user()->login($user);
		return Redirect::to('/')->with('message', 'Logged in with Facebook');
	}

}
