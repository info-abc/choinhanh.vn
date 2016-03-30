@extends('admin.layout.default')

@section('title')
{{ $title='Thêm mới thể loại tin' }}
@stop

@section('content')

@include('admin.typenew.common')

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<!-- form start -->
			{{ Form::open(array('action' => array('NewsTypeController@update', $inputTypeNew->id) , 'method' => 'PUT', 'files'=> true)) }}
				<div class="box-body">
					<div class="form-group">
						<label for="name">Tên thể loại</label>
						<div class="row">
							<div class="col-sm-6">	                  	
							   {{ Form::text('name', $inputTypeNew->name , textParentCategory('Tên thể loại tin')) }}
							</div>
						</div>
					</div>

					<hr />
					<h1>SEO META</h1>
					@include('admin.common.meta', array('inputSeo' => $inputSeo, 'pathToImageSeo' => UPLOADIMG . '/'.FOLDER_SEO_NEWS_TYPE.'/'. $inputTypeNew->id . '/'))
					
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
