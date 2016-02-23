@if(!(in_array($game->parent_id, [GAMEFLASH, GAMEHTML5])))
	<a href="{{ $url }}" class="overlay"><i class="fa fa-download"></i></a>
@else
	<a href="{{ $url }}" class="overlay"><i class="fa fa-play-circle"></i></a>
@endif