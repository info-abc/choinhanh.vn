@extends('admin.layout.default')

@section('title')
{{ $title='Thêm mới Seo meta' }}
@stop

@section('content')
@include('admin.seo.common')

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
		<!-- form start -->
			{{ Form::open(array('action' => array('SeoController@addSeoMeta'), 'files'=> true)) }}
			<h1>SEO META</h1>
							{{-- include common/meta.blade.php --}}
							@include('admin.common.meta')
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
