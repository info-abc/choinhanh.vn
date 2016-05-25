@if(CommonSite::isLogin() )

<?php
	if($image_url = Auth::user()->get()->image_url) {
		$avatar = url(UPLOADIMG . UPLOAD_USER_AVATAR . '/' . $image_url);
	} else {
		$avatar = url('/assets/images/avatar.jpg');
	}
?>

<div class="menu-account">
      <a href="{{ action('AccountController@account') }}" class="account-name"><img src="{{ $avatar }}" height="32" width="31" /> {{ Auth::user()->get()->user_name.Auth::user()->get()->uname.Auth::user()->get()->google_name }}</a>
      {{-- <a href="#" class="game-favorite"><i class="fa fa-thumbs-o-up"></i> Game bạn yêu thích</a> --}}
      {{-- <a href="#" class="game-played"><i class="fa fa-gamepad"></i> Game bạn đã chơi</a> --}}
      <a href="{{ action('SiteController@logout') }}" class="signout"><i class="fa fa-power-off"></i> Đăng xuất</a>
</div>
@else
<div class="menu-login">
	<a href="{{ action('SiteController@login') }}" class="signin"><i class="fa fa-user"></i> Đăng nhập</a>
	<a href="{{ action('AccountController@create') }}" class="signup"><i class="fa fa-user-plus"></i> Đăng ký</a>
</div>
@endif