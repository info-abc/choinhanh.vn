<?php
use Carbon\Carbon;
class CommonNormal
{
	public static function delete($id)
	{
		$name = self::commonName();
		$name::find($id)->delete();
	}

	public static function update($id, $input, $modelName = NULL)
	{
		$name = self::commonName();
		if($modelName) {
			$name = $modelName;
		}
		$name::find($id)->update($input);
	}

	public static function create($input, $name = NULL)
	{
		$name = self::commonName($name);
		$id = $name::create($input)->id;
		return $id;
	}

	public static function commonName($name = NULL)
	{
		if ($name == NULL) {
			$name = Request::segment(2);
		}
		if ($name == '') {
			return 'CategoryParent';
		}
		if($name =='category_parent'){
			return 'CategoryParent';
		}
		if($name =='category'){
			return 'Game';
		}
		if ($name == 'manager') {
			return 'Admin';
		}
		if ($name == 'GameRelation') {
			return 'GameRelation';
		}
		if ($name == 'gametype') {
			return 'Type';
		}
		if($name =='newstype'){
			return 'TypeNew';
		}
		if($name =='news'){
			return 'AdminNew';
		}
		if ($name == 'games') {
			return 'Game';
		}
		if ($name == 'game_type') {
			return 'GameType';
		}
		if ($name == 'history') {
			return 'AdminHistory';
		}
		if ($name == 'log_edit') {
			return 'LogEdit';
		}
		if($name == 'relation') {
			return 'Relation';
		}
		if($name == 'comment') {
			return 'Comment';
		}
		if($name == 'feedback') {
			return 'Feedback';
		}
		if($name == 'feedback_game') {
			return 'GameErrors';
		}
		if($name == 'seo') {
			return 'AdminSeo';
		}
		if($name == 'user') {
			return 'User';
		}
		if($name == 'policy') {
			return 'Policy';
		}
		if($name == 'GameVote') {
			return 'GameVote';
		}
		if($name == 'score') {
			return 'Score';
		}
		if($name == 'AdminError') {
			return 'AdminError';
		}
		if($name == 'AdminErrorLog') {
			return 'AdminErrorLog';
		}
		if($name == 'tags') {
			return 'AdminTag';
		}
		
	}
}