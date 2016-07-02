@extends('site.layout.default_pc', array('seoMeta' => CommonSite::getMetaSeo('AdminTag', $tag->id), 'seoImage' => FOLDER_SEO_TAG . '/' . $tag->id, 'ogUrl' => url('game-'.$tag->slug)))

@section('title')
	@if($title = CommonSite::getMetaSeo('AdminTag', $tag->id)->title_site)
		{{ $title = $title }}
	@else
		{{ $title = $tag->title }}
	@endif
@stop

@section('content')

<?php
	$games = CommonGame::boxGameByTag($tag, 2);
?>
<div class="box">
	<h1>{{ $tag->title }}</h1>
 	@if($games)
	<?php $count = ceil(count($games->get())/PAGINATE_BOXGAME); ?>
	<div class="swiper-container">
		<div class="swiper-wrapper">
			@for($i = 0; $i < $count ; $i ++)
				<div class="swiper-slide boxgame">
					<div class="row">
					<?php
						$listGame = $games->orderBy('start_date', 'desc')->orderBy('id', 'desc')->take(PAGINATE_BOXGAME)->skip($i * PAGINATE_BOXGAME)->get();
					?>
						@foreach($listGame as $game)
							@include('site.game.gameitem', array('game' => $game, 'slug' => $tag->slug, 'device' => 2))
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

@if($games)
@include('site.game.scriptbox')
@endif

@stop