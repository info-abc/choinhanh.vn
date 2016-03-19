@if($adPosition == HEADER || $adPosition == Footer || $adPosition == CHILD_PAGE_RELATION)
	@if($ad = CommonSite::getAdvertise($adPosition))
	<div class="adsense center">
		@if(isset($ad))
			{{ $ad->adsense }}
		@else
			@if(isset($ad))
				<a href="{{ $ad->image_link }}">
			@endif
				<img src="{{ url(UPLOAD_ADVERTISE . '/header_footer/' . $ad->id . '/' . $ad->image_url) }}" alt="" />
			@if(isset($ad))
				</a>
			@endif
		@endif
	</div>
	@endif
@endif
@if($adPosition == CHILD_PAGE)
	@if($ad = CommonSite::getAdvertise($adPosition, $modelName, $modelId))
	<div class="adsense center">
		@if(isset($ad))
			{{ $ad->adsense }}
		@else
			@if(isset($ad))
				<a href="{{ $ad->image_link }}">
			@endif
				<img src="{{ url(UPLOAD_ADVERTISE . '/content/' . $modelId . '/' . $ad->image_url) }}" alt="" />
			@if(isset($ad))
				</a>
			@endif
		@endif
	</div>
	@endif
@endif
