@extends('admin.layout.default')

@section('title')
{{ $title='Quản lý slider' }}
@stop

@section('content')
<div class="margin-bottom">
	{{ Form::open(array('action' => 'AdminSlideController@search', 'method' => 'GET')) }}
		<div class="input-group" style="width: 150px; display:inline-block;">
			<label>Từ khóa</label>
		  	<input type="text" name="keyword" class="form-control" placeholder="Search" />
		</div>
		<div class="input-group" style="display: inline-block; vertical-align: bottom; margin-top: 15px;">
			<input type="submit" value="Search" class="btn btn-primary" />
		</div>
	{{ Form::close() }}
</div>

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ action('AdminSlideController@create') }}" class="btn btn-primary">Thêm mới slide</a>
	</div>
</div> 
<div class="box-body table-responsive no-padding">
  	<table class="table table-hover">
	<tr>
	  	<th>ID</th>
	  	<th>Tên slide</th>
	  	<th>Auto Play</th>
	  	<th>prev/next</th>
	  	<th>Paginate</th>
	  	<th>Time</th>
	  	<th style="width:200px;">Action</th>
	</tr>
		@foreach($slides as $value)
			<tr>
			  	<td>{{ $value->id }}</td>
				<td>{{ $value->name }}</td>
				<td>{{ Slider::getStatusSliderOption($value->autoplay) }}</td>
				<td>{{ Slider::getStatusSliderOption($value->navigation) }}</td>
				<td>{{ Slider::getStatusSliderOption($value->pagination) }}</td>
				<td>{{ $value->config_time }}</td>
				<td>
				<a href="{{  action('AdminSlideController@edit', $value->id) }}" class="btn btn-primary">Sửa</a>
					{{ Form::open(array('method'=>'DELETE', 'action' => array('AdminSlideController@destroy', $value->id), 'style' => 'display: inline-block;')) }}
						<button class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</button>
					{{ Form::close() }}
			  	</td>
			</tr>
		@endforeach
  	</table>
</div>
@include('admin.common.paginate',['input' => $slides])
<div id="demo">
	<div id="owl-demo" class="owl-carousel">
		<div class="item"><img src="{{ url('demo_slider/fullimage1.jpg') }}" alt="The Last of us"></div>
		<div class="item"><img src="{{ url('demo_slider/fullimage2.jpg') }}" alt="The Last of us"></div>
		<div class="item"><img src="{{ url('demo_slider/fullimage3.jpg') }}" alt="The Last of us"></div>
	</div>
</div>
  {{ HTML::script('assets/js/owl.carousel.js') }}
  {{ HTML::style('assets/css/owl.carousel.css') }}
  {{ HTML::style('assets/css/owl.theme.css') }}
	<!-- Demo -->
	<style>
	#owl-demo .item img{
		display: block;
		width: 100%;
		height: auto;
	}
	</style>
	<script>
	$(document).ready(function() {
	  $("#owl-demo").owlCarousel({
	  navigation : true,
	  slideSpeed : 100,
	  autoPlay: true,
	  paginationSpeed : 100,
	  pagination: true,
	  singleItem : true,

	  // "singleItem:true" is a shortcut for:
	  // items : 1, 
	  // itemsDesktop : false,
	  // itemsDesktopSmall : false,
	  // itemsTablet: false,
	  // itemsMobile : false

	  });
	});
	</script>
  @stop
