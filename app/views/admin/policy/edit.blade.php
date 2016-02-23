@extends('admin.layout.default')

@section('title')
{{ $title='Sửa bài viết chính sách' }}
@stop

@section('content')
@include('admin.policy.common')

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<!-- form start -->
			{{ Form::open(array('action' => array('PolicyController@update', $inputpolicy->id), 'method' => 'PUT')) }}
			<div class="box-body">
				<div class="form-group">
				  	<label for="name">Tiêu đề</label>
				  	<div class="row">
						<div class="col-sm-12">
						   {{ Form::text('title', $inputpolicy->title , textParentCategory('Nhập tiêu đề')) }}
						</div>
				  </div>
				</div>
				<div class="form-group">
				  	<label for="name">Thể loại</label>
				  	<div class="row">
						<div class="col-sm-12">
						   {{ Form::select('type_policy',selectType_Policy(), $inputpolicy->type_policy, array('class' =>'form-control')) }}
						</div>
				  </div>
				</div>
				<div class="form-group">
				  	<label for="name">Mô tả</label>
				  	<div class="row">
						<div class="col-sm-12">
						    {{ Form::textarea('description', $inputpolicy->description , array('class' => 'form-control',"rows"=>6, 'id' => 'editor1')) }}
						</div>
				  </div>
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
