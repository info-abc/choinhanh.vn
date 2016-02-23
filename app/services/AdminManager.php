<?php
class AdminManager
{
	public static function searchUserOperation($input)
	{
		$users = Admin::where(function ($query) use ($input){
			if ($input['role_id']) {
				$query = $query->where('role_id', $input['role_id']);
			}
			if ($input['keyword']) {
				$query = $query->where('email', 'like', '%'.$input['keyword'].'%')
								->orWhere('username', 'like', '%'.$input['keyword'].'%');
			}
			// todo
			if ($input['status'] != '') 
				$query = $query->where('status', '=' ,$input['status']);
			if ($input['start_date']) 
				$query = $query->where('updated_at', '>=' ,$input['start_date']);
			if ($input['end_date']) 
				$query = $query->where('updated_at', '<=' ,$input['end_date'].' 23:59:59');
		})->orderBy('id', 'asc')->paginate(PAGINATE);
		return $users;
	}

	public static function createParentType($arrayTypeId, $arrayWeightNumber, $parentId, $modelName)
	{
		$input = array();
		if ($arrayTypeId) {
			foreach ($arrayTypeId as $value) {
				$input = self::commonInputParentType($arrayWeightNumber, $value, $parentId);
				$modelName::create($input);
			}
		}
	}

	public static function updateParentType($arrayTypeId, $arrayWeightNumber, $parentId, $modelName)
	{
		$listId = ParentType::where('category_parent_id', $parentId)->lists('id');
		foreach ($listId as $listId){
			$modelName::destroy($listId);
		}
		self::createParentType($arrayTypeId, $arrayWeightNumber, $parentId, $modelName);
	}

	public static function commonInputParentType($arrayWeightNumber, $typeId, $parentId)
	{
		$input = array();
		$input['weight_number'] = $arrayWeightNumber[$typeId];
		$input['type_id'] = $typeId;
		$input['category_parent_id'] = $parentId;
		return $input;
	}

}
