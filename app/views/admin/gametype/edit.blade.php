@extends('admin.layout.default')

@section('title')
{{ $title='Sửa thể loại game' }}
@stop

@section('content')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ action('GameTypeController@index') }}" class="btn btn-success">Danh sách thể loại game</a>
		@if(!Admin::isSeo())
		<a href="{{ action('GameTypeController@create') }}" class="btn btn-primary">Thêm thể loại game</a>
		@endif
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<!-- form start -->
			{{ Form::open(array('action' => array('GameTypeController@update', $inputType->id), 'method' => 'PUT', 'files' => true)) }}
				<div class="row">
					<div class="col-sm-6">
						<div class="box-body">
							<div class="form-group">
								<label for="name">Tên thể loại game</label>
								{{ Form::text('name', $inputType->name , textParentCategory('Tên thể loại game')) }}
							</div>

							<div class="form-group">
								<label for="image_url">Upload ảnh</label>
								{{ Form::file('image_url') }}
								<img class="image_fb" src="{{ url(UPLOADIMG . UPLOAD_GAME_TYPE .'/'. $inputType->id . '/' . $inputType->image_url) }}" />
							</div>

							<hr />
							<h1>SEO META</h1>
							{{-- include common/meta.blade.php --}}
							@include('admin.common.meta', array('inputSeo' => $inputSeo, 'pathToImageSeo' => UPLOADIMG . '/'.FOLDER_SEO_GAMETYPE.'/'. $inputType->id . '/'))

						</div>
						<!-- /.box-body -->
					</div>
					<div class="col-sm-6"></div>
				</div>
				<div class="box-footer">
					{{ Form::submit('Lưu lại', array('class' => 'btn btn-primary')) }}
				</div>
			{{ Form::close() }}
		</div>
	</div>
</div>

@stop
