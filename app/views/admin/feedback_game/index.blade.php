@extends('admin.layout.default')

@section('title')
{{ $title='Quản lý báo lỗi game' }}
@stop

@section('content')
@include('admin.feedback_game.search')
@include('admin.feedback_game.scriptindex')
<!-- inclue Search form 

-->
 @if(Admin::isAdmin())
<div class="row margin-bottom">
	<div class="col-xs-12">
		<a onclick="updateFeedbackGame();" class="btn btn-success">Duyệt</a>
		<a onclick="updateInActive();" class="btn btn-danger">Hủy</a>
	</div>
</div>
@endif 
<div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-header">
		  <h3 class="box-title">Quản lý báo lỗi game</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive no-padding">
		  <table class="table table-hover">
			<tr>
			@if(Admin::isAdmin())
				<th><input type="checkbox" id="checkall" onClick="toggle(this)" /></th>
			@endif
			  <th>ID</th>
			  <th>Tên Game</th>
			  <th>Nội dung báo lỗi</th>
			  <th>Thời gian báo lỗi</th>
			  <th>Device</th>
			  <th>Ip</th>
			  <th>Trạng thái</th>
			  <th style="width:200px;">Action</th>
			</tr>
			@foreach($inputFeedbackGame as $value)
			<tr>
				@if(Admin::isAdmin())
					<td><input type="checkbox" class="feedback_game_id"  name="feedback_game_id[]" value="{{ $value->id }}" /></td>
				@endif
			  <td>{{ $value->id }}</td>
			  <td>{{ Game::find($value->game_id)->name }}</td>
			  <td>{{ $value->description }}</td>
			  <td>{{ $value->created_at }}</td>
			  <td>{{ getNameDevice($value->device) }}</td>
			  <td>{{ $value->ip }}</td>
			  <td>{{ checkApproveOrReject($value->status) }}</td>
			  <td>
			  	@if($value->status == ACTIVE )
				<a href="{{  action('FeedbackGameController@edit', $value->id) }}" class="btn btn-primary">Đã xử lý</a>
				@else
				<a href="{{  action('FeedbackGameController@edit', $value->id) }}" class="btn btn-danger">Chưa xử lý</a>
				@endif
				{{ Form::open(array('method'=>'DELETE', 'action' => array('FeedbackGameController@destroy', $value->id), 'style' => 'display: inline-block;')) }}
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
		{{ $inputFeedbackGame->appends(Request::except('page'))->links() }}
		</ul>
	</div>
</div>

@stop

