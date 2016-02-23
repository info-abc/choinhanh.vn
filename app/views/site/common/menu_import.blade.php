<link media="all" type="text/css" rel="stylesheet" href="/assets/css/font-awesome.min.css">
<link media="all" type="text/css" rel="stylesheet" href="/assets/css/style-import-menu.css">
<style type="text/css">
	div {
	    -webkit-transform: none !important;
	}
</style>
<div class="menu-import">
	<div class="menu-button">
		<a onclick="javascript:document.getElementById('cssmenu').style.display = 'block';" class="menu_show_list"><i class="fa fa-navicon"></i></a>
	</div>
	<div id="cssmenu">
		<div class="menu-button-close" onclick="javascript:document.getElementById('cssmenu').style.display = 'none';"><i class="fa fa-times"></i></div>
		<div class="search1">
			<form action="/tim-kiem-game">
				<input type="text" name="search" value="" title="search" placeholder="Tìm kiếm game">
				<input type="submit" value="search" title="submit">
			</form>
		</div>
		<ul>
			<li>
				<a class="menu-button-home" href="/"><i class="fa fa-home"></i> <span>Trang chủ</span></a>
				<a class="menu-button-back" href="javascript:window.history.back();"><i class="fa fa-arrow-left"></i> Quay lại</a>
			</li>
			<li><a href="/ban-gai"><span>Bạn gái</span></a></li>
			<li><a href="/dua-xe"><span>Đua xe</span></a></li>
			<li><a href="/hanh-dong"><span>Hành động</span></a></li>
			<li><a href="/tri-tue"><span>Trí tuệ</span></a></li>
			<li><a href="/nau-an"><span>Nấu ăn</span></a></li>
		</ul>
		<div class="menu-hide"><a onclick="javascript:document.getElementById('cssmenu').style.display = 'none';"><i class="fa fa-times-circle-o"></i> Đóng lại</a></div>
	</div>
</div>
{{-- GA --}}
<?php
	if (Cache::has('script'.SEO_SCRIPT))
	{
	    $script = Cache::get('script'.SEO_SCRIPT);
	} else {
        $script = AdminSeo::where('model_name', SEO_SCRIPT)->first();
	    Cache::put('script'.SEO_SCRIPT, $script, CACHETIME);
	}
	if(isset($script)) {
        echo $script->header_script;
	}
?>
