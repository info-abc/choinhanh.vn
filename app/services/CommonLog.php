<?php
use Carbon\Carbon;
class CommonLog
{
	public static function insertHistory($model_name, $model_id)
	{
		$input = array();
		$input['model_name'] = $model_name;
		$input['model_id'] = $model_id;
		$input['last_time'] = $model_name::find($model_id)->created_at;
		$input['device'] = getDevice();
		$input['last_ip'] = getIpAddress();
		$history_id = CommonNormal::create($input, 'history');
		return $history_id;
	}

	public static function updateHistory($model_name, $model_id)
	{
		$history = AdminHistory::where(array('model_name' => $model_name, 'model_id' => $model_id))->first();
		if(!$history) {
			return self::insertHistory($model_name, $model_id);
		}
		$id = $history->id;
		$input = array();
		$input['model_name'] = $model_name;
		$input['model_id'] = $model_id;
		$input['last_time'] = Carbon::now();
		$input['device'] = getDevice();
		$input['last_ip'] = getIpAddress();
		CommonNormal::update($id, $input, 'AdminHistory');
		return $id;
	}

	public static function insertLogEdit($model_name, $model_id, $history_id, $action)
	{
		$input = array();
		$input['history_id'] = $history_id;
		$input['editor_id'] = Auth::admin()->get()->id;
		$input['editor_name'] = Auth::admin()->get()->username;
		$input['editor_time'] = $model_name::find($model_id)->updated_at;
		$input['editor_ip'] = getIpAddress();
		$input['action'] = $action;
		CommonNormal::create($input, 'log_edit');
	}

	public static function getIdHistory($modelName, $modelId)
	{
		$history = AdminHistory::where('model_name', $modelName)->where('model_id', $modelId)->first();
		if ($history) {
			return $history->id;
		}
		return null;
	}

	public static function logErrors($type)
	{
		$link = Request::url();
		if(strpos($link, '/index.php/') && Request::isMethod('get')) {
			return Redirect::action('SiteController@returnPage404');
		}
		$agent = $_SERVER['HTTP_USER_AGENT'];
		$referer = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
		$error = AdminError::where('link', $link)->first();
		if($error) {
			$count = $error->count + 1;
			AdminError::find($error->id)->update(array('count' => $count));
			AdminErrorLog::create(array('error_id' => $error->id, 'agent' => $agent, 'referer' => $referer));
		} else {
			$input = array(
				'link' => $link,
				'type' => $type,
				'count' => 1,
			);
			$errorId = CommonNormal::create($input, 'AdminError');
			AdminErrorLog::create(array('error_id' => $errorId, 'agent' => $agent, 'referer' => $referer));
		}
		if(Request::isMethod('get')) {
			return Redirect::action('SiteController@returnPage404');
		} else {
			return;
		}
	}

	public static function getTypeError($typeId)
	{
		if($typeId == ERROR_TYPE_404) {
			return 'Lỗi 404';
		}
		return 'Lỗi game';
	}

	public static function searchError($input)
	{
		$data = AdminError::join('error_logs', 'error_logs.error_id', '=', 'errors.id')
			->select('errors.*')
			->where(function ($query) use ($input)
		{
			if ($input['link'] != '') {
				$query = $query->where('errors.link', 'like', '%'.$input['link'].'%');
 		    }
			if ($input['type'] != '') {
				$query = $query->where('errors.type', $input['type']);
			}
			if ($input['url'] != '') {
				$query = $query->where('errors.link', 'like', '%'.$input['url'].'%');
 		    } else {
 		    	$query = $query->where('errors.link', 'like', '%'.$input['url'].'%');
				$query = $query->where('errors.link', 'not like', '%'.CHOINHANH.'%');
 		    }
			if($input['start_date'] != '') {
				$query = $query->where('errors.created_at', '>=', $input['start_date']);
			}
			if($input['end_date'] != '') {
				$query = $query->where('errors.created_at', '<=', $input['end_date']);
			}
			if ($input['agent'] != '') {
				$query = $query->where('error_logs.agent', 'like', '%'.$input['agent'].'%');
 		    }

		})->groupBy('errors.id')->orderBy('errors.count', 'desc')->paginate(PAGINATE);
		return $data;
	}

}
