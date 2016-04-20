@if($listGames = CommonGame::getRelated($game))
<div class="box mobile">
	<h3>Game khác</h3>
	<div class="row">
		@if(count($listGames[0]) > 0)
			@foreach($listGames[0] as $value)
				@include('site.game.gameitem', array('game' => $value, 'slug' => null))
			@endforeach
		@endif
		@if($listGames[1] != '')
			@foreach($listGames[1] as $v)
				@include('site.game.gameitem', array('game' => $v, 'slug' => null))
			@endforeach
		@endif
	</div>
</div>
@endif