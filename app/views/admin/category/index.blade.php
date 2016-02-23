@extends('admin.layout.default')

@section('title')
{{ $title='Quản lý kiểu game' }}
@stop

@section('content')

<!-- inclue Search form 

-->
<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ action('CategoryController@create') }}" class="btn btn-primary">Thêm category</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-header">
		  <h3 class="box-title">Danh sách category</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive no-padding">
		  <table class="table table-hover">
			<tr>
			  <th>ID</th>
			  <th>Tên Category</th>
			  <th>Số game</th>
			  <th>Tổng View</th>			  
			  <th>Tổng dowload</th>	
			  <th style="width:200px;">&nbsp;</th>
			</tr>
			 @foreach($categories as $category)
			<tr>
			  <td>{{ $category->id }}</td>
			  <td>{{ $category->name }}</td>
			  <td>{{ countCategoryGame($category->id) }}</td>
			  <td>{{ countCategoryView($category->id) }}</td>			
			  <td>{{ countCategoryDownload($category->id)}}</td>
			  <td>
				<a href="{{ action('CategoryController@edit', $category->id) }}" class="btn btn-primary">Sửa</a>
				{{ Form::open(array('method'=>'DELETE', 'action' => array('CategoryController@destroy', $category->id), 'style' => 'display: inline-block;')) }}
				<button class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</button>
				{{ Form::close() }}
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
		{{ $categories->appends(Request::except('page'))->links() }}
		</ul>
	</div>
</div>

@stop

