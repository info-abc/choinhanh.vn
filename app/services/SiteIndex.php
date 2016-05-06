<?php
class SiteIndex
{
	public static function getTypeOfParent($parentId)
	{
		if (Cache::has('listTypeId'.$parentId))
        {
            $listTypeId = Cache::get('listTypeId'.$parentId);
        } else {
        	$listTypeId = ParentType::where('category_parent_id', $parentId)->orderBy('weight_number', 'asc')->lists('type_id');
            Cache::put('listTypeId'.$parentId, $listTypeId, CACHETIME);
        }
		return $listTypeId;
	}

    public static function getFieldByType($typeId, $field)
    {
        if (Cache::has('type_'.$typeId.$field))
        {
            $result = Cache::get('type_'.$typeId.$field);
        } else {
            $result = Type::find($typeId)->$field;
            Cache::put('type_'.$typeId.$field, $result, CACHETIME);
        }
        return $result;
    }

    public static function getTypeTooltip($typeId, $field)
    {
        // $segment1 = Request::segment(1);
        // if (Cache::has('getTypeTooltip_'.$typeId.$field))
        // {
        //     $result = Cache::get('getTypeTooltip_'.$typeId.$field);
        // } else {
            $type = CommonSite::getTypeBySlug();
            if($type) {
                $result = $type->$field;    
            } else {
                $result = Type::find($typeId)->$field;                  
            }
        //     Cache::put('getTypeTooltip_'.$typeId.$field, $result, CACHETIME);
        // }
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