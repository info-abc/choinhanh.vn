<div class="top top-pc">
	<div class="container">
		<div class="row">
			<div class="logo">
				<a href="{{ url('/') }}"><img src="{{ url('/assets/images/logo.png') }}" alt="{{ CHOINHANH_LOGO_ALT }}" /></a>
				@if(Request::segment(1))
					<p>{{ CHOINHANH_INDEX_H1 }}</p>
				@else
					<h1>{{ CHOINHANH_INDEX_H1 }}</h1>
				@endif
			</div>
			<div class="top-image">
				<img src="{{ url('assets/images/game-cuc-hay-choi-me-ngay.jpg') }}" alt="game-cuc-hay-choi-me-ngay" />
			</div>
			<div class="top-right">
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
				<div class="search">
					<!--sharing-->
				    <div class="sharing">
				        <div class="sharing_tab sharing_g">
				            <!-- Place this tag in your head or just before your close body tag. -->
							<script src="https://apis.google.com/js/platform.js" async defer></script>
							<!-- Place this tag where you want the +1 button to render. -->
							<div class="g-plusone" data-size="medium" data-width="50" data-href="https://plus.google.com/113571525283953455277/"></div>
				        </div>
				        <div class="sharing_tab sharing_f">
				            <div class="fb-like" data-href="https://www.facebook.com/Choinhanhvn-563511837144725" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
				        </div>
				        <div id="fb-root"></div>
						<script>(function(d, s, id) {
						  var js, fjs = d.getElementsByTagName(s)[0];
						  if (d.getElementById(id)) return;
						  js = d.createElement(s); js.id = id;
						  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.3";
						  fjs.parentNode.insertBefore(js, fjs);
						}(document, 'script', 'facebook-jssdk'));</script>
						<span>Thích để tham gia cộng đồng Choinhanh</span>
				    </div>
					<form action="{{ action('SearchGameController@index') }}">
						<input type="text" name="search" value="" title="search" placeholder="Tìm kiếm game" />
						<input type="submit" value="search" title="submit" />
					</form>
				</div>
			</div>
	 	</div>
	</div>
</div>