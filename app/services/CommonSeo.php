<?php
use Carbon\Carbon;
class CommonSeo
{
	public static function createSeo($modelName, $modelId, $uploadFolder)
	{
		$input = self::getInputSeo();
		$input['image_url_fb'] = CommonSeo::uploadImage($modelId, UPLOADIMG, 'image_url_fb', $uploadFolder);
		$input['model_name'] = $modelName;
		$input['model_id'] = $modelId;
		$id = AdminSeo::create($input)->id;
		return $id;
	}
	public static function updateSeo($modelName, $modelId, $uploadFolder)
	{
		$input = self::getInputSeo();
		$imageSeo = CommonSeo::getImageSeoUrl($modelName, $modelId);

		$input['image_url_fb']= CommonSeo::uploadImage($modelId, UPLOADIMG, 'image_url_fb', $uploadFolder, $imageSeo);
		$seo = self::getIdSeo($modelId, $modelName);
		if (!$seo) {
			$id = self::createSeo($modelName, $modelId, $uploadFolder);
			return $id;
		}
		AdminSeo::find($seo->id)->update($input);
	}

	public static function deleteSeo($modelId, $modelName)
	{
		$seo = self::getIdSeo($modelId, $modelName);
		AdminSeo::find($seo->id)->delete();
	}

	public static function getIdSeo($modelId, $modelName)
	{
		return $seo = AdminSeo::where('model_name', $modelName)
						->where('model_id', $modelId)->first();
	}
	/**
	*uploadImage Upload image
	*/

	public static function uploadImage($id, $path, $imageUrl, $folder, $imageSeo = NULL)
	{
		$destinationPath = public_path().'/'.$path.'/'.$folder.'/'.$id.'/';
		if(Input::hasFile($imageUrl)){
			$file = Input::file($imageUrl);
			$filename = $file->getClientOriginalName();
			$uploadSuccess = $file->move($destinationPath, $filename);
			return $filename;
		}
		if ($imageSeo) {
			return $imageSeo;
		}
	}

	public static function getImageSeoUrl($modelName, $modelId)
	{
		$inputSeoImage = AdminSeo::where('model_name',$modelName)
									->where('model_id', $modelId)
									->first();
		if ($inputSeoImage) {
			return $inputSeoImage->image_url_fb;
		}
		
		return NULL;
	}

	public static function getInputSeo()
	{
		$input = Input::only(
				'title_site',
				'description_site',
				'keyword_site',
				'title_fb',
				'description_fb',
				'image_url_fb',
				'header_script',
				'status_seo'
			);
		return $input;
	}

}