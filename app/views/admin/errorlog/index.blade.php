@extends('admin.layout.default')

@if(Admin::isAdmin() || Admin::isEditor())

@section('title')
{{ $title='Quản lý Error Logs' }}
@stop

@section('content')

<div class="margin-bottom">
	{{ Form::open(array('action' => 'ErrorsController@search', 'method' => 'GET')) }}
		<div class="input-group" style="width: 150px; display:inline-block;">
			<label>Text</label>
			{{  Form::text('link', Input::get('link'), array('class' => 'form-control' )) }}
		</div>
		<div class="input-group" style="width: 150px; display:inline-block;">
		<label>Thể loại</label>
			{{  Form::select('type', ['' => '-- Lựa chọn', ERROR_TYPE_404 => 'Lỗi 404', ERROR_TYPE_MISSING => 'Lỗi game'], Input::get('type'), array('class' => 'form-control' )) }}
		</div>
		<div class="input-group" style="width: 150px; display:inline-block;">
		<label>URL</label>
			{{  Form::select('url', [CHOINHANH => CHOINHANH, '' => 'Url khác'], Input::get('url'), array('class' => 'form-control' )) }}
		</div>
		<div class="input-group" style="width: 150px; display:inline-block;">
			<label>Agent</label>
			{{  Form::text('agent', Input::get('agent'), array('class' => 'form-control' )) }}
		</div>
		<div class="input-group" style="width: 150px; display:inline-block;">
			<label>Từ ngày</label>
		  	{{ Form::text('start_date', Input::get('start_date'), array('class' => 'form-control', 'id' => 'start_date', 'placeholder' => 'Từ ngày')) }}
		</div>
		<div class="input-group" style="width: 150px; display:inline-block;">
			<label>Đến ngày</label>
		  	{{ Form::text('end_date', Input::get('end_date'), array('class' => 'form-control', 'id' => 'end_date', 'placeholder' => 'Đến ngày')) }}
		</div>
		<div class="input-group" style="display: inline-block; vertical-align: bottom;">
			<input type="submit" value="Search" class="btn btn-primary" />
		</div>
	</form>
</div>

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ action('ErrorsController@index') }}" class="btn btn-success">Danh sách lỗi</a>
		<a onclick="deleteSelected();" class="btn btn-primary">Xóa</a>
		<a onclick="deleteSelectedAllErrors();" class="btn btn-primary">Xóa toàn bộ</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-header">
		  <h3 class="box-title">Danh sách error</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive no-padding">
		  <table class="table table-hover">
			<tr>
				  <th><input type="checkbox" id="checkall" onClick="toggle(this)" /></th>
				  <th>ID</th>
				  <th>URL</th>
				  <th>Thể loại</th>
				  <th>Số lượng</th>
				  <th style="width:200px;">Action</th>
			</tr>
			 @foreach($data as $value)
			<tr>
			   <td><input type="checkbox" class="error_id" name="error_id[]" value="{{ $value->id }}" /></td>
			  <td>{{ $value->id }}</td>
			  <td>{{ $value->link }}</td>
			  <td>{{ CommonLog::getTypeError($value->type) }}</td>
			  <td>{{ $value->count }}</td>
			  <td>
				<a href="{{ action('ErrorLogsController@log', $value->id) }}" class="btn btn-success">Lịch sử</a>
				{{ Form::open(array('method'=>'DELETE', 'action' => array('ErrorsController@destroy', $value->id), 'style' => 'display: inline-block;')) }}
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
		{{ $data->appends(Request::except('page'))->links() }}
		</ul>
	</div>
</div>

@include('admin.errorlog.script')

@endif

@stop

