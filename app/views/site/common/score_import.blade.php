@if(CommonSite::isLogin())
	@if($scores = CommonGame::getGameScore($id))
		{{HTML::style('assets/css/style-import-score.css') }}
		<div class="import-charts">
			<h3>Bảng điểm</h3>
			<ul>
				@foreach($scores as $key => $value)
					<li>
						<div class="import-charts-image">
							<img alt="" src="{{ url('/assets/images/xep-hang-'.($key+1).'.jpg') }}" height="55" width="30" />
						</div>
						<div class="import-charts-text">
							<strong>
								{{ User::find($value->user_id)->user_name.User::find($value->user_id)->uname.User::find($value->user_id)->google_name }}
							</strong>
							<span>{{ $value->score }} điểm</span>
						</div>
					</li>
				@endforeach
			</ul>
		</div>
	@endif
@else

@endif
