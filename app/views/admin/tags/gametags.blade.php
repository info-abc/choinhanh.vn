@extends('admin.layout.default')

@section('title')
{{ $title='Quản lý Gametags' }}
@stop

@section('content')

<div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-header">
		  <h3 class="box-title">Danh sách Games Tag: {{ $tagName }}</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive no-padding">
		  <table class="table table-hover">
			<tr>
			  <th>ID</th>
			  <th>Tên game</th>
			  <th style="width:200px;">&nbsp;</th>
			</tr>
			 @foreach($data as $value)
			<tr>
			  <td>{{ $value->id }}</td>
			  <td>{{ $value->name }}</td>
			  <td>
				<a href="{{ action('AdminGameController@edit', $value->id) }}" class="btn btn-primary">Sửa</a>
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

