<?php 
	if(isset($game)) {
		$gameUrl = CommonGame::getUrlGame($game);
	} else {
		$gameUrl = null;
	}
?>
@extends('site.layout.default', array('seoMeta' => CommonSite::getMetaSeo('Game', $game->id), 'seoImage' => FOLDER_SEO_GAME . '/' . $game->id, 'gameUrl' => $gameUrl))

@section('title')
	@if($title = CommonSite::getMetaSeo('Game', $game->id)->title_site)
		{{ $title= $title }}
	@else
		{{ $title = $game->name }}
	@endif
@stop

@section('content')

<div class="box">

	@include('site.game.breadcrumbgame', array('game' => $game))

	<!-- MOBILE <= 500px -->
	<div class="row mobile">

		<div class="mobile_avatar">
			<img alt="{{ $game->slug }}" src="{{ url(UPLOAD_GAME_AVATAR . '/' . $game->image_url) }}" />
		</div>
		<div class="mobile_title">

			<h1 class="title mobile-title">{{ $game->name }}</h1>

			@include('site.common.rate', array('vote_average' => $game->vote_average))

			<p>{{ getZero($game->count_play) }} lượt chơi</p>

		</div>

	  	<div class="col-xs-12">

	  		@if($game->parent_id != GAMEFLASH)
	  			<div class="btn-block-center">
					<a onclick="countplay({{ $game->id }},'{{ CommonGame::getLinkPlayGameHtml5($game, $gameUrl, 1) }}')" class="download"><i class="fa fa-play-circle-o"></i> Chơi ngay</a>
				</div>
			@else
				<div class="btn-block-center">
					<p class="no-for-mobile">Game chỉ chơi trên máy tính</p>
				</div>
			@endif

			<div class="slideGame">
				@include('site.game.slide', array('slideId' => $game->slide_id))
			</div>

			<div class="detail">{{ $game->description }}</div>

			@if(getDevice() == MOBILE)
				@include('site.common.ads', array('adPosition' => POSITION_MOBILE_PLAYBUTTON2))
			@endif

			@if($game->parent_id != GAMEFLASH)
	  			<div class="btn-block-center">
					<a onclick="countplay({{ $game->id }},'{{ CommonGame::getLinkPlayGameHtml5($game, $gameUrl, 1) }}')" class="download"><i class="fa fa-play-circle-o"></i> Chơi ngay</a>
				</div>
			@else
				<div class="btn-block-center">
					<p class="no-for-mobile">Game chỉ chơi trên máy tính</p>
				</div>
			@endif

			{{-- @include('site.game.scriptcountplay', array('id' => $game->id, 'url' => Request::url() . '?play=true')) --}}

			@if($game->parent_id != GAMEFLASH)
				<script src="{{ url('assets/js/scriptcountplay.js') }}"></script>
			@endif

			@include('site.game.vote', array('id' => $game->id))

			@include('site.game.social', array('id' => $game->id))

	  	</div>

	</div>

	@include('site.game.comment')

</div>

@include('site.game.related_mobile', array('game' => $game))

@stop