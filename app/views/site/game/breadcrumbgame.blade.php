@if(!in_array( $game->parent_id,[GAMEHTML5, GAMEFLASH]))
	<?php
		$breadcrumb = array(
			['name' => Game::find($game->parent_id)->name, 'link' => action('GameController@getListGameAndroid')],
			['name' => $game->name, 'link' => '']
		);
	?>
@else
	<?php
		$segment1 = Request::segment(1);
		$segment1 = substr($segment1, 5);
		$tag = AdminTag::findBySlug($segment1);
		if($tag) {
			$name = $tag->title;
			$slug = $tag->slug;
		} else {
			$name = Type::find($game->type_main)->name;
			$slug = Type::find($game->type_main)->slug;
		}
		$breadcrumb = array(
			['name' => $name, 'link' => url( 'game-' . $slug)],
			['name' => 'Game ' . $game->name, 'link' => '']
		);
	?>
@endif
@include('site.common.breadcrumb', $breadcrumb)