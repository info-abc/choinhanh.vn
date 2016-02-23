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

	<div class="playgame">
		<h3>Game {{ $game->name }}</h3>
		<div class="playbox">
			{{ CommonGame::getLinkGame($game) }}
			<div class="social-box">
				@include('site.game.socialbox', array('id' => $game->id))
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
							<img alt="{{ $game->name }}" src="{{ url(UPLOAD_GAME_AVATAR . '/' . $game->image_url) }}" />
						</div>
						<div class="game_title">

							<h1 class="title">{{ $game->name }}</h1>

							@include('site.common.rate', array('vote_average' => $game->vote_average))

							<p>{{ getZero($game->count_play) }} lượt chơi</p>

						</div>

						<div class="slideGame">
							@include('site.game.slide', array('slideId' => $game->slide_id))
						</div>

						<div class="detail">{{ $game->description }}</div>

					</div>

					@include('site.game.comment')
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
				@include('site.game.score', array('id' => $game->id))

				{{ $gametop }}
			</div>
		</div>
	</div>
</div>

@include('site.game.related', array('parentId' => $game->parent_id, 'limit' => GAME_RELATED_WEB, 'typeId' => $game->type_main))

@stop