<div class="menu-top">
<div class="container">
		<div class="row">
			<div class="menu-static">
				<ul>
					<li><a onclick="menushow()" class="menu_show_list"><i class="fa fa-navicon"></i><span>Danh mục</span></a></li>
					<li><a href="{{ url('/') }}" {{ checkActive() }}><i class="fa fa-home"></i><span>Trang chủ</span></a></li>
					<li><a href="{{ action('GameController@getListGameVote') }}" {{ checkActive('game-binh-chon-nhieu') }}><i class="fa fa-star"></i><span>Vote nhiều</br></span></a></li>
					<li><a href="{{ action('GameController@getListGameplay') }}" {{ checkActive('game-choi-nhieu') }}><i class="fa fa-gamepad"></i><span>Hay nhất</span></a></li>
					<!-- <li><a href="{{-- action('SiteNewsController@index') --}}" {{-- checkActive('tin-tuc') --}}><i class="fa fa-newspaper-o"></i><span>Tin tức</span></a></li> -->
					<li><a href="{{ action('GameController@getListGameAndroid') }}" {{ checkActive('game-android') }}><i class="fa fa-android"></i><span>Android</span></a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>