<?php

use Jenssegers\Agent\Agent;

/* mm/dd/yyyy to Y-m-d H:i:s */
function convertDateTime($dateString, $paramString = '/')
{
	return $dateString . ' 00:00:00';
	// $array = explode($paramString,$dateString);
	// $datetime = $array[2].'-'.$array[0].'-'.$array[1].' 00:00:00';
	// return $datetime;
}
function getRole($roleId) {
	$role = array(
		ADMIN => 'ADMIN',
		EDITOR => 'EDITOR',
		SEO => 'SEO',
	);
	return $role[$roleId];
}

function selectRoleId()
{
	return array(
		'' => '-- Lựa chọn',
		ADMIN => 'ADMIN',
		EDITOR => 'EDITOR',
		SEO => 'SEO',
	);
}

function selectParentCategory()
{
	return array(
		MENU => 'Trên Menu',
		CONTENT => 'Dưới content',
	);
}

function selectRelationType()
{
	return array(
		MENU_RELATION => 'Menu',
		CONTENT_RELATION => 'Content',
		TYPE_RELATION => 'Type',
	);
}
function selectEditRelationType($input, $modelName, $modelId)
{
	if($input->$modelName == CATEGORYPARENT) {
		$position = CategoryParent::find($input->$modelId)->position;
		if ($position == MENU) {
			return MENU_RELATION;
		}
		if ($position == CONTENT) {
			return CONTENT_RELATION;
		}
	}
	return TYPE_RELATION;
}
function selectType_Policy(){
	return array(
		POLICY => 'Chính sách', 
		//cuongnt tạm thời ẩn phần này
		//ABOUT_POLICY => 'Giới thiệu', 
		);
}
function getType_Policy($id){
	$policyarr = array(
		POLICY => 'Chính sách', 
		ABOUT_POLICY => 'Giới thiệu', 
		);
	return $policyarr[$id];
}

function orderByScore(){
	return array(
				'' => '--chọn',
				'score_asc' => 'Điểm tăng dần',
				'score_desc' => 'Điểm giảm dần',
			);
}

function getModelNameRelation($modelName)
{
	if (Input::get($modelName) == MENU_RELATION || Input::get($modelName) == CONTENT_RELATION) {
		return 'CategoryParent';
	}
	return 'Type';
}


function textParentCategory($input, $isSeoMeta = NULL, $id = NULL)
{
	if(!Admin::isSeo() || $isSeoMeta) {
		return array('placeholder' => $input, 'class' => 'form-control','id' => $id);
	} else {
		return array('placeholder' => $input, 'class' => 'form-control', 'readonly' => true,'id' => $id);
	}
}

function returnList($className)
{
	$list = $className::lists('name', 'id');
	return $list;
}

function getWeightNumberType($typeId, $parentId)
{
	$weightNumber = ParentType::where('type_id', $typeId)->where('category_parent_id', $parentId)->first();
	if ($weightNumber) {
		return $weightNumber->weight_number;
	}
	return NULL;
}
function checkBoxChecked($typeId, $parentId)
{
	$check = getWeightNumberType($typeId, $parentId);
	if (isset($check)) {
		return 'checked';
	}
	return NULL;
}

function saveScore()
{
	return array(
			UNSAVESCORE => 'Không lưu điểm',
			SAVESCORE => 'Lưu điểm',
		);
}

function checkBoxGame($gameId, $parentId)
{
	$check = GameRelation::where('game_id', $gameId)
						->where('category_parent_id', $parentId)
						->first();
	if (isset($check)) {
		return 'checked';
	}
	return NULL;
}

function countType($parentId)
{
	return count(ParentType::where('category_parent_id', $parentId)->get());
}

function countParentGame($parentId)
{
	$category =  GameRelation::where('category_parent_id', $parentId)->first();
	if ($category) {
		$gameId = $category->game_id;
		$games = Game::where('parent_id', $gameId)->get();
		return count($games);
	}
	return NO_GAME;
}

function countCategoryGame($categoryId)
{
	return count(Game::where('parent_id', $categoryId)->get());
}

function countCategoryView($categoryId)
{
	return Game::where('parent_id', $categoryId)->sum('count_view');
}
function countCategoryDownload($categoryId)
{
	return Game::where('parent_id', $categoryId)->sum('count_download');
}

function countBoxGame($categoryParentId)
{
	$categoryParent = GameRelation::where('category_parent_id', $categoryParentId)->first();
	if ($categoryParent) {
		$game = Game::where('parent_id', $categoryParent->game_id)->count();
		return $game;
	}
	return 0;
}

function countBoxPlay($categoryParentId)
{
	$categoryParent = GameRelation::where('category_parent_id', $categoryParentId)->first();
	if ($categoryParent) {
		$game = Game::where('parent_id', $categoryParent->game_id)->sum('count_play');
		return $game;
	}
	return 0;
}

