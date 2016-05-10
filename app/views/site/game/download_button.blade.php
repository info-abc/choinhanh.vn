<?php 
	$linkAndroid = $game->link_download;
	$linkIos = $game->link_download_ios;
	$linkWinphone = $game->link_download_winphone;
?>
@if($game->link_url == '')
	<div class="row">
		@if($linkAndroid != '')
			<div class="col-sm-4">
				<div class="btn-block-center">
					<a onclick="countdownload('android')" class="download download_android" target="_blank"><i class="fa fa-download"></i> Tải về phiên bản Android</a>
				</div>
			</div>
		@endif
		@if($linkIos != '')
			<div class="col-sm-4">
				<div class="btn-block-center">
					<a onclick="countdownload('ios')" class="download download_ios" target="_blank"><i class="fa fa-download"></i> Tải về phiên bản IOS</a>
				</div>
			</div>
		@endif
		@if($linkWinphone != '')
			<div class="col-sm-4">
				<div class="btn-block-center">
					<a onclick="countdownload('winphone')" class="download download_winphone" target="_blank"><i class="fa fa-download"></i> Tải về phiên bản Windowphone</a>
				</div>
			</div>
		@endif
	</div>
@else
	<div class="btn-block-center">
		<a onclick="countdownload()" class="download" target="_blank"><i class="fa fa-download"></i> Tải về</a>
	</div>
@endif

@include('site.game.scriptcountdownload', array('id' => $game->id, 'url' => url(CommonGame::getUrlDownload($game)), 'url_android' => url(CommonGame::getUrlDownload($game, 'android')), 'url_ios' => url(CommonGame::getUrlDownload($game, 'ios')), 'url_winphone' => url(CommonGame::getUrlDownload($game, 'winphone')) ))
