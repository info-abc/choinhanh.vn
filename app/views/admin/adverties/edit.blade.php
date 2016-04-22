@extends('admin.layout.default')

@section('title')
{{ $title='Thêm mới quảng cáo header và footer' }}
@stop

@section('content')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ action('AdvertiseController@index') }} " class="btn btn-success">Danh sách quảng cáo header và footer</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<!-- form start -->
			{{ Form::open(array('action' => array('AdvertiseController@update', $advertise->id), 'method' => 'PUT','files' => true)) }}
			<div class="box-body">
				<div class="form-group">
					<label for="name">Vị trí</label>
					<div class="row">
						<div class="col-sm-6">
						   {{ Form::select('position', [1 => 'Header', 2 => 'Footer'], $advertise->position) }}
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="name">Loại quảng cáo</label>
					<div class="row">
						<div class="col-sm-6">
						   <input name="ad-select" id="ad-select-image" type="radio" onclick="adSelect()" <?php if($advertise->image_url){echo 'checked=""';} ?> value="1"/>
						   <label for="ad-select-image" onclick="adSelect()">Quảng cáo ảnh</label>&nbsp;&nbsp;&nbsp;
						   <input name="ad-select" id="ad-select-adsense" type="radio" onclick="adSelect()"  <?php if($advertise->adsense){echo 'checked=""';} ?> value="2"/>
						   <label for="ad-select-adsense" onclick="adSelect()">Quảng cáo Adsense</label>
						</div>
					</div>
				</div>
				<div class="ad-image">
					<div class="form-group">
						<label for="name">Link</label>
						<div class="row">
							<div class="col-sm-6">
								{{ Form::text('image_link', $advertise->image_link , textParentCategory('Link')) }}
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="name">Image</label>
						<div class="row">
							<div class="col-sm-6">
								{{ Form::file('image_url', array('id' => 'image_url')) }}
								<img src="{{ url(UPLOAD_ADVERTISE . '/header_footer' .'/' .$advertise->id . '/' . $advertise->image_url) }}" ,width="100px", height="100px"  />
							</div>
						</div>
					</div>
				</div>
				<div class="form-group ad-adsense">
					<label for="name">Adsense</label>
					<div class="row">
						<div class="col-sm-6">
							{{ Form::textarea('adsense', $advertise->adsense, textParentCategory('code adsense')) }}
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="name">Thiết bị</label>
					<div class="row">
						<div class="col-sm-6">
						   {{ Form::select('is_mobile', [IS_NOT_MOBILE => 'Desktop', IS_MOBILE => 'Mobile'], $advertise->is_mobile) }}
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="name">Status</label>
					<div class="row">
						<div class="col-sm-6">
						   {{ Form::select('status', [DISABLED => 'Ẩn', ENABLED => 'Hiển thị'], $advertise->status) }}
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
</div>

@include('admin.adverties.script')

@stop
