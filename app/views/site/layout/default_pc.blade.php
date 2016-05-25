<!DOCTYPE html>
<html>
	@include('site.common.header_cronjob')
	<body>

		{{-- HTML::style('assets/css/font-awesome.min.css') --}}
		{{-- HTML::style('assets/css/bootstrap.min.css') --}}
		{{-- HTML::style('assets/css/style.css') --}}

		@include('site.common.style')

		<script src="{{ url('assets/js/jquery-2.1.4.min.js') }}"></script>
		<script src="{{ url('assets/js/bootstrap.min.js') }}"></script>
		<script src="{{ url('assets/js/dw.js') }}"></script>
		<script src="{{ url('assets/js/script.js') }}"></script>

		<div class="container">
			<div class="row">

				<div class="main">

					@include('site.common.topbar_pc_cronjob')
					@include('site.common.navbar_pc')

					@include('site.common.ad', array('adPosition' => HEADER, 'device' => 2, 'noCache' => 1))

					@yield('content')

					@include('site.common.ad', array('adPosition' => Footer, 'device' => 2, 'noCache' => 1))

				</div>

				@include('site.common.footer')

			</div>
	  	</div>

	  	<div class="glass"></div>

		@if($script = AdminSeo::where('model_name', SEO_SCRIPT)->first())
			{{ $script->footer_script }}
		@endif

		<div id="fb-root"></div>
		<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.5&appId={{ APP_ID }}";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>

	</body>
</html>