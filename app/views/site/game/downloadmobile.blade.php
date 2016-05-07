@extends('site.layout.default', array('seoMeta' => CommonSite::getMetaSeo('Game', $game->id), 'seoImage' => FOLDER_SEO_GAME . '/' . $game->id, 'gameUrl' => CommonGame::getUrlGame($game)))

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

			<h1 class="title mobile-title">{{ limit_text($game->name, TEXTLENGH) }}</h1>

			@include('site.common.rate', array('vote_average' => $game->vote_average))

			<p>{{ getZero($game->count_download) }} lượt tải</p>

		</div>

		<div class="col-xs-12">

			<div class="row">
				<div class="col-sm-4">
					@if($game->link_download != '')
						<div class="btn-block-center">
							<a onclick="countdownload('android')" class="download download_android" target="_blank"><i class="fa fa-download"></i> Tải về phiên bản Android</a>
						</div>
					@endif
				</div>
				<div class="col-sm-4">
					@if($game->link_download_ios != '')
						<div class="btn-block-center">
							<a onclick="countdownload('ios')" class="download download_ios" target="_blank"><i class="fa fa-download"></i> Tải về phiên bản IOS</a>
						</div>
					@endif
				</div>
				<div class="col-sm-4">
					@if($game->link_download_winphone != '')
						<div class="btn-block-center">
							<a onclick="countdownload('winphone')" class="download download_winphone" target="_blank"><i class="fa fa-download"></i> Tải về phiên bản Windowphone</a>
						</div>
					@endif
				</div>
			</div>

			<div class="slideGame">
				@include('site.game.slide', array('slideId' => $game->slide_id))
			</div>

			<div class="detail">
				{{ $game->description }}
			</div>

			<div class="row">
				<div class="col-sm-4">
					@if($game->link_download != '')
						<div class="btn-block-center">
							<a onclick="countdownload('android')" class="download download_android" target="_blank"><i class="fa fa-download"></i> Tải về phiên bản Android</a>
						</div>
					@endif
				</div>
				<div class="col-sm-4">
					@if($game->link_download_ios != '')
						<div class="btn-block-center">
							<a onclick="countdownload('ios')" class="download download_ios" target="_blank"><i class="fa fa-download"></i> Tải về phiên bản IOS</a>
						</div>
					@endif
				</div>
				<div class="col-sm-4">
					@if($game->link_download_winphone != '')
						<div class="btn-block-center">
							<a onclick="countdownload('winphone')" class="download download_winphone" target="_blank"><i class="fa fa-download"></i> Tải về phiên bản Windowphone</a>
						</div>
					@endif
				</div>
			</div>

			@include('site.game.scriptcountdownload', array('id' => $game->id, 'url_android' => url(CommonGame::getUrlDownload($game, 'android')), 'url_ios' => url(CommonGame::getUrlDownload($game, 'ios')), 'url_winphone' => url(CommonGame::getUrlDownload($game, 'winphone')) ))

			@include('site.game.vote', array('id' => $game->id))

			@include('site.game.social', array('id' => $game->id))

		</div>

	</div>

	@include('site.game.comment')

</div>

@include('site.game.related', array('game' => $game))

@stop

