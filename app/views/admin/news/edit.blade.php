@extends('admin.layout.default')

@section('title')
{{ $title='Cập nhật tin' }}
@stop

@section('content')

@include('admin.news.common')

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<!-- form start -->
			{{ Form::open(array('action' => array('NewsController@update', $inputNew->id), 'method' => 'PUT', 'files' => true)) }}
			<div class="box-body">
				<div class="form-group">
					<label for="title">Tiêu đề</label>
					<div class="row">
						<div class="col-sm-6">
						   {{ Form::text('title', $inputNew->title, textParentCategory('Tiêu đề tin')) }}
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="name">Thể loại tin</label>
					<div class="row">
						<div class="col-sm-6">
							@if(!Admin::isSeo()) 
						   {{  Form::select('type_new_id', returnList('TypeNew'), $inputNew->type_new_id, array('class' => 'form-control' )) }}
						   	@else
						   	{{  Form::select('type_new_id', returnList('TypeNew'), $inputNew->type_new_id ,array('class' => 'form-control', 'disabled'=>'true' )) }}
						   	@endif
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="image_url">Upload ảnh tin</label>
					<div class="row">
						<div class="col-sm-6">
							@if(Admin::isSeo())         
							{{ Form::file('image_url', array('disabled' => 'true')) }}
							<img class="image_fb" src="{{ url(UPLOADIMG . '/news'.'/'. $inputNew->id . '/' . $inputNew->image_url) }}" />
							@else
							{{ Form::file('image_url') }}
							<img class="image_fb" src="{{ url(UPLOADIMG . '/news'.'/'. $inputNew->id . '/' . $inputNew->image_url) }}" />
							@endif
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="sapo">Mô tả ngắn</label>
					<div class="row">
						<div class="col-sm-6">
						{{ Form::textarea('sapo', $inputNew->sapo, array('placeholder' => 'Mô tả ngắn', 'maxlength' => 500, 'rows' => 4, 'class' => 'form-control')) }}
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="description">Nội dung tin</label>
					<div class="row">
						<div class="col-sm-12">	 
							@if(!Admin::isSeo())                 	
						   	{{ Form::textarea('description', $inputNew->description, array('class' => 'form-control', "rows"=>6, 'id' => 'editor1')) }}
						   	@else                 	
						   	{{ Form::textarea('description', $inputNew->description, array('class' => 'form-control', "rows"=>6, 'id' => 'editor1', 'disabled' => 'true')) }}
						   	@endif
						</div>
					</div>
				</div>
				@if(!Admin::isSeo())
				<div class="form-group">
					<label for="start_date">Ngày xuất bản</label>
					<div class="row">
						<div class="col-sm-6">
						   <input type="text" class="form-control" name="start_date" value="{{ $inputNew->start_date }}" id="start_date">
						</div>
					</div>
				</div>
				@endif
				<div class="row">
					<div class="col-sm-6">
						<hr />
						<h1>SEO META</h1>
						{{-- include common/meta.blade.php --}}
						@include('admin.common.meta', array('inputSeo' => $inputSeo, 'pathToImageSeo' => UPLOADIMG . '/'.FOLDER_SEO_NEWS.'/'. $inputNew->id . '/'))
					</div>
				</div>

			  <!-- /.box-body -->

			  <div class="box-footer">
				{{ Form::submit('Lưu lại', array('class' => 'btn btn-primary')) }}
			  </div>
			{{ Form::close() }}
		  </div>
		  <!-- /.box -->
	</div>
</div>
@include('admin.common.ckeditor')
@stop
