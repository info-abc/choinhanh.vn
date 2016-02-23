<h4>Bình luận</h4>
<div class="comment">
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#comment2" aria-controls="comment2" role="tab" data-toggle="tab">Facebook</a></li>
		<li role="presentation"><a href="#comment1" aria-controls="comment1" role="tab" data-toggle="tab">choinhanh.vn</a></li>
	</ul>
	@include('site.common.message_comment')
	<!-- Tab panes -->
	<div class="tab-content">

		<div role="tabpanel" class="tab-pane active" id="comment2">
			<div class="fb-comments" data-href="{{ Request::url() }}" data-numposts="5"></div>
		</div>

		<div role="tabpanel" class="tab-pane" id="comment1">
		{{ Form::open(array('action' => array('SiteCommentController@update', $game->id), 'method' => 'PUT')) }}
		<!-- comment cho game -->
		@if(Auth::user()->check() && !(Auth::user()->get()->uid))
			<div class="box-body">
				<div class="form-group">
					<label for="name">Comment choi nhanh</label>
					<div class="row">
						<div class="col-sm-12">
						    {{ Form::textarea('description', '' , array('class' => 'form-control', 'rows' => 3)) }}
						</div>
					 </div>
				</div>
			</div>
			<div class="box-footer">
				{{ Form::submit('Gửi bình luận', array('class' => 'btn btn-primary comment-button')) }}
				<div class="clearfix"></div>
			</div>
		@else
		<b>Bạn phải đăng nhập để comment!</b>
		@endif
		<!-- hiển thị comment cho game -->
		<div class="box-body ">
			<ul class="comment-list">
				@foreach($inputComment = SiteComment::getCommentGame($game) as $value)
					<?php
						if($image_url = User::find($value->user_id)->image_url) {
							$avatar = url(UPLOADIMG . UPLOAD_USER_AVATAR . '/' . $image_url);
						} else {
							$avatar = url('/assets/images/avatar.jpg');
						}
					?>
					<li>
						<div class="comment-avatar"><img src="{{ $avatar }}" /></div>
						<div class="comment-content">
							<div class="comment-user"><span>{{ User::find($value->user_id)->user_name.User::find($value->user_id)->uname.User::find($value->user_id)->google_name }}</span> đã viết vào {{ showDateTime($value->created_at) }} </div>
							<div class="comment-desc">{{ $value->description }}</div>
						</div>
					</li>
				@endforeach
			</ul>

			<a id="loadMore" class="btn btn-primary" href="javascript:void();">Xem thêm</a>
			{{-- <a id="showLess" href="javascript:void();">Show less</a> --}}
		</div>

		{{ Form::close() }}
		</div>

	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
	    size_li = $(".comment-list li").size();
	    x=5;
	    $('.comment-list li:lt('+x+')').show();
	    $('#loadMore').click(function () {
	        x= (x+5 <= size_li) ? x+5 : size_li;
	        $('.comment-list li:lt('+x+')').show();
	    });
	    // $('#showLess').click(function () {
	    //     x=(x-5<0) ? 5 : x-5;
	    //     $('.comment-list li').not(':lt('+x+')').hide();
	    // });
	});
</script>