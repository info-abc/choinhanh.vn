<div id="el_{{ $game->id }}" class="tipContent">
    <h2><a href="{{ $url }}">{{ $game->name }}</a></h2>
    <div class="tooltip_content">
    	<img title="{{ $game->name }}" alt="{{ $game->slug }}" src="{{ url(UPLOAD_GAME_AVATAR . '/' .  $game->image_url) }}" >
        <p>
        	Thể loại: <strong>{{ SiteIndex::getFieldByType($game->type_main, 'name') }}</strong>
        	<span>
        		@if($game->parent_id == GAMEOFFLINE)
        			{{ getZero($game->count_download) }} lượt tải
        		@else
					{{ getZero($game->count_play) }} lượt chơi
				@endif
        	</span>
        	
        	{{ limit_text(strip_tags($game->description), TEXTLENGH_DESCRIPTION) }}
        </p>
        <div class="clearfix"></div>
    </div>
</div>