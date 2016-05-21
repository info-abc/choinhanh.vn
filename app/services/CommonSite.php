<?php
class CommonSite
{
	public static function isLogin()
    {
        if (Auth::user()->check()) {
            return true;
        }
        else{
            return false;
        }
    }
    public static function listTag()
    {
        $tags = AdminTag::where('status', ACTIVE)->get();
            $listTags = [];
            foreach ($tags as $key => $value) {
                if (count($value->games) > 0) {
                    $listTags[$key] = $value;
                }
            }
        return $listTags;
    }

    public static function inputRegister()
    {
    	$input = Input::except('_token');
    	$input['status'] = ACTIVE;
    	$input['ip'] = getIpAddress();
    	$input['device'] = getDevice();
    	return $input;
    }

    // get ip & device to update when user login account
    public static function ipDeviceUser()
    {
        $input = array();
        $input['ip'] = getIpAddress();
        $input['device'] = getDevice();
        return $input;
    }

    // get advertise
    public static function getAdvertise($position, $modelName = null, $modelId = null, $device = null, $noCache = null)
    {
        $ad = null;
        $isMobile = self::getDeviceValue($device);
        // Header & Footer
        if($modelName == null && $modelId == null) {
            if($noCache == null) {
                if (Cache::has('getAdvertise_'.$position.'_'.$isMobile))
                {
                    $ad = Cache::get('getAdvertise_'.$position.'_'.$isMobile);
                } else {
                    $ad = Advertise::where('position', $position)
                            ->where('status', ENABLED)
                            ->where('is_mobile', $isMobile)
                            ->first();
                    Cache::put('getAdvertise_'.$position.'_'.$isMobile, $ad, CACHETIME);
                }
            } else {
                $ad = Advertise::where('position', $position)
                            ->where('status', ENABLED)
                            ->where('is_mobile', $isMobile)
                            ->first();
            }
			if(isset($ad)) {
				return $ad;
			} else {
				return null;
			}
        }
        // Content
        else {
            if($noCache == null) {
                if (Cache::has('getAdvertise_'.$modelName.'_'.$modelId.'_'.$isMobile))
                {
                    $ad = Cache::get('getAdvertise_'.$modelName.'_'.$modelId.'_'.$isMobile);
                } else {
                    $ad = CommonModel::join('advertise_positions', 'common_models.id', '=', 'advertise_positions.common_model_id')
                        ->join('advertisements', 'advertise_positions.advertisement_id', '=', 'advertisements.id')
                        ->where('common_models.model_name', $modelName)
                        ->where('common_models.model_id', $modelId)
                        ->where('advertise_positions.status', ENABLED)
                        ->where('advertisements.is_mobile', $isMobile)
                        ->first();
                    Cache::put('getAdvertise_'.$modelName.'_'.$modelId.'_'.$isMobile, $ad, CACHETIME);
                }
            } else {
                $ad = CommonModel::join('advertise_positions', 'common_models.id', '=', 'advertise_positions.common_model_id')
                        ->join('advertisements', 'advertise_positions.advertisement_id', '=', 'advertisements.id')
                        ->where('common_models.model_name', $modelName)
                        ->where('common_models.model_id', $modelId)
                        ->where('advertise_positions.status', ENABLED)
                        ->where('advertisements.is_mobile', $isMobile)
                        ->first();
            }
            if(isset($ad)) {
                return $ad;
            } else {
                return null;
            }
        }
    }

    public static function getRelationModel($id, $relationType) {
        $model = Relation::where('model_name', $relationType)
                        ->where('model_id', $id)
                        ->first();
        if ($model) {
            return $relationType::find($model->relation_id);
        }
        return null;
    }

    public static function getLatestNews()
    {
        if (Cache::has('newsLatest'))
        {
            $news = Cache::get('newsLatest');
        } else {
            $now = Carbon\Carbon::now();
            $news =  AdminNew::where('start_date', '<=', $now)
                ->orderBy('start_date', 'desc')
                ->first();
            Cache::put('newsLatest', $news, CACHETIME);
        }
        if($news) {
            return $news;
        } else {
            return null;
        }
    }

