@extends('admin.layout.default')

@section('title')
{{ $title='Thêm mới quảng cáo header và footer' }}
@stop

@section('content')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ action('AdvertiseController@index') }} " class="btn btn-success">Danh sách quảng cáo</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<!-- form start -->
			{{ Form::open(array('action' => array('AdvertiseController@store'), 'files' => true)) }}
			<div class="box-body">
				<div class="form-group">
					<label for="name">Vị trí</label>
					<div class="row">
						<div class="col-sm-6">
						   {{ Form::select('position', [1 => 'Header', 2 => 'Footer']) }}
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="name">Loại quảng cáo</label>
					<div class="row">
						<div class="col-sm-6">
						   <input name="ad-select" id="ad-select-image" type="radio" onclick="adSelect()" checked="" value="1" />
						   <label for="ad-select-image" onclick="adSelect()">Quảng cáo ảnh</label>&nbsp;&nbsp;&nbsp;
						   <input name="ad-select" id="ad-select-adsense" type="radio" onclick="adSelect()" value="2" />
						   <label for="ad-select-adsense" onclick="adSelect()">Quảng cáo Adsense</label>
						</div>
					</div>
				</div>
				<div class="ad-image">
					<div class="form-group">
						<label for="name">Link</label>
						<div class="row">
							<div class="col-sm-6">
								{{ Form::text('image_link', null , textParentCategory('Link')) }}
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="name">Image</label>
						<div class="row">
							<div class="col-sm-6">
								{{ Form::file('image_url', array('id' => 'image_url')) }}
							</div>
						</div>
					</div>
				</div>
				<div class="form-group ad-adsense">
					<label for="name">Adsense</label>
					<div class="row">
						<div class="col-sm-6">
							{{ Form::textarea('adsense', null, textParentCategory('code adsense')) }}
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="name">Thiết bị</label>
					<div class="row">
						<div class="col-sm-6">
						   {{ Form::select('is_mobile', [IS_NOT_MOBILE => 'Desktop', IS_MOBILE => 'Mobile']) }}
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="name">Status</label>
					<div class="row">
						<div class="col-sm-6">
						   {{ Form::select('status', [DISABLED => 'Ẩn', ENABLED => 'Hiển thị']) }}
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
