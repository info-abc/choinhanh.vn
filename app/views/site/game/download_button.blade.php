<?php 
	$btnCheck = 0;
	$linkAndroid = isset($game->link_download)?$game->link_download:'';
	$linkIos = isset($game->link_download_ios)?$game->link_download_ios:'';
	$linkWinphone = isset($game->link_download_winphone)?$game->link_download_winphone:'';
	if($linkAndroid != '' && $linkIos != '' && $linkWinphone != '') {
		$btnCheck = 1;
	}
	if($linkAndroid != '' && $linkIos != '' && $linkWinphone == '') {
		$btnCheck = 2;
	}
	if($linkAndroid != '' && $linkIos == '' && $linkWinphone != '') {
		$btnCheck = 3;
	}
	if($linkAndroid == '' && $linkIos != '' && $linkWinphone != '') {
		$btnCheck = 4;
	}
	if($linkAndroid != '' && $linkIos == '' && $linkWinphone == '') {
		$btnCheck = 5;
	}
	if($linkAndroid == '' && $linkIos != '' && $linkWinphone == '') {
		$btnCheck = 6;
	}
	if($linkAndroid == '' && $linkIos == '' && $linkWinphone != '') {
		$btnCheck = 7;
	}

?>
@if($game->link_url == '')
	@if($btnCheck == 1)
		<div class="row">
			<div class="col-sm-4">
				<div class="btn-block-center">
					<a onclick="countdownload('android')" class="download download_android"><i class="fa fa-download"></i> Tải về phiên bản Android</a>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="btn-block-center">
					<a onclick="countdownload('ios')" class="download download_ios"><i class="fa fa-download"></i> Tải về phiên bản IOS</a>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="btn-block-center">
					<a onclick="countdownload('winphone')" class="download download_winphone"><i class="fa fa-download"></i> Tải về phiên bản Windowphone</a>
				</div>
			</div>
		</div>
	@endif
	@if($btnCheck == 2)
		<div class="row">
			<div class="col-sm-6">
				<div class="btn-block-center">
					<a onclick="countdownload('android')" class="download download_android"><i class="fa fa-download"></i> Tải về phiên bản Android</a>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="btn-block-center">
					<a onclick="countdownload('ios')" class="download download_ios"><i class="fa fa-download"></i> Tải về phiên bản IOS</a>
				</div>
			</div>
		</div>
	@endif
	@if($btnCheck == 3)
		<div class="row">
			<div class="col-sm-6">
				<div class="btn-block-center">
					<a onclick="countdownload('android')" class="download download_android"><i class="fa fa-download"></i> Tải về phiên bản Android</a>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="btn-block-center">
					<a onclick="countdownload('winphone')" class="download download_winphone"><i class="fa fa-download"></i> Tải về phiên bản Windowphone</a>
				</div>
			</div>
		</div>
	@endif
	@if($btnCheck == 4)
		<div class="row">
			<div class="col-sm-6">
				<div class="btn-block-center">
					<a onclick="countdownload('ios')" class="download download_ios"><i class="fa fa-download"></i> Tải về phiên bản IOS</a>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="btn-block-center">
					<a onclick="countdownload('winphone')" class="download download_winphone"><i class="fa fa-download"></i> Tải về phiên bản Windowphone</a>
				</div>
			</div>
		</div>
	@endif
	@if($btnCheck == 5)
		<div class="btn-block-center">
			<a onclick="countdownload('android')" class="download download_android"><i class="fa fa-download"></i> Tải về phiên bản Android</a>
		</div>
	@endif
	@if($btnCheck == 6)
		<div class="btn-block-center">
			<a onclick="countdownload('ios')" class="download download_ios"><i class="fa fa-download"></i> Tải về phiên bản IOS</a>
		</div>
	@endif
	@if($btnCheck == 7)
		<div class="btn-block-center">
			<a onclick="countdownload('winphone')" class="download download_winphone"><i class="fa fa-download"></i> Tải về phiên bản Windowphone</a>
		</div>
	@endif
	@if($btnCheck == 0)
	<div class="btn-block-center">
		<a onclick="countdownload()" class="download"><i class="fa fa-download"></i> Tải về</a>
	</div>
	@endif
@else
	<div class="btn-block-center">
		<a onclick="countdownload()" class="download"><i class="fa fa-download"></i> Tải về</a>
	</div>
@endif

@include('site.game.scriptcountdownload', array('id' => $game->id, 'url' => url(CommonGame::getUrlDownload($game)), 'url_android' => url(CommonGame::getUrlDownload($game, 'android')), 'url_ios' => url(CommonGame::getUrlDownload($game, 'ios')), 'url_winphone' => url(CommonGame::getUrlDownload($game, 'winphone')) ))
