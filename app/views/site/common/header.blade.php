<head>
	<?php
		@header("Cache-Control: no-cache, must-revalidate");
		// $offset = 60 * 60 * 24 * 3;
		$offset = 60 * CACHETIME;
		$ExpStr = "Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
		@header($ExpStr);
		if(isset($page404)) {
			@header('HTTP/1.0 404 Not Found');
			@header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
			@header("Status: 404 Not Found");
			$_SERVER['REDIRECT_STATUS'] = 404;
		}
	?>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta property="fb:app_id" content="{{ APP_ID }}"/>
	<meta property="fb:admins" content="{{ APP_ADMIN }}"/>
	<title>@yield('title')</title>

	@if(isset($page404))
		<?php
			@header("HTTP/1.0 404 Not Found");
		?>
		<meta name="robots" content="noindex, nofollow" />
		<link rel="canonical" href="{{ action('SiteController@returnPage404') }}" />
		<meta name="description" content="Trang bạn xem không tồn tại, vui lòng quay trở lại trang chủ Chơi nhanh để tìm kiếm game mới hay nhất" />
	@else
		<meta name="robots" content="noodp,index,follow" />
	@endif
	<meta name="revisit-after" content="1 days" />
	<meta http-equiv="content-language" content="vi" />
	<meta name="language" content="vietnamese" />
	<meta name="distribution" content="global">

	@if(isset($gameUrl))
	<link rel="canonical" href="{{ $gameUrl }}" />
	@endif

	@if(!empty(Request::segment(1)) && Request::segment(1) == 'home')
	<link rel="canonical" href="http://choinhanh.vn" />
	@endif

	@if(isset($canonical))
	<link rel="canonical" href="{{ $canonical }}" />
	@endif

	@if(isset($seoMeta))
		<meta name="description" content="{{ html_entity_decode($seoMeta->description_site) }}">
		<meta name="keywords" content="{{ $seoMeta->keyword_site }}">
		<meta name="title" content="{{ $seoMeta->title_site }}">

		<meta property="og:url" content="{{ Request::url() }}" />
		<meta property="og:title" content="{{ $seoMeta->title_fb }}" />
		<meta property="og:description" content="{{ html_entity_decode($seoMeta->description_fb) }}" />
		@if(isset($seoImage))
			@if($seoMeta->image_url_fb)
				<meta property="og:image" content="{{ url(UPLOADIMG . '/' . $seoImage . '/' . $seoMeta->image_url_fb) }}" />
			@else
				<meta property="og:image" content="{{ url(UPLOADIMG . '/avatar-game.jpg') }}" />
			@endif
		@else
			<meta property="og:image" content="{{ url(UPLOADIMG . '/avatar-game.jpg') }}" />
		@endif
	@endif
	
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	@if(isset($script))
		{{ $script->header_script }}
	@endif

</head>