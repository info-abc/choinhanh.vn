<?php 
	if(isset($typeNew)) {
		$seoMeta = CommonSite::getMetaSeo('TypeNew', $typeNew->id);
		$seoMeta = CommonSeo::pageSeoObject($seoMeta);
		$typeNewTitle = (isset($seoMeta) && !empty($seoMeta->title_site))?$seoMeta->title_site:$typeNew->name;
	} else {
		$seoMeta = new stdClass();
		$seoMeta->title_site = 'Tin tức';
		$seoMeta->description_site = '';
		$seoMeta->keyword_site = '';
		$seoMeta->title_fb = '';
		$seoMeta->description_fb = '';
		$seoMeta->image_url_fb = '';
		$seoMeta = CommonSeo::pageSeoObject($seoMeta);
		$typeNewTitle = $seoMeta->title_site;
	}
?>

@extends('site.layout.default', array('seoMeta' => $seoMeta))

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
							@if(getDevice() == COMPUTER)
								<p>{{ CommonSite::getSapoNews($value) }}</p>
							@endif
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
			@if(getDevice() == COMPUTER)
				@include('site.common.ads', array('adPosition' => POSITION_NEWS_LIST_RIGHT))
			@endif

			@include('site.News.boxGameRandom')
			@include('site.News.boxGameTop')
		</div>
	</div>
</div>

@stop