<?php
class SiteIndex
{
	public static function getTypeOfParent($parentId)
	{
        $listTypeId = ParentType::where('category_parent_id', $parentId)->orderBy('weight_number', 'asc')->lists('type_id');
		return $listTypeId;
	}

    public static function getFieldByType($typeId, $field)
    {
        if (Cache::has('type_'.$typeId.$field))
        {
            $result = Cache::get('type_'.$typeId.$field);
        } else {
            $result = Type::find($typeId);
            if($result) {
                $result = $result->$field;
            } else {
                $result = '';
            }
            Cache::put('type_'.$typeId.$field, $result, CACHETIME);
        }
        return $result;
    }

    public static function getTypeTooltip($typeId, $field)
    {
        $type = CommonSite::getTypeBySlug();
        if($type) {
            $result = $type->$field;    
        } else {
            $result = Type::find($typeId);
            if($result) {
                $result = $result->$field;
            } else {
                $result = '';
            }
        }
        return $result;
    }

    public static function getTypeNewMenu()
    {
        if (Cache::has('getTypeNewMenu'))
        {
            $getTypeNewMenu = Cache::get('getTypeNewMenu');
        } else {
            $getTypeNewMenu = TypeNew::all();
            Cache::put('getTypeNewMenu', $getTypeNewMenu, CACHETIME);
        }
        return $getTypeNewMenu;
    }

}