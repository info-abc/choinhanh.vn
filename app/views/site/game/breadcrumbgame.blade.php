@if(!in_array( $game->parent_id,[GAMEHTML5, GAMEFLASH]))
	<?php
		$breadcrumb = array(
			['name' => Game::find($game->parent_id)->name, 'link' => action('GameController@getListGameAndroid')],
			['name' => $game->name, 'link' => '']
		);
	?>
@else
	<?php
		$breadcrumb = array(
			['name' => Type::find($game->type_main)->name, 'link' => url(Type::find($game->type_main)->slug)],
			['name' => 'Game ' . $game->name, 'link' => '']
		);
	?>
@endif
@include('site.common.breadcrumb', $breadcrumb)