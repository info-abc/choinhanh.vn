@extends('site.layout.default', array('seoMeta' => CommonSite::getMetaSeo('Type', $type->id), 'seoImage' => FOLDER_SEO_GAMETYPE . '/' . $type->id))

@section('title')
	@if($title = CommonSite::getMetaSeo('Type', $type->id)->title_site)
		{{ $title= $title }}
	@else
		{{ $title = $type->name }}
	@endif
@stop

@section('content')

<?php
	$games = CommonGame::boxGameByType($type);
 ?>
<div class="box">
	<h1>Game {{ $type->name }} hay nhất</h1>
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
						$listGame = $games->orderBy('count_play', 'desc')->orderBy('start_date', 'desc')->take(PAGINATE_BOXGAME)->skip($i * PAGINATE_BOXGAME)->get();
					?>
						@foreach($listGame as $game)
							@include('site.game.gameitem', array('game' => $game, 'slug' => $type->slug))
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
@if(getDevice() == COMPUTER)
	@include('site.common.ads', array('adPosition' => POSITION_TYPE))
@else
	@include('site.common.ads', array('adPosition' => POSITION_MOBILE_TYPE))
@endif

<?php
	$games = CommonGame::boxGameByType($type);
 ?>
<div class="box">
	<h3>Game {{ $type->name }} mới nhất</h3>
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
						$listGame = $games->orderBy('start_date', 'desc')->take(PAGINATE_BOXGAME)->skip($i * PAGINATE_BOXGAME)->get();
					?>
						@foreach($listGame as $game)
							@include('site.game.gameitem', array('game' => $game, 'slug' => $type->slug))
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