@extends('site.layout.default', array('seoMeta' => CommonSite::getMetaSeo('Game', $game->id), 'seoImage' => FOLDER_SEO_GAME . '/' . $game->id))

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
			<img alt="{{ $game->name }}" src="{{ url(UPLOAD_GAME_AVATAR . '/' . $game->image_url) }}" />
		</div>
		<div class="mobile_title">

			<h1 class="title mobile-title">{{ limit_text($game->name, TEXTLENGH) }}</h1>

			@include('site.common.rate', array('vote_average' => $game->vote_average))

			<p>{{ getZero($game->count_download) }} lượt tải</p>

		</div>

		<div class="col-xs-12">

			<div class="btn-block-center">
				<a onclick="countdownload()" class="download"><i class="fa fa-download"></i> Tải về</a>
			</div>

			<div class="slideGame">
				@include('site.game.slide', array('slideId' => $game->slide_id))
			</div>

			<div class="detail">
				{{ $game->description }}
			</div>

			<div class="btn-block-center">
				<a onclick="countdownload()" class="download"><i class="fa fa-download"></i> Tải về</a>
			</div>

			@include('site.game.scriptcountdownload', array('id' => $game->id, 'url' => CommonGame::getUrlDownload($game)))

			@include('site.game.vote', array('id' => $game->id))

			@include('site.game.social', array('id' => $game->id))

		</div>

	</div>

	@include('site.game.comment')

</div>

@include('site.game.related', array('parentId' => $game->parent_id, 'limit' => GAME_RELATED_MOBILE, 'typeId' => $game->type_main))

@stop

