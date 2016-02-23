@extends('admin.layout.default')

@section('title')
{{ $title='Thống kê game' }}
@stop

@section('content')

{{-- //script for index game --}}
@include('admin.game.scriptindex')

<!-- inclue Search form-->
@include('admin.game.search_statistic')


<div class="row">
	<div class="col-xs-12">
		<div class="box">
		<div class="box-header">
			<h3 class="box-title">Danh sách game<strong id="abc"></strong></h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive no-padding">
			<table class="table table-hover">
			<tr>
			
				<th>ID</th>
				<th>Tên game</th>
				<th>TS</th>
				<th>Category</th>
				<th>Lượt xem</th>
				<th>Play/Dowload</th>
				<th>Week before</th>
				<th>Week current</th>
				<th>Month bofore</th>
				<th>Month current</th>
				<th>Vote</th>
				<th>Lượt tải</th>
				<!-- <th>Trạng thái</th> -->
				<th>Ngày đăng</th>
			</tr>
			@foreach($data as $key => $value)
				<tr>
				
					<td>{{ $value->id }}</td>
					<td>{{ $value->name }}</td>
					<td>{{ getZero($value->weight_number) }}</td>
					<td>{{ Game::find($value->parent_id)->name }}</td>
					<td>{{ getZero($value->count_view) }}</td>
					<td>{{ $value->count_play.$value->count_download }}</td>
					<td>{{ $value->total_play_download_before_weekly }}</td>
					<td>{{ $value->total_play_download_current_weekly }}</td>
					<td>{{ $value->total_play_dowload_before_month }}</td>
					<td>{{ $value->total_play_dowload_current_month }}</td>
					<td>{{ getZero($value->count_vote) }}</td>
					<td>{{ getZero($value->count_download) }}</td>
					<!-- <td>{{ getStatusGame($value->status)  }}</td> -->
					<td> 
					@if($value->start_date >= Carbon\Carbon::now())
						<span style="color: red;">{{ $value->start_date }}</span>
					@else
						{{$value->start_date}}
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

<div class="row">
	<div class="col-xs-12">
		<ul class="pagination">
		{{ $data->appends(Request::except('page'))->links() }}
		</ul>
	</div>
</div>

@stop

