@if($game->link_url == '')
	<div class="row">
		<div class="col-sm-4">
			@if($game->link_download != '')
				<div class="btn-block-center">
					<a onclick="countdownload('android')" class="download download_android" target="_blank"><i class="fa fa-download"></i> Tải về phiên bản Android</a>
				</div>
			@endif
		</div>
		<div class="col-sm-4">
			@if($game->link_download_ios != '')
				<div class="btn-block-center">
					<a onclick="countdownload('ios')" class="download download_ios" target="_blank"><i class="fa fa-download"></i> Tải về phiên bản IOS</a>
				</div>
			@endif
		</div>
		<div class="col-sm-4">
			@if($game->link_download_winphone != '')
				<div class="btn-block-center">
					<a onclick="countdownload('winphone')" class="download download_winphone" target="_blank"><i class="fa fa-download"></i> Tải về phiên bản Windowphone</a>
				</div>
			@endif
		</div>
	</div>
@else
	<div class="btn-block-center">
		<a onclick="countdownload()" class="download" target="_blank"><i class="fa fa-download"></i> Tải về</a>
	</div>
@endif

@include('site.game.scriptcountdownload', array('id' => $game->id, 'url' => url(CommonGame::getUrlDownload($game)), 'url_android' => url(CommonGame::getUrlDownload($game, 'android')), 'url_ios' => url(CommonGame::getUrlDownload($game, 'ios')), 'url_winphone' => url(CommonGame::getUrlDownload($game, 'winphone')) ))
