@extends('admin.layout.default')

@section('title')
{{ $title='Thêm mới quảng cáo header và footer' }}
@stop

@section('content')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ action('AdminSlideController@index') }} " class="btn btn-success">Danh sách slide</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<!-- form start -->
			{{ Form::open(array('action' => array('AdminSlideController@store'), 'files' => true)) }}
			<div class="box-body">
				<div class="form-group">
					<label for="name">Name</label>
					<div class="row">
						<div class="col-sm-6">	
							{{ Form::text('name', null , textParentCategory('tên slide')) }}
						</div>
					</div>
				</div>

				<div class="form-group">
					<label for="name">Auto Play</label>
					<div class="row">
						<div class="col-sm-6">	                  	
						   {{ Form::select('autoplay', [ENABLED => 'Tự động chạy', DISABLED => 'Không tự động chạy']) }}
						</div>
					</div>
				</div>

				<div class="form-group">
					<label for="name">Hiển thị nút prev và next</label>
					<div class="row">
						<div class="col-sm-6">	                  	
						   {{ Form::select('navigation', [DISABLED => 'Không', ENABLED => 'Có']) }}
						</div>
					</div>
				</div>

				<div class="form-group">
					<label for="name">Hiển thị nút phân trang cho slide</label>
					<div class="row">
						<div class="col-sm-6">	                  	
						   {{ Form::select('pagination', [DISABLED => 'Không', ENABLED => 'Có']) }}
						</div>
					</div>
				</div>

				<div class="form-group">
					<label for="name">Thời gian slide chạy</label>
					<div class="row">
						<div class="col-sm-6">	
							{{ Form::text('config_time', null , textParentCategory('Time')) }}
						</div>
					</div>
				</div>

				<div class="form-group">
					<label for="name">Image</label>
					<div class="row">
						<div class="col-sm-6">
							{{ Form::file('image_url[]', array('id' => 'image_url', 'multiple' => true)) }}
						</div>
					</div>
				</div>

				<div class="form-group">
					<label for="name">Kiểu slide</label>
					<div class="row">
						<div class="col-sm-6">	                  	
						   {{ Form::select('type', [DISABLED => 'Chạy ngang']) }}
						</div>
					</div>
				</div>
			  <div class="box-footer">
				{{ Form::submit('Lưu lại', array('class' => 'btn btn-primary')) }}
			  </div>
			{{ Form::close() }}
		  </div>
		  <!-- /.box -->
	</div>
</div>
@stop