    public static function getMetaSeo($modelName, $modelId = '', $noCache = null)
    {
        $seoMeta = null;
        //seo trang chu - CACHE OR NO CACHE
        if(!$modelId) {
            if($noCache == null) {
                if (Cache::has('getMetaSeo_'.$modelName.'_home'))
                {
                    $seoMeta = Cache::get('getMetaSeo_'.$modelName.'_home');
                } else {
                    $seoMeta = AdminSeo::where('model_name', $modelName)
                            ->first();
                    Cache::put('getMetaSeo_'.$modelName.'_home', $seoMeta, CACHETIME);
                }
            } else {
                $seoMeta = AdminSeo::where('model_name', $modelName)
                            ->first();
            }
            return $seoMeta;
        }
        //seo cac trang con - NO CACHE
        $seoMeta = AdminSeo::where('model_name', $modelName)
                ->where('model_id', $modelId)
                ->first();
        if($seoMeta) {
            $meta = $modelName::find($modelId);
            if($modelName == 'Game') {
                $typeByTypeMain = Type::find($meta->type_main);
                $typeBySlug = self::getTypeBySlug();
                if(isset($typeBySlug) && isset($typeByTypeMain)) {
                    if($typeByTypeMain->slug == $typeBySlug->slug) {
                        $type = $typeByTypeMain;
                        $isTypeMain = 1;
                    } else {
                        $type = $typeBySlug;
                        $isTypeMain = null;
                    }
                } else {
                    $type = null;
                    $isTypeMain = null;
                }
            } else {
                $type = null;
                $isTypeMain = null;
            }
            self::getMetaSeoData($modelName, $modelId, $seoMeta, $meta, $type, $isTypeMain);
        }
        return $seoMeta;
    }

    public static function getMetaSeoData($modelName, $modelId, $seoMeta, $meta, $type, $isTypeMain = null)
    {
        if($modelName == 'Game' && $isTypeMain == null) {
            if($type) {
                $seoMeta->title_site = 'Chơi game '.$meta->name.' | Game '.$type->name.' | Choinhanh.vn';     
            } else {
                $seoMeta->title_site = 'Chơi game '.$meta->name.' | Choinhanh.vn';
            }
        } else {
            if($seoMeta->title_site == '') {
                $seoMeta->title_site = $meta->name;
            }
        }
        if($modelName == 'Game' && $isTypeMain == null) {
            if($type) {
                $seoMeta->description_site = 'Game '.convert_string_vi_to_en($meta->name).' - Trò chơi '.$type->name.' '.$meta->name.' chọn lọc hay mới nhất 24h tại choinhanh.vn'; 
            } else {
                $seoMeta->description_site = convert_string_vi_to_en($meta->name).' - Trò chơi game '. $meta->name.' chọn lọc hay mới nhất 24h tại choinhanh.vn'; 
            }
        } else {
            if($seoMeta->description_site == '') {
                $seoMeta->description_site = limit_text(strip_tags($meta->description), TEXTLENGH_DESCRIPTION);
            }
        }
        if($modelName == 'Game' && $isTypeMain == null) {
            $seoMeta->keyword_site = 'chơi game '.$meta->name.', tro choi '.convert_string_vi_to_en($meta->name).', game '.convert_string_vi_to_en($meta->name).' hay, '.convert_string_vi_to_en($meta->name).' 24h';
        } else {
            if($seoMeta->keyword_site == '') {
                $seoMeta->keyword_site = 'Game '.$meta->name.', trò chơi '.$meta->name.', game cho mobile hay nhất tại choinhanh.vn';
            }
        }
        if($seoMeta->title_fb == '') {
            $seoMeta->title_fb = $meta->name;
        }
        if($seoMeta->description_fb == '') {
            $seoMeta->description_fb = limit_text(strip_tags($meta->description), TEXTLENGH_DESCRIPTION);
        }
        // if($seoMeta->image_url_fb == '') {
        //     $seoMeta->image_url_fb = url(UPLOAD_GAME_AVATAR . '/' . $meta->image_url);
        // }
        return $seoMeta;
    }

    public static function uploadImg($path, $folder, $imageUrl, $imageCurrent = NULL)
    {
        $destinationPath = public_path().'/'.$path.'/'.$folder.'/';
        if(Input::hasFile($imageUrl)){
            $file = Input::file($imageUrl);
            $filename = $file->getClientOriginalName();
            $filename = changeFileNameImage($filename);
            $uploadSuccess = $file->move($destinationPath, $filename);
            return $filename;
        }
        if ($imageCurrent) {
            return $imageCurrent;
        }
    }

    public static function getTypeBySlug()
    {
        $slugType = self::getSlugTypeByUrl();
        $type = Type::findBySlug($slugType);
        if($type) {
            return $type;
        } else {
            return null;
        }
    }

    public static function getSlugTypeByUrl()
    {
        $segment1 = Request::segment(1);
        $slugType = substr($segment1, 5);
        return $slugType;
    }

    public static function getDeviceValue($device = null)
    {
        if(isset($device)) {
            $checkDevice = getDevice($device);
        } else {
            $checkDevice = getDevice();
        }
        if($checkDevice == MOBILE) {
            return IS_MOBILE;
        } else {
            return IS_NOT_MOBILE;
        }
    }

    public static function getSapoNews($news)
    {
        if(!empty($news->sapo)) {
            return $news->sapo;
        } else {
            return limit_text(strip_tags($news->description), TEXTLENGH_DESCRIPTION);
        }
    }

}