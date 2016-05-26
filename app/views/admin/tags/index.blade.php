@extends('admin.layout.default')

@section('title')
{{ $title='Quản lý Tags' }}
@stop

@section('content')

<!-- inclue Search form 

-->
<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ action('AdminTagController@create') }}" class="btn btn-primary">Thêm Tags</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-header">
		  <h3 class="box-title">Danh sách Tags</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive no-padding">
		  <table class="table table-hover">
			<tr>
			  <th>ID</th>
			  <th>Tên</th>
			  <th>Game HTML5</th>
			  <th>Game Flash</th>
			  <!-- <th>Game Android</th> -->
			  <!-- <th>Game Online</th> -->
			  <th style="width:200px;">&nbsp;</th>
			</tr>
			 @foreach($data as $value)
			<tr>
			  <td>{{ $value->id }}</td>
			  <td><a href="{{ action('AdminTagController@gametags', $value->id) }}">{{ $value->name }}</a></td>
			  <td>{{ CommonGame::countGameTag($value->id, GAMEHTML5) }}</td>
			  <td>{{ CommonGame::countGameTag($value->id, GAMEFLASH) }}</td>
			  <!-- <td>{{-- CommonGame::countGameTag($value->id, GAMEOFFLINE) --}}</td> -->
			  <!-- <td>{{-- CommonGame::countGameTag($value->id, GAMEONLINE) --}}</td> -->
			  <td>
				<a href="{{ action('AdminTagController@edit', $value->id) }}" class="btn btn-primary">Sửa</a>
				{{ Form::open(array('method'=>'DELETE', 'action' => array('AdminTagController@destroy', $value->id), 'style' => 'display: inline-block;')) }}
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
		{{ $data->appends(Request::except('page'))->links() }}
		</ul>
	</div>
</div>

@stop

