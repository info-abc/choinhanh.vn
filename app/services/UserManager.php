<?php
class UserManager
{
	public static function getStatus($value)
	{
		if($value == ACTIVE)
			return ACTIVEUSER;
		return INACTIVEUSER;
	}
	public static function getUsername($value)
	{
		$resultUserName = User::find($value);
		if($resultUserName->uid){
			$input['user_name'] = $resultUserName->uname;
			$input['type_user'] = TYPEFACEBOOK;
			return  $input;
		}
		if($resultUserName->google_id){
			$input['user_name'] = $resultUserName->google_name;
			$input['type_user'] = TYPEGOOGLE;
			return  $input;
		}
		$input['user_name'] = $resultUserName->user_name;
		$input['type_user'] = TYPESYSTEM;
		return  $input;
	}
	
}