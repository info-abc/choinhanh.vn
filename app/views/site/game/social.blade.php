<div class="social">
	<div class="fb-like" data-width="100" data-layout="button_count" data-share="true" data-show-faces="false" data-href="{{ Request::url() }}"></div>

	<script src="https://apis.google.com/js/platform.js" async defer></script>
	<div class="g-plus" data-action="share" data-annotation="bubble" data-height="20"></div>

	<a href="{{ action('SiteFeedbackController@errorGame', array('id' => $id)) }}" class="report-error"><i class="fa fa-warning"></i> Báo lỗi</a>
</div>