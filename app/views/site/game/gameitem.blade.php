<?php $url = CommonGame::getUrlGame($game, $slug); ?>
<div class="col-xs-4 col-sm-3 col-md-2">
	<div class="item">
	    <div class="item-image">
			<a href="{{ $url }}">
				<img src="{{ url(UPLOAD_GAME_AVATAR . '/' .  $game->image_url) }}" alt="{{ $game->slug }}" class="showTip el_{{ $game->id }}" />
			</a>
	    </div>
	    <div class="item-title">
			<h2><a href="{{ $url }}">{{ limit_text($game->name, TEXTLENGH) }}</a></h2>
		</div>
	    {{-- @include('site.game.item-play', array('game' => $game)) --}}
	</div>
	@if(getDevice($device) == COMPUTER)
		@include('site.game.tooltip', array('game' => $game, 'url' => $url))
	@endif
</div>