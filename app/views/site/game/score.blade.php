@if(CommonSite::isLogin())
<?php
	if($image_url = Auth::user()->get()->image_url) {
		$avatar = url(UPLOADIMG . UPLOAD_USER_AVATAR . '/' . $image_url);
	} else {
		$avatar = url('/assets/images/avatar.jpg');
	}
?>
	@if($scores = CommonGame::getGameScore($id))
		<div class="charts">
			<h3>TOP Cao thủ</h3>
			<ul>
				@foreach($scores as $key => $value)
					<li>
						<div class="charts-image">
							<img alt="" src="{{ $avatar }}" height="40" width="40" />
						</div>
						<div class="charts-text">
							<strong>
								{{ User::find($value->user_id)->user_name.User::find($value->user_id)->uname.User::find($value->user_id)->google_name }}
							</strong>
							<span>{{ $value->score }} điểm</span>
						</div>
						<div class="charts-medal">
							<img alt="" src="{{ url('/assets/images/xep-hang-'.($key+1).'.jpg') }}" height="55" width="30" />
						</div>
						<div class="clearfix"></div>
					</li>
				@endforeach
			</ul>
		</div>
	@endif
@else

@endif
