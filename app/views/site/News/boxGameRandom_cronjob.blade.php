<?php 
	if(isset($device)) {
		$device = getDevice($device);
	} else {
		$device = getDevice();
	}
?>
@if($device == COMPUTER)
	<?php 
		$games = CommonGame::getBoxGameRight();
	?>
	<div class="topgame boxgamenews">
		<h3>GAME ĐỀ CỬ</h3>
		<ul>
			@foreach($games as $value)
				<?php $url = CommonGame::getUrlGame($value, null, 1); ?>
				<li>
					<div class="topgame-image">
						<img src="{{ url(UPLOAD_GAME_AVATAR . '/' .  $value->image_url) }}" alt="{{ $value->slug }}" />
					</div>
					<div class="topgame-text">
						<a href="{{ $url }}">{{ limit_text($value->name, TEXTLENGH) }}</a>
						<span>{{ getZero($value->count_play) }} lượt xem</span>
					</div>
					<div class="clearfix"></div>
				</li>
			@endforeach
		</ul>
	</div>
@endif