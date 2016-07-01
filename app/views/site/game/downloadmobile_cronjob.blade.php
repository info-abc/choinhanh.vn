@extends('site.layout.default_mobile', array('seoMeta' => CommonSite::getMetaSeo('Game', $game->id), 'seoImage' => FOLDER_SEO_GAME . '/' . $game->id, 'gameUrl' => CommonGame::getUrlGame($game)))

@section('title')
	@if($title = CommonSite::getMetaSeo('Game', $game->id)->title_site)
		{{ $title= $title }}
	@else
		{{ $title = $game->name }}
	@endif
@stop

@section('content')

<div class="box">

	<?php echo '@include("site.game.breadcrumbgame_cronjob", array("game" => $game))'; ?>

	<!-- MOBILE <= 500px -->
	<div class="row mobile">

		<div class="mobile_avatar">
			<img alt="{{ $game->slug }}" src="{{ url(UPLOAD_GAME_AVATAR . '/' . $game->image_url) }}" />
		</div>
		<div class="mobile_title">

			<h1 class="title mobile-title">{{ limit_text($game->name, TEXTLENGH) }}</h1>

			<?php echo '@include("site.common.rate", array("vote_average" => $game->vote_average))'; ?>

			<p><?php echo '{{ getZero($game->count_download) }}'; ?> lượt chơi</p>

		</div>

		<div class="col-xs-12">

			<?php echo '@include("site.game.download_button", array("game" => $game))'; ?>

			<div class="slideGame">
				@include('site.game.slide', array('slideId' => $game->slide_id))
			</div>

			<div class="detail">
				{{ $game->description }}
			</div>

			<?php echo '@include("site.game.download_button", array("game" => $game))'; ?>

			@include('site.game.vote', array('id' => $game->id))

			@include('site.game.social', array('id' => $game->id))

		</div>

	</div>

	<?php echo '@include("site.game.comment")'; ?>

</div>

@include('site.game.related_mobile', array('game' => $game))

@stop

