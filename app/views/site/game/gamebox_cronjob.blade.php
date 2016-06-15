<?php 
	if(isset($device)) {
		$device = getDevice($device);
	} else {
		$device = getDevice();
	}
?>
<div class="boxgame-slide boxgame">
	<div class="row">
		@if($listGame)
			@foreach($listGame as $game)
				@include('site.game.gameitem_cronjob', array('game' => $game, 'slug' => null, 'device' => $device))
			@endforeach
		@endif
	</div>
</div>