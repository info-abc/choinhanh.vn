@extends('site.layout.default', array('seoMeta' => CommonSite::getMetaSeo('AdminNew', $inputNew->id), 'seoImage' => FOLDER_SEO_NEWS . '/' . $inputNew->id))

@section('title')
	@if($title = CommonSite::getMetaSeo('AdminNew', $inputNew->id)->title_site)
		{{ $title= $title }}
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
	<div class="detail">
		{{ $inputNew->description }}
	</div>
	<div class="clearfix"></div>
	@if($inputRelated)
	<div class="related">
		<h3>Tin liên quan</h3>
		<ul>
			@foreach($inputRelated as $value)
			<li><a href="{{ url($value->slug) }}" title=""><i class="fa fa-caret-right"></i> [{{ $value->typeNew->name }}] {{ $value->title }}</a></li>
			@endforeach
		</ul>
	</div>
	@endif
</div>

@stop