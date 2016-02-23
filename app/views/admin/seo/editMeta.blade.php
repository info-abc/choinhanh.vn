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
			{{ Form::open(array('action' => array('SeoController@doEditSeoMeta', $inputSeo->id), 'method' => 'PUT', 'files' => true)) }}
							
							{{-- include common/meta.blade.php --}}
							@include('admin.common.meta', array('inputSeo' => $inputSeo, 'pathToImageSeo' => UPLOADIMG . '/'.FOLDER_SEO.'/'))
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
