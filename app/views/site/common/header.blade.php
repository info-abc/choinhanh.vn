<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta property="fb:app_id" content="{{ APP_ID }}"/>
	<meta property="fb:admins" content="{{ APP_ADMIN }}"/>
	<title>@yield('title')</title>

	<meta name="robots" content="noodp,index,follow" />
	<meta name='revisit-after' content='1 days' />
	<meta http-equiv="content-language" content="vi"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 

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

	{{ HTML::script('assets/js/jquery-2.1.4.min.js', array('async' => 'async')) }}
	{{ HTML::script('assets/js/bootstrap.min.js', array('async' => 'async')) }}
	{{ HTML::script('assets/js/dw.js', array('async' => 'async')) }}
	{{ HTML::script('assets/js/script.js', array('async' => 'async')) }}

	@if(isset($script))
		{{ $script->header_script }}
	@endif

</head>