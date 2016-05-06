<?php

class AdCommon 
{
	public static function getPositionClassAd($isMobile = 0)
	{
		if($isMobile == 1) {
			return [
					POSITION_MOBILE_TYPE => 'Trang danh mục mobile', 
					POSITION_MOBILE_VOTEMANY => 'Trang bình chọn nhiều mobile', 
					POSITION_MOBILE_PLAYMANY => 'Trang hay nhất mobile', 
					POSITION_MOBILE_GAMEANDROID => 'Trang game android mobile', 
					POSITION_MOBILE_PLAYBUTTON2 => 'Trang chi tiết chơi game mobile', 
					POSITION_MOBILE_NEWS_SAPO => 'Trang chi tiết tin tức - dưới sapo mobile', 
				];
		} else {
			return [
					POSITION_TYPE => 'Trang danh mục', 
					POSITION_VOTEMANY => 'Trang bình chọn nhiều', 
					POSITION_PLAYMANY => 'Trang hay nhất', 
					POSITION_GAMEANDROID => 'Trang game android', 
					POSITION_GAMEDETAIL => 'Preroll', 
					POSITION_GAMEDETAIL_GAMETOP => 'Trên box game hay nhất', 
					POSITION_NEWS_SAPO => 'Trang chi tiết tin tức - dưới sapo', 
					POSITION_NEWS_RIGHT => 'Trang chi tiết tin tức - dưới tin đáng đọc bên phải', 
					POSITION_NEWS_LIST_RIGHT => 'Trang danh sách tin tức - bên phải', 
				];
		}
	}

	public static function getNamePositionClassAd($position)
	{
		$array1 = self::getPositionClassAd(1);
		$array2 = self::getPositionClassAd();
		$array = $array1 + $array2;
		return $array[$position];
	}

	public static function getAd($position)
	{
		$ad = Advertise::where('status', ENABLED)
				->where('position', $position)
				->first();
		if($ad) {
			return $ad;	
		} else {
			return '';
		}
	}

	public static function getArrayPositionDesktop()
	{
		return [POSITION_TYPE, POSITION_VOTEMANY, POSITION_PLAYMANY, POSITION_GAMEANDROID, POSITION_GAMEDETAIL, POSITION_GAMEDETAIL_GAMETOP, POSITION_NEWS_SAPO, POSITION_NEWS_RIGHT, POSITION_NEWS_LIST_RIGHT];
	}

	public static function getArrayPositionMobile()
	{
		return [POSITION_MOBILE_PLAYBUTTON2, POSITION_MOBILE_TYPE, POSITION_MOBILE_VOTEMANY, POSITION_MOBILE_PLAYMANY, POSITION_MOBILE_GAMEANDROID, POSITION_MOBILE_NEWS_SAPO];
	}

	public static function getDeviceNameAd($isMobile = 0)
	{
		if($isMobile == 0) {
			return 'Desktop';
		}
		return 'Mobile';
	}

}