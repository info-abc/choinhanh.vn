<div class="top-right-login">
	<span>{{ show_date_vn() }}</span>
	@if(CommonSite::isLogin())
		<a href="{{ action('AccountController@account') }}" class="account-name">{{ Auth::user()->get()->user_name.Auth::user()->get()->uname.Auth::user()->get()->google_name }}</a>
			<a href="{{ action('SiteController@logout') }}" class="signout">Đăng xuất</a>
	@else
		<a href="{{ action('SiteController@login') }}" class="signin">Đăng nhập</a>
		<a href="{{ action('AccountController@create') }}" class="signup">Đăng ký</a>
	@endif
</div>