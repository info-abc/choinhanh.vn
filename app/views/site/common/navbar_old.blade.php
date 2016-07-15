<div class="menu-top">
<div class="container">
		<div class="row">
			<div class="menu-static">
				<ul>
					<li><a href="{{ url('/') }}" {{ checkActive() }}><i class="fa fa-home"></i><span>Home</span></a></li>
					@if(getDevice() == COMPUTER)
						<li><a href="{{ action('GameController@getListGameVote') }}" {{ checkActive('game-binh-chon-nhieu') }}><i class="fa fa-star"></i><span>Bình chọn nhiều</br></span></a></li>
					@else
						<li><a href="{{ action('GameController@getListGameVote') }}" {{ checkActive('game-binh-chon-nhieu') }}><i class="fa fa-star"></i><span>Vote nhiều</br></span></a></li>
					@endif
						<li><a href="{{ action('GameController@getListGameplay') }}" {{ checkActive('game-choi-nhieu') }}><i class="fa fa-gamepad"></i><span>Hay nhất</span></a></li>
						<li><a href="{{ action('SiteNewsController@index') }}" {{ checkActive('tin-tuc') }}><i class="fa fa-newspaper-o"></i><span>Tin tức</span></a></li>
					@if(getDevice() == COMPUTER)
						<li><a href="{{ action('GameController@getListGameAndroid') }}" {{ checkActive('game-android') }}><i class="fa fa-android"></i><span>Game android</span></a></li>
					@else
						<li><a href="{{ action('GameController@getListGameAndroid') }}" {{ checkActive('game-android') }}><i class="fa fa-android"></i><span>Android</span></a></li>
					@endif
				</ul>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>