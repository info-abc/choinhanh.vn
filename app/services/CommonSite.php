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
    public static function getAdvertise($position, $modelName = null, $modelId = null)
    {
        $ad = null;
        // Header & Footer
        if($modelName == null && $modelId == null) {

            if (Cache::has('getAdvertise_'.$position))
            {
                $ad = Cache::get('getAdvertise_'.$position);
            } else {
                $ad = Advertise::where(array('position' => $position, 'status' => ENABLED))->first();
                Cache::put('getAdvertise_'.$position, $ad, CACHETIME);
            }
			if(isset($ad)) {
				return $ad;
			} else {
				return null;
			}
        }
        // Content
        else {
            if (Cache::has('getAdvertise_'.$modelName.'_'.$modelId))
            {
                $ad = Cache::get('getAdvertise_'.$modelName.'_'.$modelId);
            } else {

                //check Common models
                $common_model = CommonModel::where(array('model_name' => $modelName, 'model_id' => $modelId))->first();
                if (isset($common_model)) {
                    $common_model_id = $common_model->id;
    				$advertisement_id = AdvertisePosition::where(array('common_model_id' => $common_model_id, 'status' => ENABLED))->first();
                    if(isset($advertisement_id)) {
    					$ad = Advertise::find($advertisement_id->advertisement_id);
                    }
                }
                Cache::put('getAdvertise_'.$modelName.'_'.$modelId, $ad, CACHETIME);
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

    public static function getMetaSeo($modelName, $modelId = '')
    {
        $seoMeta = null;
        //seo trang chu - CACHE
        if(!$modelId) {
            if (Cache::has('getMetaSeo_'.$modelName.'_home'))
            {
                $seoMeta = Cache::get('getMetaSeo_'.$modelName.'_home');
            } else {
                $seoMeta = AdminSeo::where('model_name', $modelName)
                        ->first();
                Cache::put('getMetaSeo_'.$modelName.'_home', $seoMeta, CACHETIME);
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
                    } else {
                        $type = $typeBySlug;
                    }
                } else {
                    $type = null;
                }
            } else {
                $type = null;
            }
            self::getMetaSeoData($modelName, $modelId, $seoMeta, $meta, $type);
        }
        return $seoMeta;
    }

    public static function getMetaSeoData($modelName, $modelId, $seoMeta, $meta, $type)
    {
        if($modelName == 'Game') {
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
        if($modelName == 'Game') {
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
        if($modelName == 'Game') {
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

}