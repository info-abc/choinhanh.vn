@extends('admin.layout.default')

@section('title')
{{ $title='Thêm mới quảng cáo page Mobile' }}
@stop

@section('content')
<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ action('AdPageMobileController@index') }} " class="btn btn-success">Danh sách quảng cáo page Mobile</a>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<!-- form start -->
			{{ Form::open(array('action' => array('AdPageMobileController@update', $ad->id), 'method' => 'PUT')) }}
			<div class="box-body">
				<div class="form-group">
					<label for="title">Tiều đề</label>
					<div class="row">
						<div class="col-sm-6">
						     {{ Form::text('title', $ad->title , textParentCategory('Tiêu đề')) }}
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="name">Vị trí</label>
					<div class="row">
						<div class="col-sm-6">	                  	
						   {{ Form::select('position', AdCommon::getPositionClassAd(1), $ad->position) }}
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="name">Adsense</label>
					<div class="row">
						<div class="col-sm-6">
							{{ Form::textarea('adsense', $ad->adsense, textParentCategory('code adsense')) }}
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="name">Status</label>
					<div class="row">
						<div class="col-sm-6">	                  	
						   {{ Form::select('status', [DISABLED => 'Ẩn', ENABLED => 'Hiển thị'], $ad->status) }}
						</div>
					</div>
				</div>
			</div>
			<div class="box-footer">
				{{ Form::submit('Lưu lại', array('class' => 'btn btn-primary')) }}
			</div>
			{{ Form::close() }}
		</div>
		<!-- /.box -->
	</div>
</div>
@stop
