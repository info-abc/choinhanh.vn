@extends('admin.layout.default')

@section('title')
{{ $title='Quản lý góp ý' }}
@stop

@section('content')
@include('admin.feedback.search')
@include('admin.feedback.scriptindex')
<!-- inclue Search form 

-->
 @if(Admin::isAdmin())
<div class="row margin-bottom">
	<div class="col-xs-12">
		<a onclick="updateFeedback();" class="btn btn-success">Duyệt</a>
		<a onclick="updateInActive();" class="btn btn-danger">Hủy</a>
	</div>
</div>
@endif 
<div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-header">
		  <h3 class="box-title">Quản lý góp ý</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive no-padding">
		  <table class="table table-hover">
			<tr>
			@if(Admin::isAdmin())
				<th><input type="checkbox" id="checkall" onClick="toggle(this)" /></th>
			@endif
			  <th>ID</th>
			  <th>Tên</th>
			  <th>Email</th>
			  <th>Tiêu đề</th>
			  <th>Nội dung góp ý</th>
			  <th>Thời gian góp ý</th>
			  <th>Device</th>
			  <th>Ip</th>
			  <th>Trạng thái</th>
			  <th style="width:200px;">Action</th>
			</tr>
			 @foreach($inputFeedback as $value)
			<tr>
			  @if(Admin::isAdmin())
				<td><input type="checkbox" class="feedback_id"  name="feedback_id[]" value="{{ $value->id }}" /></td>
			  @endif
			  <td>{{ $value->id }}</td>
			  <td>{{ $value->name }}</td>
			  <td>{{ $value->email }}</td>
			  <td>{{ $value->title }}</td>
			  <td>{{ $value->description }}</td>
			  <td>{{ $value->created_at }}</td>
			  <td>{{ getNameDevice($value->device) }}</td>
			  <td>{{ $value->ip }}</td>
			  <td>{{ checkApproveOrReject($value->status) }}</td>
			  <td>
			  	@if($value->status == ACTIVE )
				<a href="{{  action('FeedbackController@edit', $value->id) }}" class="btn btn-primary">Hủy</a>
				@else
				<a href="{{  action('FeedbackController@edit', $value->id) }}" class="btn btn-primary">Duyệt</a>
				@endif
				{{ Form::open(array('method'=>'DELETE', 'action' => array('FeedbackController@destroy', $value->id), 'style' => 'display: inline-block;')) }}
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
		{{ $inputFeedback->appends(Request::except('page'))->links() }}
		</ul>
	</div>
</div>

@stop

