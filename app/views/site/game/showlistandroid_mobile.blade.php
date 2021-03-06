@extends('site.layout.default_mobile', array('seoMeta' => CommonSite::getMetaSeo('CategoryParent', GAME_ANDROID), 'seoImage' => FOLDER_SEO_PARENT . '/' . GAME_ANDROID, 'ogUrl' => action('GameController@getListGameAndroid')))

@section('title')
	@if(CommonSite::getMetaSeo('CategoryParent', GAME_ANDROID) && $title = CommonSite::getMetaSeo('CategoryParent', GAME_ANDROID)->title_site)
		{{ $title= $title }}
	@else
		{{ $title = 'Game Android' }}
	@endif
@stop

@section('content')

<?php
	$games = CommonGame::getListGame('android', 1);
?>
<div class="box">
	<h1>Game Android tải nhiều</h1>
	@if($games)
	<?php
		$count = ceil(count($games->get())/PAGINATE_BOXGAME);
	?>
	<div class="swiper-container">
		<div class="swiper-wrapper">
			@for($i = 0; $i < $count ; $i ++)
				<div class="swiper-slide boxgame">
					<div class="row">
					<?php
						$listGame = $games->orderBy('count_download', 'desc')->take(PAGINATE_BOXGAME)->skip($i * PAGINATE_BOXGAME)->get();
					?>
						@foreach($listGame as $game)
							@include('site.game.gameitem_cronjob', array('game' => $game, 'slug' => null, 'device' => 1))
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
	@endif
</div>

{{-- quang cao --}}
@include('site.common.ads', array('adPosition' => POSITION_MOBILE_GAMEANDROID))

<?php
	$games = CommonGame::getListGame('android', 1);
?>
<div class="box">
	<h3>Game Android mới nhất</h3>
	@if($games)
	<?php
		$count = ceil(count($games->get())/PAGINATE_BOXGAME);
	?>
	<div class="swiper-container">
		<div class="swiper-wrapper">
			@for($i = 0; $i < $count ; $i ++)
				<div class="swiper-slide boxgame">
					<div class="row">
					<?php
						$listGame = $games->orderBy('id', 'desc')->take(PAGINATE_BOXGAME)->skip($i * PAGINATE_BOXGAME)->get();
					?>
						@foreach($listGame as $game)
							@include('site.game.gameitem_cronjob', array('game' => $game, 'slug' => null, 'device' => 1))
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
	@endif
</div>

@include('site.game.scriptbox')

@stop