@if($breadcrumb)
<div class="breadcrumb">
	<ul>
		<li><a href="{{ url('/') }}">Trang chủ</a><i class="fa fa-caret-right"></i></li>
		@foreach($breadcrumb as $value)
			@if($value['link'])
				<li>
					<a href="{{ url($value['link']) }}">{{ $value['name'] }}</a><i class="fa fa-caret-right"></i>
				</li>
			@else
				<li>
					{{ $value['name'] }}
				</li>
			@endif
		@endforeach
	</ul>
</div>
@endif