@extends('admin.layout.default')

@section('title')
{{ $title='Quản lý thể loại game' }}
@stop

@section('content')
@include('admin.gametype.search')
<!-- inclue Search form-->

@if(!Admin::isSeo())
<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ action('GameTypeController@create') }}" class="btn btn-primary">Thêm thể loại game</a>
	</div>
</div>
@endif

<div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-header">
		  <h3 class="box-title">Danh sách thể loại game</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive no-padding">
		  <table class="table table-hover">
			<tr>
			  <th>ID</th>
			  <th>Tên thể loại</th>
			  <th>Tổng số game</th>
			  <th>Tổng số view</th>
			  <th>Tổng số play</th>
			  <th>Tổng số download</th>
			  <th>Trạng thái Seo</th>
			  <th style="width:200px;">&nbsp;</th>
			</tr>
		 	@foreach($data as $value)
				<tr>
				  <td>{{ $value->id }}</td>
				  <td>{{ $value->name }}</td>
				  <td>{{ $value->count_game }}</td>
				  <td>{{ $value->count_view }}</td>
				  <td>{{ $value->count_play }}</td>
				  <td>{{ $value->count_download }}</td>
				  <td>{{ getStatusSeoParent($value, 'Type') }}</td>
				  <td>
				  	{{-- <a href="#" class="btn btn-success">Xem</a> --}}
					<a href="{{ action('GameTypeController@edit', $value->id) }}" class="btn btn-primary">Sửa</a>
					@if(!Admin::isSeo())
					{{ Form::open(array('method'=>'DELETE', 'action' => array('GameTypeController@destroy', $value->id), 'style' => 'display: inline-block;')) }}
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


@stop