function countBoxView($categoryParentId)
{
	$categoryParent = GameRelation::where('category_parent_id', $categoryParentId)->first();
	if ($categoryParent) {
		$game = Game::where('parent_id', $categoryParent->game_id)->sum('count_view');
		return $game;
	}
	return 0;
}
function countBoxDowload($categoryParentId)
{
	$categoryParent = GameRelation::where('category_parent_id', $categoryParentId)->first();
	if ($categoryParent) {
		$game = Game::where('parent_id', $categoryParent->game_id)->sum('count_download');
		return $game;
	}
	return 0;
}

function countTypeView($typeId, $parent_id = '')
{
	$input  = GameType::where('type_id', $typeId)->lists('game_id');
	$countview = Game::whereIn('id', $input);
	if($parent_id)
		$countview = $countview->where('parent_id', $parent_id);
	$countview = $countview->sum('count_view');
	if($countview)
		return $countview;
	return 0;
}
function countTypePlay($typeId, $parent_id = '')
{
	$input  = GameType::where('type_id', $typeId)->lists('game_id');
	$countview = Game::whereIn('id', $input);
	if($parent_id)
		$countview = $countview->where('parent_id', $parent_id);
	$countview = $countview->sum('count_play');
	if($countview)
		return $countview;
	return 0;
}
function countTypeDownload($typeId, $parent_id = '')
{
	$input  = GameType::where('type_id', $typeId)->lists('game_id');
	$countview = Game::whereIn('id', $input);
	if($parent_id)
		$countview = $countview->where('parent_id', $parent_id);
	$countview = $countview->sum('count_download');
	if($countview)
		return $countview;
	return 0;
}

function getDevice()
{
	//agent check tablet mobile desktop
	$agent = new Agent();
	if($agent->isMobile() || $agent->isTablet()) {
		return MOBILE;
	} else {
		return COMPUTER;
	}

	// $useragent = $_SERVER['HTTP_USER_AGENT'];
	// if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
	// {
	// 	return MOBILE;
	// }
	// return COMPUTER;
}

function getIpAddress()
{
	$ip = $_SERVER['REMOTE_ADDR'];
	return $ip;
}

//add time to filename
function changeFileNameImage($filename)
{
	$file = getFilename($filename);
	$str = strtotime(date('Y-m-d H:i:s'));
	$fileNameAfter = $file. '-' . $str;
	$extension = getExtension($filename);
	return $fileNameAfter.'.'.$extension;
}

function checkedGameType($typeId, $gameId)
{
	$check = GameType::where('game_id', $gameId)
						->where('type_id', $typeId)
						->first();
	if ($check) {
		return 'checked';
	}
	return NULL;
}

function selectSortBy($sortBy)
{
	switch ($sortBy) {
		case 'count_view':
			return array(
				'' => '-- chọn',
				'count_view_asc' => 'Lượt xem tăng dần',
				'count_view_desc' => 'Lượt xem giảm dần',
			);
			break;
		case 'count_play':
			return array(
				'' => '-- chọn',
				'count_play_asc' => 'Lượt chơi tăng dần',
				'count_play_desc' => 'Lượt chơi giảm dần',
			);
			break;
		case 'count_vote':
			return array(
				'' => '-- chọn',
				'count_vote_asc' => 'Lượt vote tăng dần',
				'count_vote_desc' => 'Lượt vote giảm dần',
			);
			break;
		case 'count_download':
			return array(
				'' => '-- chọn',
				'count_download_asc' => 'Lượt tải tăng dần',
				'count_download_desc' => 'Lượt tải giảm dần',
			);
		case 'weight_number':
			return array(
				'' => '-- chọn',
				'weight_number_asc' => 'Trọng số tăng dần',
				'weight_number_desc' => 'Trọng số giảm dần',
			);
			break;
		default:
			# code...
			break;
	}
}

function selectStatusGame()
{
	return array(
		ENABLED => 'Đã đăng',
		DISABLED => 'Chưa đăng'
	);
}
function selectWeight_number()
{
	return array(
		1 => '1',
		2 => '2',
		3 => '3',
		4 => '4',
		5 => '5',
		);

}
//get status game
function getStatusGame($status) {
	$statusGame = array(
		ENABLED => 'Đã đăng',
		DISABLED => 'Chưa đăng'
	);
	return $statusGame[$status];
}

function getNameDevice($deviceId)
{
	if ($deviceId == MOBILE) {
		return SMART_DEVICE;
	}
	if ($deviceId == COMPUTER) {
		return COMPUTER_DEVICE;
	}
}

