@extends('site.layout.default', array('seoMeta' => CommonSite::getMetaSeo('CategoryParent', 9), 'seoImage' => FOLDER_SEO_PARENT . '/' . 9))

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
	<div class="boxgame-container">
		<div class="boxgame-wrapper" id="boxgame-wrapper-1">
			{{ CommonGame::loadGameBox('play', 'count_play', getDevice()) }}
		</div>
		<div class="boxgame-pagination">
			<a class="prev" onclick="loadGamePrev(1, 'play', 'count_play', {{ getDevice() }})"><i class="fa fa-caret-left"></i> Trang trước</a>
			<div class="boxgame-pagenumber"><span class="numberPage1">1</span>/<span class="totalNumberPage1">{{ CommonGame::countGameBox('play', 'count_play', getDevice()) }}</span></div>
			<a class="next" onclick="loadGameNext(1, 'play', 'count_play', {{ getDevice() }})">Trang sau <i class="fa fa-caret-right"></i></a>
		</div>
	</div>
</div>

{{-- quang cao --}}
@if(getDevice() == COMPUTER)
	@include('site.common.ads', array('adPosition' => POSITION_PLAYMANY))
@else
	@include('site.common.ads', array('adPosition' => POSITION_MOBILE_PLAYMANY))
@endif

<div class="box">
	<h3>Game bình chọn nhiều</h3>
	<div class="boxgame-container">
		<div class="boxgame-wrapper" id="boxgame-wrapper-2">
			{{ CommonGame::loadGameBox('play', 'vote_average', getDevice()) }}
		</div>
		<div class="boxgame-pagination">
			<a class="prev" onclick="loadGamePrev(2, 'play', 'vote_average', {{ getDevice() }})"><i class="fa fa-caret-left"></i> Trang trước</a>
			<div class="boxgame-pagenumber"><span class="numberPage2">1</span>/<span class="totalNumberPage2">{{ CommonGame::countGameBox('play', 'vote_average', getDevice()) }}</span></div>
			<a class="next" onclick="loadGameNext(2, 'play', 'vote_average', {{ getDevice() }})">Trang sau <i class="fa fa-caret-right"></i></a>
		</div>
	</div>
</div>

@include('site.game.scriptboxgame')

@stop
