@extends('site.layout.default_mobile')

<?php 
	if(isset($typeNew)) {
		$typeNewTitle = $typeNew->name;
	} else {
		$typeNewTitle = 'Tin tức';
	}
?>

@section('title')
	{{ $title = $typeNewTitle }}
@stop

@section('content')

<div class="box">

	<?php
		$breadcrumb = array(
			['name' => $typeNewTitle, 'link' => '']
		);
	?>
	@include('site.common.breadcrumb', $breadcrumb)

	<!-- <div class="title_center">
		<h1>{{-- $typeNewTitle --}}</h1>
	</div> -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-sm-8">
			@if(count($inputListNews) > 0)
				<div class="list">
					@foreach($inputListNews as $value)
					<?php 
						if(!isset($typeNew)) {
							// $typeNew = TypeNew::find($value->type_new_id);
							$url = action('SlugController@detailData', ['tin-tuc', $value->slug]);
						} else {
							$url = action('SlugController@detailData', [$typeNew->slug, $value->slug]);
						}
					?>
					<div class="row list-item">
						<div class="col-xs-4 list-image">
							<a href="{{ $url }}">
								<img class="image_fb" src="{{ url(UPLOADIMG . '/news'.'/'. $value->id . '/' . $value->image_url) }}" />
							</a>
						</div>
						<div class="col-xs-8 list-text">
							<h2>
								<a href="{{ $url }}">
									{{ $value->title }}
								</a>
							</h2>
						</div>
					</div>
					@endforeach
				</div>
				@if($inputListNews->getTotal() >= FRONENDPAGINATE)
					@include('site.common.paginate', array('input' => $inputListNews))
				@endif
			@endif
		</div>
		<div class="col-sm-4">
			@include('site.News.boxGameRandom_cronjob', array('device' => 1))
			@include('site.News.boxGameTop_cronjob', array('device' => 1))
		</div>
	</div>
</div>

@stop