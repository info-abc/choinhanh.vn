@extends('site.layout.default')

@section('title')
	{{ $title= $tag->name }}
@stop

@section('content')

<div class="box">
	<h1>{{ $tag->name }}</h1>
	<?php
		$games = CommonGame::boxGameByType($type);
		$count = ceil(count($games->get())/PAGINATE_BOXGAME);
	 ?>
	<div class="swiper-container">
		<div class="swiper-wrapper">
			@for($i = 0; $i < $count ; $i ++)
				<div class="swiper-slide boxgame">
					<div class="row">
					<?php
						$listGame = $games->orderBy('count_play', 'desc')->orderBy('start_date', 'desc')->take(PAGINATE_BOXGAME)->skip($i * PAGINATE_BOXGAME)->get();
					?>
						@foreach($listGame as $game)
							@include('site.game.gameitem', array('game' => $game))
						@endforeach
					</div>
				</div>
			@endfor
		</div>
		<div class="swiper-pagination"></div>
		<div class="boxgame-pagination">
			<a class="prev"><i class="fa fa-caret-left"></i> Trang trước</a>
			<div class="boxgame-pagenumber"><span class="numberPage">1</span>/{{ $count }}</div>
			<a class="next">Trang sau <i class="fa fa-caret-right"></i></a>
		</div>
	</div>
</div>

@include('site.game.scriptbox')

@stop