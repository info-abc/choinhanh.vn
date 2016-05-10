<div class="menu-top menu-top-pc">
	<div class="menu-static">
		<ul>
			<li>
				<a href="{{ url('/') }}" {{ checkActive() }}>
					<span>Trang chủ</span>
				</a>
			</li>
			<li>
				<a href="{{ action('GameController@getListGameVote') }}" {{ checkActive('game-binh-chon-nhieu') }}>
					<span>Bình chọn nhiều</span>
				</a>
			</li>
			<li>
				<a href="{{ action('GameController@getListGameplay') }}" {{ checkActive('game-choi-nhieu') }}>
					<span>Hay nhất</span>
				</a>
			</li>
			<!--<li>
				<a href="{{-- action('SiteNewsController@index') --}}" {{-- checkActive('tin-tuc') --}}>
					<span>Tin tức</span>
				</a>
			</li>-->
			<li>
				<a href="{{ action('GameController@getListGameAndroid') }}" {{ checkActive('game-android') }}>
					<span>Game android</span>
				</a>
			</li>
		</ul>
		<div class="clearfix"></div>
	</div>

	<!-- game type has games -->
	<ul class="nav-type">
	@foreach($listTypeGameMenu as $value)
		<li>
			<img src="{{ UPLOADIMG . UPLOAD_GAME_TYPE . '/' . $value->id . '/' . $value->image_url }}" alt="game-{{ $value->slug }}" />
			<a href="{{ url('/game-' . $value->slug) }}" {{ checkActive('game-' . $value->slug) }} >
				{{ ($value->name) }}
			</a>
		</li>
	@endforeach
	</ul>
	<div class="clearfix"></div>

</div>