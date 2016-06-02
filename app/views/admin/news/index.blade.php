@extends('admin.layout.default')

@section('title')
{{ $title='Quản lý tin' }}
@stop

@section('content')
@include('admin.news.search')
<!-- inclue Search form 

-->
@if(!Admin::isSeo())
<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ action('NewsController@create') }}" class="btn btn-primary">Thêm mới tin</a>
	</div>
</div>
@endif
<div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-header">
			@if($inputNew)
			<strong>Tổng số: {{ $inputNew->getTotal() }}</strong><br>
			@endif
		  <h3 class="box-title">Danh sách loại tin</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive no-padding">
		  <table class="table table-hover">
			<tr>
			  <th>ID</th>
			  <th>Tiêu đề</th>
			  <th>Thể loại</th>
			  <th>Số lượt view</th>
			  <th>Ngày xuất bản</th>
			  <th>Trạng thái Seo</th>
			  <th style="width:200px;">Action</th>
			</tr>
			 @foreach($inputNew as $value)
			<tr>
			  <td>{{ $value->id }}</td>
			  <td>{{ $value->title }}</td>
			  <td>{{ TypeNew::find($value->type_new_id)->name }}</td>
			  <td>{{ $value->count_view }}</td>
			  <td>{{ $value->start_date }}</td>
			  <td>{{ getStatusSeoParent($value, 'AdminNew') }}</td>
			  <td>
			  	@if(!Admin::isSeo())
					<a href="{{ action('NewsController@history', $value->id) }}" class="btn btn-success">Lịch sử</a>
				@endif
				<a href="{{  action('NewsController@edit', $value->id) }}" class="btn btn-primary">Sửa</a>
				@if(!Admin::isSeo())
				{{ Form::open(array('method'=>'DELETE', 'action' => array('NewsController@destroy', $value->id), 'style' => 'display: inline-block;')) }}
					<button class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</button>
				{{ Form::close() }}
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

<div class="row">
	<div class="col-xs-12">
		<ul class="pagination">
		<!-- phan trang -->
		{{ $inputNew->appends(Request::except('page'))->links() }}
		</ul>
	</div>
</div>

@stop

