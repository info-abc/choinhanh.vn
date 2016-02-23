@extends('admin.layout.default')

@section('title')
{{ $title='Quản lý lịch sử bài viết' }}
@stop

@section('content')
<div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-header">
			<h3 class="box-title">Lịch sử</h3>
			{{ Form::open(array('method'=>'POST', 'action' => array('NewsController@deleteHistory', $history->id), 'style' => 'display: inline-block;')) }}
				<button class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</button>
			{{ Form::close() }}
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive no-padding">
		  <table class="table table-hover">
			<tr>
			  <th>ID</th>
			  <th>Người chỉnh sửa</th>
			  <th>Time</th>
			  <th>Ip</th>
			  <th>Device</th>
			  <th style="width:200px;">Action</th>
			</tr>
			 @foreach($logEdit as $logedit)
			<tr>
			  <td>{{ $logedit->id }}</td>
			  <td>{{ $logedit->editor_name }}</td>
			  <td>{{ $logedit->editor_time }}</td>
			  <td>{{ $logedit->editor_ip }}</td>
			  <td>{{ getNameDevice($logedit->history->device )}}</td>
			  <td>{{ $logedit->action }}</td>
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
		</ul>
	</div>
</div>

@stop

