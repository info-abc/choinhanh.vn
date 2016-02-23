<?php 
class SiteComment {

	public static function getCommentGame($game)
	{
    	$inputComment = Comment::where('model_id', $game->id)->where('status', ACTIVE)->orderBy('id', 'desc')->get();
    	return $inputComment;
	}
}