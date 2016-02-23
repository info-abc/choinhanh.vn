@if(Request::segment(3) == CONTENT_SEGMENT)
<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ action('CategoryParentController@contentIndex') }} " class="btn btn-success">Danh sách chuyên mục content</a>
	</div>
</div>
@else
<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ action('CategoryParentController@index') }} " class="btn btn-success">Danh sách chuyên mục</a>
	</div>
</div>
@endif	