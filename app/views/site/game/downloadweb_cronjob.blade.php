@extends('site.layout.default_pc', array('seoMeta' => CommonSite::getMetaSeo('Game', $game->id), 'seoImage' => FOLDER_SEO_GAME . '/' . $game->id, 'gameUrl' => CommonGame::getUrlGame($game)))

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

	<!-- WEB -->
	<div class="web">

		<div class="game_avatar">
			<img alt="{{ $game->slug }}" src="{{ url(UPLOAD_GAME_AVATAR . '/' . $game->image_url) }}" />
		</div>
		<div class="game_title">

			<h1 class="title">{{ $game->name }}</h1>

			<?php echo '@include("site.common.rate", array("vote_average" => $game->vote_average))'; ?>

			<p><?php echo '{{ getZero($game->count_download) }}'; ?> lượt chơi</p>

			<div class="social-top">@include('site.game.social', array('id' => $game->id))</div>

		</div>

		@include('site.game.download_button', array('game' => $game))
		
		<div class="slideGame">
			@include('site.game.slide', array('slideId' => $game->slide_id))
		</div>

		<div class="detail">{{ $game->description }}</div>

		@include('site.game.download_button', array('game' => $game))

		@include('site.game.vote', array('id' => $game->id))

		@include('site.game.social', array('id' => $game->id))

	</div>

	<?php echo '@include("site.game.comment")'; ?>

</div>

@include('site.game.related_pc', array('game' => $game))

@stop
