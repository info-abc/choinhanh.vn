@extends('site.layout.default_pc', array('seoMeta' => CommonSite::getMetaSeo('CategoryParent', 9), 'seoImage' => FOLDER_SEO_PARENT . '/' . 9, 'ogUrl' => action('GameController@getListGameplay')))

@section('title')
	@if($title = CommonSite::getMetaSeo('CategoryParent', 9)->title_site)
		{{ $title = $title }}
	@else
		{{ $title = 'Game hay nhất' }}
	@endif
@stop

@section('content')

<div class="box">
	<h1>Game hay nhất</h1>
	<?php
		$games = CommonGame::getListGame('play', 2);
		// $count = ceil(count($games->get())/PAGINATE_BOXGAME);
		$count = 5;
	?>
	<div class="swiper-container">
		<div class="swiper-wrapper">
			@for($i = 0; $i < $count ; $i ++)
				<div class="swiper-slide boxgame">
					<div class="row">
					<?php
						$listGame = $games->orderBy('count_play', 'desc')->take(PAGINATE_BOXGAME)->skip($i * PAGINATE_BOXGAME)->get();
					?>
						@foreach($listGame as $game)
							@include('site.game.gameitem_cronjob', array('game' => $game, 'slug' => null, 'device' => 2))
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

{{-- quang cao --}}
@include('site.common.ads', array('adPosition' => POSITION_PLAYMANY))

<div class="box">
	<h3>Game bình chọn nhiều</h3>
	<?php
		$games = CommonGame::getListGame('play', 2);
		// $count = ceil(count($games->get())/PAGINATE_BOXGAME);
		$count = 5;
	?>
	<div class="swiper-container">
		<div class="swiper-wrapper">
			@for($i = 0; $i < $count ; $i ++)
				<div class="swiper-slide boxgame">
					<div class="row">
					<?php
						$listGame = $games->orderBy('vote_average', 'desc')->take(PAGINATE_BOXGAME)->skip($i * PAGINATE_BOXGAME)->get();
					?>
						@foreach($listGame as $game)
							@include('site.game.gameitem_cronjob', array('game' => $game, 'slug' => null, 'device' => 2))
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
