<?php $url = CommonGame::getUrlGame($game); ?>
<div class="col-xs-4 col-sm-3 col-md-2">
	<div class="item">
	    <div class="item-image">
			<a href="{{ $url }}">
				<img src="{{ url(UPLOAD_GAME_AVATAR . '/' .  $game->image_url) }}" alt="{{ $game->name }}" />
			</a>
			
	    </div>
	    <div class="item-title">
			<a href="{{ $url }}">{{ limit_text($game->name, TEXTLENGH) }}</a>
		</div>
	    {{-- @include('site.game.item-play', array('game' => $game)) --}}
	</div>
</div>