function getPositionAdvertise($position)
{
	if ($position == HEADER) {
		return 'Header';
	}
	if ($position == Footer) {
		return 'Footer';
	}
	if ($position == CHILD_PAGE) {
		return 'Content';
	}
	if ($position == CHILD_PAGE_RELATION) {
		return 'Content';
	}
}
function getStatusAdvertise($status)
{
	if ($status == ENABLED) {
		return 'Hiển thị';
	}
	if ($status == DISABLED) {
		return 'Ẩn';
	}
}
function getNameParentFromCommonModel($id)
{	
	$parentId = CommonModel::find($id)->model_id;
	$name = CategoryParent::find($parentId)->name;
	return $name;
}
function getNameBoxEnable()
{
	return CategoryParent::where('position',CONTENT)->lists('name', 'id');
}
function selectArrange()
{
	return array(
			HOT => 'Hot',
			GAME_PLAY => 'Chơi nhiều',
			GAME_VOTE => 'Bình chọn nhiều',
			GAME_VIEW => 'Xem nhiều',
			GAME_DOWNLOAD => 'Tải nhiều',
			GAME_NEWEST => 'Mới nhất',
		);
}

function getArrange($arrange)
{
	$arrangeArray = array(
			HOT => 'count_play',
			GAME_PLAY => 'count_play',
			GAME_VOTE => 'count_vote',
			GAME_VIEW => 'count_view',
			GAME_DOWNLOAD => 'count_download',
			GAME_NEWEST => 'start_date',
			'' => 'id',
		);
	return $arrangeArray[$arrange];
}

function checkedGameTypeMain($typeId, $gameTypeMain)
{
	if ($typeId == $gameTypeMain) {
		return 'checked';
	}
	return NULL;
}
//get category
function getListCategory()
{
	return Game::whereNull('parent_id')->lists( 'name','id');
}
// show 0 for null
function getZero($number = null)
{
	if($number != '') {
		return $number;
	}
	return 0;
}
//get extension from filename
function getExtension($filename = null)
{
	if($filename != '') {
		return pathinfo($filename, PATHINFO_EXTENSION);
	}
	return null;
}
//get filename from filename
function getFilename($filename = null)
{
	if($filename != '') {
		return pathinfo($filename, PATHINFO_FILENAME);
	}
	return null;
}
//cut trim text
function limit_text($text, $len) {
    if (strlen($text) < $len) {
        return $text;
    }
    $text_words = explode(' ', $text);
    $out = null;
    foreach ($text_words as $word) {
        if ((strlen($word) > $len) && $out == null) {

            return substr($word, 0, $len) . "...";
        }
        if ((strlen($out) + strlen($word)) > $len) {
            return $out . "...";
        }
        $out.=" " . $word;
    }
    return $out;
}
//check file exist
function remoteFileExists($url) {
    $curl = curl_init($url);

    //don't fetch the actual page, you only want to check the connection is ok
    curl_setopt($curl, CURLOPT_NOBODY, true);

    //do request
    $result = curl_exec($curl);

    $ret = false;

    //if request did not fail
    if ($result !== false) {
        //if request was ok, check response code
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($statusCode == 200) {
            $ret = true;
        }
    }

    curl_close($curl);

    return $ret;
}

function checkActive($uri = '')
{
	$segment = Request::segment(1);
	if ($segment == $uri) {
		return 'class = "active"';
	}
	return;
}
//kich hoat or chua kich hoat
function checkActiveUser($status)
{
	if($status == ACTIVE)
		return ACTIVEUSER;
	else 
		return INACTIVEUSER;	
}
// đã duyệt or chưa duyệt
function checkApproveOrReject($status)
{
	if($status == ACTIVE)
		return 'Đã duyệt';
	else 
		return 'Chưa duyệt';	
}
function selectActive()
{
	return array(
		ACTIVE => ACTIVEUSER,
		INACTIVE => INACTIVEUSER,
	);
}
/* Y-m-d H:i:s to d-m-Y H:i:s */
function showDateTime($dateString = null)
{
	if($dateString == null) {
		return false;
	}
	$array = explode(' ', $dateString);
	$dmY = explode('-', $array[0]);
	$His = explode(':', $array[1]);
	$datetime = $dmY[2].'-'.$dmY[1].'-'.$dmY[0].' '.$His[0].':'.$His[1];
	return $datetime;
}

function getStatusSeoParent($input, $model_name){
	$seo = AdminSeo::where('model_name', $model_name)
		->where('model_id', $input->id)
		->first();
		return checkActiveUser($seo->status_seo);

}

function getCount($count)
{
	if($count < 5) {
		return $count;
	}
	return 5;
}

function selectScreenGame()
{
	return array(
		GAME_HORIZONTAL => 'Ngang',
		GAME_VERTICAL => 'Dọc',
	);
}

function convert_string_vi_to_en($str){
    $unicode = array(
        'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
        'd'=>'đ',
        'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        'i'=>'í|ì|ỉ|ĩ|ị',
        'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
        'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'D'=>'Đ',
        'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
        'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
    );
    foreach($unicode as $nonUnicode=>$uni){
        $str = preg_replace("/($uni)/i", $nonUnicode, $str);
    }
    return $str;
}
