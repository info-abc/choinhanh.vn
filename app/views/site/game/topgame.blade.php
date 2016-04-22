@if(getDevice() == COMPUTER)
	@include('site.common.ads', array('adPosition' => POSITION_GAMEDETAIL_GAMETOP))
@endif

<div class="topgame">
	<h3><a href="{{ action('GameController@getListGameplay') }}">GAME HAY NHẤT</a></h3>
	<ul>
		@foreach($games as $value)
			<?php $url = CommonGame::getUrlGame($value); ?>
			<li>
				<div class="topgame-image">
					<img src="{{ url(UPLOAD_GAME_AVATAR . '/' .  $value->image_url) }}" alt="{{ $value->slug }}" />
				</div>
				<div class="topgame-text">
					<a href="{{ $url }}">{{ limit_text($value->name, TEXTLENGH) }}</a>
					<span>{{ getZero($value->count_play) }} lượt chơi</span>
				</div>
				<div class="clearfix"></div>
			</li>
		@endforeach
	</ul>
</div>