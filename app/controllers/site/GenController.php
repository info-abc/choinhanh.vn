<?php 

class GenController extends SiteController {

	public function exportIndexHtml()
	{
		$html = View::make('site.index');
		if(getDevice() == MOBILE) {
			$filePath = public_path().FOLDER_HTML_CODE.'/index_mobile.html';
		} else {
			$filePath = public_path().FOLDER_HTML_CODE.'/index_pc.html';
		}
		// chmod($filePath, 0777);
		file_put_contents($filePath, $html);
		dd(1);
		// return Redirect::to($_SERVER['HTTP_REFERER']);
	}

}
