@extends('admin.layout.default')

@section('title')
{{ $title='Quản lý điểm' }}
@stop

@section('content')
@include('admin.score.search')
<!-- inclue Search form 

-->
@if(!Admin::isSeo())
<div class="row margin-bottom">
	<div class="col-xs-12">
		<a onclick="updateScore();" class="btn btn-success">Cập nhật</a>
	</div>
</div>
@endif
<div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-header">
		  <h3 class="box-title">Danh sách điểm</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive no-padding">
		  <table class="table table-hover">
			<tr>
			  <th>ID</th>
			  <th>Game</th>
			  <th>Điểm</th>
			  <th>Tài khoản</th>
			  <th>Thời gian</th>
			  <th>Trạng thái</th>
			  <th>Action</th>
			</tr>
			@foreach($inputScore as $value)
			<tr>
			  <td>
			  {{ $value->id }}
			  {{ Form::hidden('id[]', $value->id) }}
			  </td>
			  <td>{{ Game::find($value->game_id)->name }}</td>
			  <td>{{ $value->score }}</td>
			  <td>{{ User::find($value->user_id)->user_name  }}</td>
			  <td>{{ $value->created_at }}</td>
			  <td>
		  	{{ Form::select('status[]',  selectActive(), $value->status, array('class' =>'form-control')) }}
			  </td>
			  <td> 
			   {{ Form::open(array('method'=>'DELETE', 'action' => array('ScoreManagerController@destroy', $value->id), 'style' => 'display: inline-block;')) }}
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
		{{ $inputScore->appends(Request::except('page'))->links() }}
		</ul>
	</div>
</div>
@include('admin.score.script')
@stop

