<?php 
	$device = isset($device)?$device:null;
	$noCache = isset($noCache)?$noCache:null;
?>
@if($adPosition == HEADER || $adPosition == Footer || $adPosition == CHILD_PAGE_RELATION)
<?php $ad = CommonSite::getAdvertise($adPosition, null, null, $device, $noCache); ?>
	@if(isset($ad))
	<div class="adsense center">
		@if($ad->adsense)
			{{ $ad->adsense }}
		@else
			@if($ad->image_link)
				<a href="{{ $ad->image_link }}">
			@endif
				<img src="{{ url(UPLOAD_ADVERTISE . '/header_footer/' . $ad->id . '/' . $ad->image_url) }}" alt="" />
			@if($ad->image_link)
				</a>
			@endif
		@endif
	</div>
	@endif
@endif
@if($adPosition == CHILD_PAGE)
<?php $ad = CommonSite::getAdvertise($adPosition, $modelName, $modelId, $device, $noCache); ?>
	@if(isset($ad))
	<div class="adsense center">
		@if($ad->adsense)
			{{ $ad->adsense }}
		@else
			@if($ad->image_link)
				<a href="{{ $ad->image_link }}">
			@endif
				<img src="{{ url(UPLOAD_ADVERTISE . '/content/' . $modelId . '/' . $ad->image_url) }}" alt="" />
			@if($ad->image_link)
				</a>
			@endif
		@endif
	</div>
	@endif
@endif
