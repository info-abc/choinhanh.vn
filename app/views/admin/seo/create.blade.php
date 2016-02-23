@extends('admin.layout.default')

@section('title')
{{ $title='Thêm mới Seo' }}
@stop

@section('content')
@include('admin.seo.common')

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<!-- form start -->
			{{ Form::open(array('action' => array('SeoController@store'), 'files'=> true)) }}
			<div class="box-body">
				<div class="form-group">
				  	<label for="name">SEO Header</label>
				  	<div class="row">
						<div class="col-sm-12">
						   {{ Form::textarea('header_script', null , textParentCategory('Nhập script seo header vào đây')) }}
						</div>
				  </div>
				</div>
				<div class="form-group">
				  	<label for="name">SEO Footer</label>
				  	<div class="row">
						<div class="col-sm-12">
						   {{ Form::textarea('footer_script', null , textParentCategory('Nhập script seo footer vào đây')) }}
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
@stop
