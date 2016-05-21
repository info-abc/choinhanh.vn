<?php $seoMeta = CommonSite::getMetaSeo(SEO_META, '', 1); ?>
@extends('site.layout.default_mobile', array('seoMeta' => $seoMeta))

@section('title')
	@if($title = $seoMeta->title_site)
		{{ $title= $title }}
	@else
		{{ $title='Trang chủ' }}
	@endif
@stop

@section('content')

<div class="box">
	@foreach($menu = CategoryParent::where('status', ACTIVE)->where('position', CONTENT)->orderBy('weight_number', 'asc')->get() as $value)
		@if($value->position == CONTENT)
		<h3><a href="{{ CommonGame::getUrlCategoryParent($value->id) }}">{{ $value->name }}</a></h3>
			@if($games = CommonGame::boxGameByCategoryParentIndex2($value))
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
										@include('site.game.gameitem', array('game' => $game, 'slug' => null, 'device' => 1))
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
			@include('site.common.ad', array('adPosition' => CHILD_PAGE, 'modelName' => 'CategoryParent', 'modelId' => $value->id, 'device' => 1, 'noCache' => 1))
		@endif
	@endforeach
</div>

@include('site.common.gameboxmini', array('noCache' => 1))

@include('site.game.scriptbox')

@stop

