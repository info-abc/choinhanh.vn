@extends('admin.layout.default')

@section('title')
{{ $title='Quản lý SEO' }}
@stop

@section('content')
<!-- inclue Search form 

-->


<div class="row margin-bottom">
	<div class="col-xs-12">
	@if(!$seoScript)
		<a href="{{ action('SeoController@create') }}" class="btn btn-primary">Thêm Seo Script</a>
	@elseif(!$seoMeta)
		<a href="{{ action('SeoController@seoMeta') }}" class="btn btn-primary">Thêm Seo Meta</a>
	@endif
	</div>
</div>




<div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-header">
		  <h3 class="box-title">Danh sách Seo</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive no-padding">
		  <table class="table table-hover">
			<tr>
			 
			  <th>ID</th>
			  <th>Header</th>
			  <th>Footer</th>
			  <th>Thời gian tạo</th>
			  <th style="width:200px;">Action</th>
			</tr>
			 @foreach($inputSeo as $value)
			<tr>
			  <td>{{ $value->id }}</td>
			  <td>{{{ $value->header_script }}}</td>
			  <td>{{{ $value->footer_script }}}</td>
			  <td>{{ $value->created_at }}</td>
			  <td>
			  	@if($value->model_name == SEO_SCRIPT)
				<a href="{{  action('SeoController@edit', $value->id) }}" class="btn btn-primary">Sửa</a>
				@elseif($value->model_name == SEO_META)
				<a href="{{  action('SeoController@editSeoMeta', $value->id) }}" class="btn btn-primary">Sửa Meta</a>
				@endif
				
			  </td>
			</tr>
			@endforeach
		  </table>
		</div>
		<!-- /.box-body -->
	  </div>
	  <!-- /.box -->
	</div>
</div>

@stop

