@if($slide = AdminSlide::find($slideId))
	{{ HTML::script('assets/js/owl.carousel.js') }}
	{{ HTML::style('assets/css/owl.carousel.css') }}
	{{ HTML::style('assets/css/owl.theme.css') }}
	<!-- Demo -->
	<style>
		#owl-demo .itemslide img {
			text-align: center;
			display: block;
			max-width: 100% !important;
			height: auto;
			margin: 0 auto;
		}
	</style>
	<script>
		var time = @if($slide->config_time){{ $slide->config_time * 100 }}@endif;
		var navigation = @if($slide->navigation == ENABLED){{ 'true' }}@else{{ 'false' }}@endif;
		var autoplay = @if($slide->autoplay == ENABLED){{ 'true' }}@else{{ 'false' }}@endif;
		var pagination = @if($slide->pagination == ENABLED){{ 'true' }}@else{{ 'false' }}@endif;
		$(document).ready(function() {
			$("#owl-demo").owlCarousel({
				navigation : navigation,
				slideSpeed : time,
				autoPlay: autoplay,
				paginationSpeed : time,
				pagination: pagination,
				singleItem : true,
			});
		});
	</script>
	<div id="demo">
		<div id="owl-demo" class="owl-carousel">
			@foreach($slide->images as $image)
				<div class="itemslide"><img src="{{ url(UPLOAD_IMAGE_SLIDE . '/image'. '/' . $slideId . '/' . $image->image_url) }}" alt="{{ getFilename($image->image_url) }}"></div>
			@endforeach
		</div>
	</div>
@endif