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
			{{ Form::open(array('action' => array('AdminTagController@update', $inputTag->id) , 'method' => 'PUT', 'files'=> true)) }}
				<div class="box-body">
					<div class="form-group">
						<label for="name">Tên</label>
						<div class="row">
							<div class="col-sm-6">	                  	
							   {{ Form::text('name', $inputTag->name , textParentCategory('Tên')) }}
							</div>
						</div>
					</div>
				  	<!-- /.box-body -->
					<div class="box-footer">
						{{ Form::submit('Lưu lại', array('class' => 'btn btn-primary')) }}
					</div>
			  	</div>
			{{ Form::close() }}
	  	</div>
	  	<!-- /.box -->
	</div>
</div>
@stop
