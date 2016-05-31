@if(!in_array( $game->parent_id,[GAMEHTML5, GAMEFLASH]))
	<?php
		$segment1 = Request::segment(1);
		$segment1 = substr($segment1, 5);
		$tag = AdminTag::findBySlug($segment1);
		if($tag) {
			$name = $tag->title;
			$link = url( 'game-' . $tag->slug);
		} else {
			$name = Game::find($game->parent_id)->name;
			$link = action('GameController@getListGameAndroid');
		}
		$breadcrumb = array(
			['name' => $name, 'link' => $link],
			['name' => $game->name, 'link' => '']
		);
	?>
@else
	<?php
		$segment1 = Request::segment(1);
		$segment1 = substr($segment1, 5);
		$tag = AdminTag::findBySlug($segment1);
		$type = Type::findBySlug($segment1);
		if($tag) {
			$name = $tag->title;
			$slug = $tag->slug;
		} elseif($type) {
			$name = $type->name;
			$slug = $type->slug;
		}
		else {
			$type = Type::find($game->type_main);
			$name = $type->name;
			$slug = $type->slug;
		}
		$breadcrumb = array(
			['name' => $name, 'link' => url( 'game-' . $slug)],
			['name' => 'Game ' . $game->name, 'link' => '']
		);
	?>
@endif
@include('site.common.breadcrumb', $breadcrumb)