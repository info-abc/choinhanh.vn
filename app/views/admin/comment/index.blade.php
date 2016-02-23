@extends('admin.layout.default')

@section('title')
{{ $title='Quản lý Comment' }}
@stop

@section('content')
@include('admin.comment.scriptindex')
@include('admin.comment.search')
<!-- inclue Search form 

-->
 @if(Admin::isAdmin())
<div class="row margin-bottom">
	<div class="col-xs-12">
		<a onclick="updateComment();" class="btn btn-success">Duyệt</a>
		<a onclick="updateCommentInactive();" class="btn btn-danger">Hủy</a>
	</div>
</div>
@endif 
<div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-header">
		  <h3 class="box-title">Danh sách Comnent</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive no-padding">
		  <table class="table table-hover">
			<tr>
			 @if(Admin::isAdmin())
				<th><input type="checkbox" id="checkall" onClick="toggle(this)" /></th>
			@endif
			  <th>ID</th>
			  <th>Tài khoản</th>
			  <th>Nội dung comment</th>
			  <th>Game</th>
			  <th>Thời gian bình luận</th>
			  <th>Device</th>
			  <th>Ip</th>
			  <th>Trạng thái</th>
			  <th style="width:200px;">Action</th>
			</tr>
			 @foreach($inputComment as $value)
			<tr>
			@if(Admin::isAdmin())
				<td><input type="checkbox" class="comment_id"  name="comment_id[]" value="{{ $value->id }}" /></td>
			@endif
			  <td>{{ $value->id }}</td>
			  <td>{{ User::find($value->user_id)->user_name }}</td>
			  <td>{{ $value->description }}</td>
			  <td>{{ Game::find($value->model_id)->name }}</td>
			  <td>{{ $value->created_at }}</td>
			  <td>{{ getNameDevice(User::find($value->user_id)->device) }}</td>
			  <td>{{ User::find($value->user_id)->ip }}</td>
			  <td>{{ checkApproveOrReject($value->status) }}</td>

			  <td>
			  	@if($value->status == ACTIVE )
				<a href="{{  action('CommentController@edit', $value->id) }}" class="btn btn-primary">Hủy</a>
				@else
				<a href="{{  action('CommentController@edit', $value->id) }}" class="btn btn-primary">Duyệt</a>
				@endif
				{{ Form::open(array('method'=>'DELETE', 'action' => array('CommentController@destroy', $value->id), 'style' => 'display: inline-block;')) }}
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
		<!-- phan trang -->
		{{ $inputComment->appends(Request::except('page'))->links() }}
		</ul>
	</div>
</div>

@stop

