<div class="item-play">
	<a href="{{ CommonGame::getUrlGame($game->slug) }}">
	@if($game->parent_id == GAMEOFFLINE)
		<span>{{ getZero($game->count_download) }} lượt tải</span><i class="play">
		<img src="{{ url('/assets/images/tai.png') }}"></i>
	@else
		<span>{{ getZero($game->count_play) }} lượt chơi</span><i class="play">
		<img src="{{ url('/assets/images/play.png') }}"></i>
	@endif
	</a>
</div>