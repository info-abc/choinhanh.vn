@extends('admin.layout.default')

@section('title')
@if(!Request::segment(3) == CONTENT_SEGMENT)
	{{ $title='Quản lý Menu' }}
@else
	{{ $title='Quản lý box hiển thị' }}
@endif
@stop

@section('content')

<!-- inclue Search form 

-->
@if(!Admin::isSeo())
<div class="row margin-bottom">
	<div class="col-xs-12">
		@if(!Request::segment(3) == CONTENT_SEGMENT)
		<a href="{{ action('CategoryParentController@create') }}" class="btn btn-primary">Thêm Menu</a>
		@else
		<a href="{{ action('CategoryParentController@contentCreate') }}" class="btn btn-primary">Thêm chuyên mục Content</a>
		@endif
	</div>
</div>
@endif
<div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-header">
		  <h3 class="box-title">Danh sách chuyên mục</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive no-padding">
		  <table class="table table-hover">
			<tr>
			  <th>ID</th>
			  <th>Tên chuyên mục</th>
			  @if(!Request::segment(3) == CONTENT_SEGMENT)
			  	<th>Tổng số thể loại</th>
			  @endif
			 
			  @if(!Request::segment(3) != CONTENT_SEGMENT)	
			  <th>Trạng thái</th>	
			  <th>Tổng số game</th>	  
			  <th>Tổng số xem</th>			  
			  <th>Tổng số chơi</th>			  
			  <th>Tổng số tải</th>	
			  
			  @endif		  
			  <th>Trạng thái Seo </th>	
			  <th style="width:200px;">Action</th>
			</tr>
			@foreach($categoryParents as $categoryParent)
				<tr>
				  	<td>{{ $categoryParent->id }}</td>
					<td>{{ $categoryParent->name }}</td>
					@if(!Request::segment(3) == CONTENT_SEGMENT)
						<td>{{ countType($categoryParent->id) }}</td>
					@endif
					
					<!-- todo -->
					 @if(!Request::segment(3) != CONTENT_SEGMENT)	
					 <td>{{ getStatusCategoryParent($categoryParent->status) }}</td>
					 <td>{{ countBoxGame($categoryParent->id) }}</td>
					<td>{{ countBoxView($categoryParent->id) }}</td>
					<td>{{ countBoxPlay($categoryParent->id) }}</td>
					<td>{{ countBoxDowload($categoryParent->id) }}</td>
					@endif
					<td>{{ getStatusSeoParent($categoryParent, 'CategoryParent') }}</td>
					<td>
					 	@if(Request::segment(3) == CONTENT_SEGMENT)
					 	<!-- content -->
					 	<a href="{{ route('content.edit', $categoryParent->id) }}" class="btn btn-primary">Sửa</a>
					 	@else
					 	<a href="{{ action('CategoryParentController@edit', $categoryParent->id) }}" class="btn btn-primary">Sửa</a>
					 	@endif
						@if(!Admin::isSeo())
						{{ Form::open(array('method'=>'DELETE', 'action' => array('CategoryParentController@destroy', $categoryParent->id), 'style' => 'display: inline-block;')) }}
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
		{{ $categoryParents->appends(Request::except('page'))->links() }}
		</ul>
	</div>
</div>

@stop

