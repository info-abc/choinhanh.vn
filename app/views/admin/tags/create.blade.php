@extends('admin.layout.default')

@section('title')
{{ $title='Thêm mới tags' }}
@stop

@section('content')

@include('admin.tags.common')

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<!-- form start -->
			{{ Form::open(array('action' => array('AdminTagController@store', 'files'=> true))) }}
				<div class="box-body">
					<div class="form-group">
						<label for="name">Tên</label>
						<div class="row">
							<div class="col-sm-6">	                  	
							   {{ Form::text('name', null , textParentCategory('Tên')) }}
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="name">Tiêu đề hiển thị</label>
						<div class="row">
							<div class="col-sm-6">	                  	
							   {{ Form::text('title', null , textParentCategory('')) }}
							</div>
						</div>
					</div>

					<div class="form-group">
						<label>Trạng thái</label>
						<div class="row">
							<div class="col-sm-6">	  
								{{ Form::select('status', selectStatus(), '', array('class' => 'form-control')) }}
							</div>
						</div>
					</div>

					<hr />
					<h1>SEO META</h1>
					@include('admin.common.meta')
					
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
@stop
