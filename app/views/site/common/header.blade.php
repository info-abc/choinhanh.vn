<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta property="fb:app_id" content="{{ APP_ID }}"/>
	<meta property="fb:admins" content="{{ APP_ADMIN }}"/>
	<title>@yield('title')</title>

	@if(isset($page404))
		<meta name="robots" content="noindex, nofollow" />
		<link rel="canonical" href="{{ action('SiteController@returnPage404') }}" />
		<meta name="description" content="Trang bạn xem không tồn tại, vui lòng quay trở lại trang chủ Chơi nhanh để tìm kiếm game mới hay nhất" />
	@else
		<meta name="robots" content="noodp,index,follow" />
	@endif
	<meta name='revisit-after' content='1 days' />
	<meta http-equiv="content-language" content="vi"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 

	@if(isset($gameUrl))
	<link rel="canonical" href="{{ $gameUrl }}" />
	@endif

	@if(!empty(Request::segment(1)) && Request::segment(1) == 'home')
	<link rel="canonical" href="http://choinhanh.vn" />
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

	{{ HTML::style('assets/css/font-awesome.min.css') }}
	{{ HTML::style('assets/css/bootstrap.min.css') }}
	{{ HTML::style('assets/css/style.css') }}

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<script src="{{ url('assets/js/jquery-2.1.4.min.js') }}"></script>
	<script src="{{ url('assets/js/bootstrap.min.js') }}"></script>
	<script src="{{ url('assets/js/dw.js') }}"></script>
	<script src="{{ url('assets/js/script.js') }}"></script>

	@if(isset($script))
		{{ $script->header_script }}
	@endif

</head>