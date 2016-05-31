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

	<div class="playgame">
		<h1>Game {{ $game->name }}</h1>
		<div class="playbox">
			{{ CommonGame::getLinkGame($game) }}
			<div class="social-box">
				<?php echo '@include("site.game.socialbox", array("id" => $game->id))'; ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-8">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs gamenav" role="tablist">
				<li role="presentation" class="active"><a href="#gametab" aria-controls="gametab" role="tab" data-toggle="tab">Thông tin trò chơi</a></li>
				<li role="presentation"><a href="#gameerror" aria-controls="gameerror" role="tab" data-toggle="tab">Báo lỗi</a></li>
			</ul>
			<!-- Tab panes -->
			<div class="tab-content gamecontent">
				<div role="tabpanel" class="tab-pane active" id="gametab">
					<div class="web">

						<div class="game_avatar">
							<img alt="{{ $game->slug }}" src="{{ url(UPLOAD_GAME_AVATAR . '/' . $game->image_url) }}" />
						</div>
						<div class="game_title">

							<h2 class="title">{{ $game->name }}</h2>

							@include('site.common.rate', array('vote_average' => $game->vote_average))

							<p>{{ getZero($game->count_play) }} lượt xem</p>

						</div>

						<div class="slideGame">
							@include('site.game.slide', array('slideId' => $game->slide_id))
						</div>

						<div class="detail">{{ $game->description }}</div>

					</div>

					<?php echo '@include("site.game.comment")'; ?>
				</div>
				<div role="tabpanel" class="tab-pane" id="gameerror">
					<div class="gameerror">
						@include('site.game.errorgame', array('id' => $game->id))
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="gamecontent-right">

				<?php echo '@include("site.game.score", array("id" => $game->id))'; ?>
				
				@include('site.game.topgame_cronjob', array('device' => 2))
			</div>
		</div>
	</div>
</div>

@include('site.game.related_pc', array('game' => $game))
@stop