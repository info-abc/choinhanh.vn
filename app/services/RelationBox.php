<?php
class RelationBox
{
	public static function getNameBoxAbove($input)
	{
		$className = $input->model_name;
		$name = $className::find($input->model_id)->name;
		return $name;
	}

	public static function insertRelationship($data, $relation, $input)
	{
		if($input && $data && $relation) {
			$data->$relation()->attach($input);
		}
	}

	public static function updateRelationship($data, $relation, $input)
	{
		if($input && $data && $relation) {
			$data->$relation()->sync($input);
		}
		if(!$input) {
			$data->$relation()->detach();
		}
	}

	public static function deleteRelationship($data, $relation)
	{
		if($data && $relation) {
			$data->$relation()->detach();
		}
	}
//Relation get name 
	public static function getNameBox($value, $modelName, $modelId)
	{
		if($value->$modelName == CATEGORYPARENT) {
		$position = CategoryParent::find($value->$modelId)->position;
		if ($position == MENU) {
			return MENURELATION;
		}
		if ($position == CONTENT) {
			return CONTENTREATION;
		}
		return CONTENT_REATION;
	}
	return TYPE;
	}
	//Relation get category
	public static function getCategoryRelation($value, $modelName)
	{
		$data = $modelName::find($value);
		if($data)
		{
			return $data->name;
		}
		return null;
	}
}