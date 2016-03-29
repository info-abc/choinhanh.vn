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
        // Header & Footer
        if($modelName == null && $modelId == null) {
            $ad = Advertise::where(array('position' => $position, 'status' => ENABLED))->first();
			if(isset($ad)) {
				return $ad;
			} else {
				return null;
			}
        }
        // Content
        else {
            //check Common models
            $common_model = CommonModel::where(array('model_name' => $modelName, 'model_id' => $modelId))->first();
            if (isset($common_model)) {
                $common_model_id = $common_model->id;
				$advertisement_id = AdvertisePosition::where(array('common_model_id' => $common_model_id, 'status' => ENABLED))->first();
                if(isset($advertisement_id)) {
					$ad = Advertise::find($advertisement_id->advertisement_id);
                    return $ad;
                }
                return null;
            }
            else {
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

    public static function getMetaSeo($modelName, $modelId = null)
    {
        if(!$modelId) {
            $seoMeta = AdminSeo::where('model_name', $modelName)
                    ->first();
            return $seoMeta;
        }
        $seoMeta = AdminSeo::where('model_name', $modelName)
                ->where('model_id', $modelId)
                ->first();
        if($seoMeta) {
            $meta = $modelName::find($modelId);
            if($seoMeta->title_site == '') {
                if($modelName == 'Game') {
                    $seoMeta->title_site = 'Chơi game '.$meta->name.' | Choinhanh.vn'; 
                } else {
                    $seoMeta->title_site = $meta->name;
                }
            }
            if($seoMeta->description_site == '') {
                if($modelName == 'Game') {
                    $seoMeta->description_site = convert_string_vi_to_en($meta->name).' - Trò chơi game '. $meta->name.' chọn lọc hay mới nhất 24h tại choinhanh.vn'; 
                } else {
                    $seoMeta->description_site = limit_text(strip_tags($meta->description), TEXTLENGH_DESCRIPTION);
                }
            }
            if($seoMeta->keyword_site == '') {
                if($modelName == 'Game') {
                    $seoMeta->keyword_site = 'chơi game '.$meta->name.', tro choi '.convert_string_vi_to_en($meta->name).', game '.convert_string_vi_to_en($meta->name).' hay, '.convert_string_vi_to_en($meta->name).' 24h'; 
                } else {
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
        return null;
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

}