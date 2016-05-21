<?php 
    if(isset($device)) {
        $device = getDevice($device);
    } else {
        $device = getDevice();
    }
?>
@if($device == COMPUTER)
    <div id="el_{{ $game->id }}" class="tipContent">
        <h2><a href="{{ $url }}">{{ $game->name }}</a></h2>
        <div class="tooltip_content">
        	<img title="{{ $game->name }}" alt="{{ $game->slug }}" src="{{ url(UPLOAD_GAME_AVATAR . '/' .  $game->image_url) }}" />
            <div class="tooltip_text">
                <span>Thể loại: </span>
                <strong>
                    @if(Request::segment(1) != NULL)
                        {{ SiteIndex::getTypeTooltip($game->type_main, 'name') }}
                    @else
                        {{ SiteIndex::getFieldByType($game->type_main, 'name') }}
                    @endif
                </strong>
            	<div>
            		@if($game->parent_id == GAMEOFFLINE)
            			{{ getZero($game->count_download) }} lượt xem
            		@else
    					{{ getZero($game->count_play) }} lượt xem
    				@endif
                    @include('site.common.rate', array('vote_average' => $game->vote_average))
            	</div>
            	<p>{{ limit_text(strip_tags(html_entity_decode($game->description)), TEXTLENGH_DESCRIPTION) }}</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@endif