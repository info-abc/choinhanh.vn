<?php $ads = AdCommon::getAd($adPosition); ?>
@if($ads)
	<div class="clearfix center">{{ $ads->adsense }}</div>
@endif
