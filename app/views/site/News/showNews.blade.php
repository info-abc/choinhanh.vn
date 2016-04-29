@extends('site.layout.default', array('seoMeta' => CommonSite::getMetaSeo('AdminNew', $inputNew->id), 'seoImage' => FOLDER_SEO_NEWS . '/' . $inputNew->id))

@section('title')
	@if($title = CommonSite::getMetaSeo('AdminNew', $inputNew->id)->title_site)
		{{ $title = $title }}
	@else
		{{ $title = $inputNew->title }}
	@endif
@stop

@section('content')

<div class="box">
	<?php
		$breadcrumb = array(
			['name' => 'Tin tức', 'link' => action('SiteNewsController@index')],
			['name' => $inputNew->title, 'link' => '']
		);
	?>
	@include('site.common.breadcrumb', $breadcrumb)

	<div class="title_left">
		<h1>{{ $inputNew->title }}</h1>
	</div>
	<div class="clearfix"></div>

	

	<div class="row">
		<div class="col-sm-8">

			@if($inputNew->sapo != '')
				<p class="sapo">{{ $inputNew->sapo }}</p>
			@endif

			@if(getDevice() == COMPUTER)
				@include('site.common.ads', array('adPosition' => POSITION_NEWS_SAPO))
			@else
				@include('site.common.ads', array('adPosition' => POSITION_MOBILE_NEWS_SAPO))
			@endif

			<div class="detail">
				{{ $inputNew->description }}
			</div>
			<div class="clearfix"></div>
			@if($inputRelated)
			<div class="related">
				<h3>Tin liên quan</h3>
				<ul>
					@foreach($inputRelated as $value)
					<li><a href="{{ action('SiteNewsController@show', $value->slug) }}" title=""><i class="fa fa-caret-right"></i> [{{ $value->typeNew->name }}] {{ $value->title }}</a></li>
					@endforeach
				</ul>
			</div>
			@endif
		</div>
		<div class="col-sm-4">
			@if($inputHot)
			<div class="related">
				<h3>Tin đáng đọc</h3>
				<ul>
					@foreach($inputHot as $value)
					<li><a href="{{ action('SiteNewsController@show', $value->slug) }}" title=""><i class="fa fa-caret-right"></i> [{{ $value->typeNew->name }}] {{ $value->title }}</a></li>
					@endforeach
				</ul>
			</div>
			@endif
			@if(getDevice() == COMPUTER)
				@include('site.common.ads', array('adPosition' => POSITION_NEWS_RIGHT))
			@endif
		</div>
	</div>

</div>

@stop