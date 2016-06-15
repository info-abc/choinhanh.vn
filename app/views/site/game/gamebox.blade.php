<div class="boxgame-slide boxgame">
	<div class="row">
		@if($listGame)
			@foreach($listGame as $game)
				@include('site.game.gameitem', array('game' => $game, 'slug' => null))
			@endforeach
		@endif
	</div>
</div>