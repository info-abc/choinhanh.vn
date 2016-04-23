@extends('admin.layout.default')

@section('title')
{{ $title='Quản lý quảng cáo' }}
@stop

@section('content')
<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ action('AdvertiseController@createChild') }}" class="btn btn-primary">Thêm mới quảng cáo</a>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-header">
		  <h3 class="box-title">Danh sách quảng cáo</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive no-padding">
		  <table class="table table-hover">
			<tr>
			  <th>ID</th>
			  <th>Vị trí</th>
			  <th>Thiết bị</th>
			  <th>Status</th>
			  <th style="width:200px;">Action</th>
			</tr>
			@foreach($advertisePosition as $value)
				<tr>
				  	<td>{{ $value->id }}</td>
				  	<td>{{ CategoryParent::find(CommonModel::find($value->common_model_id)->model_id)->name }}</td>
					<td>{{ AdCommon::getDeviceNameAd(Advertise::find($value->advertisement_id)->is_mobile) }} </td>
					<td>{{ getStatusAdvertise($value->status) }} </td>
					<td>
					<a href="{{  action('AdvertiseController@editChild', [$value->advertisement_id, $value->common_model_id]) }}" class="btn btn-primary">Sửa</a>
						{{ Form::open(array('method'=>'DELETE', 'action' => array('AdvertiseController@destroyChild', $value->advertisement_id), 'style' => 'display: inline-block;')) }}
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

@stop

