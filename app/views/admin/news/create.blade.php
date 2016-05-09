@extends('admin.layout.default')

@section('title')
{{ $title='Thêm mới thể loại tin' }}
@stop

@section('content')

@include('admin.news.common')

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<!-- form start -->
			{{ Form::open(array('action' => array('NewsController@store'), 'files'=> true)) }}
				<div class="box-body">
					<div class="form-group">
						<label for="title">Tiêu đề</label>
						<div class="row">
							<div class="col-sm-6">
							   {{ Form::text('title', null, textParentCategory('Tiêu đề tin')) }}
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="start_date">Ngày xuất bản</label>
						<div class="row">
							<div class="col-sm-6">
							   <input type="text" class="form-control" name="start_date" id="start_date">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="name">Thể loại tin</label>
						<div class="row">
							<div class="col-sm-6">
							   {{  Form::select('type_new_id', returnList('TypeNew'), null, array('class' => 'form-control')) }}
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="image_url">Upload ảnh tin</label>
						<div class="row">
							<div class="col-sm-6">
								{{ Form::file('image_url') }}
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="sapo">Mô tả ngắn</label>
						<div class="row">
							<div class="col-sm-6">
								 {{ Form::textarea('sapo', null, array('placeholder' => 'Mô tả ngắn', 'maxlength' => 500, 'rows' => 4, 'class' => 'form-control')) }}
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="description">Nội dung tin</label>
						<div class="row">
							<div class="col-sm-12">
							   {{ Form::textarea('description', '' , array('class' => 'form-control', "rows"=>6, 'id' => 'editor1')) }}
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6">
							<hr />
							<h1>SEO META</h1>
							{{-- include common/meta.blade.php --}}
							@include('admin.common.meta')
						</div>
						<div class="col-sm-6"></div>
					</div>

					<!-- /.box-body -->

					<div class="box-footer">
					{{ Form::submit('Lưu lại', array('class' => 'btn btn-primary')) }}
					</div>
				</div>
			{{ Form::close() }}
		  	<!-- /.box -->
	  	</div>
	</div>
</div>
@include('admin.common.ckeditor')
@stop
