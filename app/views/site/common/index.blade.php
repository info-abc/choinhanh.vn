@extends('site.layout.default', array('seoMeta' => CommonSite::getMetaSeo(SEO_META)))

@section('title')
{{ $title='Trang chủ' }}
@stop

@section('content')

@if($news = CommonSite::getLatestNews())
<div class="box">
	<a class="homenews" href="{{ action('SiteNewsController@show', $news->slug) }}"><i class="fa fa-caret-right"></i> [{{ $news->typeNew->name }}] {{ $news->title }}</a>
</div>
@endif

<div class="box">
	@foreach($menu as $value)
		@if($value->position == CONTENT)
		<h3>{{ $value->name }}</h3>
		@if($games = CommonGame::boxGameByCategoryParentIndex($value))
			<?php $count = ceil(count($games)/PAGINATE_BOXGAME);
				$count = getCount($count);
			 ?>
			<div class="swiper-container">
				<div class="swiper-wrapper">
					@for($i = 0; $i < $count; $i ++)
						<div class="swiper-slide boxgame">
							<div class="row">
							<?php
								//$listGame = $games->take(PAGINATE_BOXGAME)->skip($i * PAGINATE_BOXGAME)->get();
								$listGame = array_slice($games, $i * PAGINATE_BOXGAME, PAGINATE_BOXGAME);
							?>
								@foreach($listGame as $game)
									@include('site.game.gameitemindex', array('game' => $game))
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
		@include('site.common.ad', array('adPosition' => CHILD_PAGE, 'modelName' => 'CategoryParent', 'modelId' => $value->id))

		@endif
	@endforeach

</div>

@include('site.game.scriptbox')

@stop
