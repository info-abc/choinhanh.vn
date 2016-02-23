@extends('admin.layout.default')

@if(Admin::isAdmin() || Admin::isEditor())

@section('title')
{{ $title='Quản lý Error Logs' }}
@stop

@section('content')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ action('ErrorsController@index') }}" class="btn btn-success">Danh sách lỗi</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-header">
		  <h3 class="box-title">Danh sách error logs</h3>
		  <br />
		  <strong>{{ AdminError::find($id)->link }}</strong>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive no-padding">
		  <table class="table table-hover">
			<tr>
			  <th>ID</th>
			  <th>Agent</th>
			  <th>Origin Url</th>
			  <th>Thời gian</th>
			</tr>
			 @foreach($data as $value)
			<tr>
			  <td>{{ $value->id }}</td>
			  <td>{{ $value->agent }}</td>
			  <td>{{ $value->referer }}</td>
			  <td>{{ $value->created_at }}</td>
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
		{{ $data->appends(Request::except('page'))->links() }}
		</ul>
	</div>
</div>

@endif

@stop
