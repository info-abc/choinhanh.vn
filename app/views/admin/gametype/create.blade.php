@extends('admin.layout.default')
@if(!Admin::isSeo())
@section('title')
{{ $title='Thêm thể loại game' }}
@stop

@section('content')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ action('GameTypeController@index') }}" class="btn btn-success">Danh sách thể loại game</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<!-- form start -->
			{{ Form::open(array('action' => array('GameTypeController@store'), 'files' => true)) }}
				<div class="row">
					<div class="col-sm-6">
						<div class="box-body">
							<div class="form-group">
								<label for="name">Tên thể loại</label>
								{{ Form::text('name', '' , textParentCategory('Tên thể loại game')) }}
							</div>

							<div class="form-group">
								<label for="image_url">Upload ảnh</label>
								{{ Form::file('image_url') }}
							</div>

							<div class="form-group">
								<label>Trạng thái</label>
								{{ Form::select('status', selectStatusGame(), '', array('class' => 'form-control')) }}
							</div>

							<hr />
							<h1>SEO META</h1>
							{{-- include common/meta.blade.php --}}
							@include('admin.common.meta')

						</div>
						<!-- /.box-body -->
					</div>
					<div class="col-sm-6"></div>
				</div>
				<div class="box-footer">
					{{ Form::submit('Lưu lại', array('class' => 'btn btn-primary')) }}
				</div>
			{{ Form::close() }}
		</div>
	</div>
</div>
@endif
@stop
