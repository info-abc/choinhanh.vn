@extends('site.layout.default')

<?php 
	if(isset($typeNew)) {
		$typeNewTitle = $typeNew->name;
	} else {
		$typeNewTitle = 'Danh sách tin tức';
	}
?>

@section('title')
	{{ $title = $typeNewTitle }}
@stop

@section('content')

<div class="list">

	<div class="title_center">
		<h1>{{ $typeNewTitle }}</h1>
	</div>

	@foreach($inputListNews as $value)
		<?php 
			if(!isset($typeNew)) {
				$typeNew = TypeNew::find($value->type_new_id);
			}
			$url = action('SlugController@detailData', [$typeNew->slug, $value->slug]);
		?>
		<div class="list-item">
			<div class="list-image">
				<a href="{{ $url }}">
					<img class="image_fb" src="{{ url(UPLOADIMG . '/news'.'/'. $value->id . '/' . $value->image_url) }}" />
				</a>
			</div>
			<div class="list-text">
				<h3>
					<a href="{{ $url }}">
						{{ $value->title }}
					</a>
				</h3>
				<p>{{ CommonSite::getSapoNews($value) }}</p>
			</div>
		</div>
	@endforeach
</div>

@include('site.common.paginate', array('input' => $inputListNews))

@stop