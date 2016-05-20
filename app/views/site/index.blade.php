<?php $seoMeta = CommonSite::getMetaSeo(SEO_META); ?>
@extends('site.layout.default', array('seoMeta' => $seoMeta, 'device' => $device))

@section('title')
	@if($title = $seoMeta->title_site)
		{{ $title= $title }}
	@else
		{{ $title='Trang chủ' }}
	@endif
@stop

@section('content')

{{-- @if($news = CommonSite::getLatestNews()) --}}
<!-- <div class="box">
	<a class="homenews" href="{{-- action('SiteNewsController@show', $news->slug) --}}"><i class="fa fa-caret-right"></i> [{{-- $news->typeNew->name --}}] {{-- $news->title --}}</a>
</div> -->
{{-- @endif --}}

<div class="box">
	<h3><a href="{{ url('/game-hay-nhat') }}">Game hay nhất</a></h3>
	<?php
		$games = CommonGame::getListGame('play');
		$count = ceil(count($games->get())/PAGINATE_BOXGAME);
		$count = getCount($count);
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
							@include('site.game.gameitem', array('game' => $game, 'slug' => null))
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
	@include('site.common.ad', array('adPosition' => CHILD_PAGE, 'modelName' => 'CategoryParent', 'modelId' => 9))

	<h3><a href="{{ url('/game-moi-nhat') }}">Game mới nhất</a></h3>
	<?php
		// $games = CommonGame::getListGame('play');
		// $count = ceil(count($games->get())/PAGINATE_BOXGAME);
	?>
	<div class="swiper-container">
		<div class="swiper-wrapper">
			@for($i = 0; $i < $count ; $i ++)
				<div class="swiper-slide boxgame">
					<div class="row">
					<?php
						$listGame = $games->orderBy('start_date', 'desc')->take(PAGINATE_BOXGAME)->skip($i * PAGINATE_BOXGAME)->get();
					?>
						@foreach($listGame as $game)
							@include('site.game.gameitem', array('game' => $game, 'slug' => null))
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
	@include('site.common.ad', array('adPosition' => CHILD_PAGE, 'modelName' => 'CategoryParent', 'modelId' => 7))

	<h3><a href="{{ url('/game-android') }}">Game Android</a></h3>
	<?php
		$games = CommonGame::getListGame('android');
		$count = ceil(count($games->get())/PAGINATE_BOXGAME);
		$count = getCount($count);
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
							@include('site.game.gameitem', array('game' => $game, 'slug' => null))
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
	@include('site.common.ad', array('adPosition' => CHILD_PAGE, 'modelName' => 'CategoryParent', 'modelId' => 8))

</div>

@include('site.common.gameboxmini')

@include('site.game.scriptbox')

@stop

