@extends('admin.layout.default')

@section('title')
{{ $title='Thêm chuyên mục' }}
@stop

@section('content')

@include('admin.category_parent.common')

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<!-- form start -->
			{{ Form::open(array('action' => array('CategoryParentController@store'), 'files' => true)) }}
				<div class="row">
					<div class="col-sm-6">
						<div class="box-body">
							<div class="form-group">
								<label for="name">Tên chuyên mục</label>
								{{ Form::text('name', null , textParentCategory('Tên chuyên mục')) }}
							</div>
							<div class="form-group">
								<label for="name">Vị trí hiển thị</label>
								@if(Request::segment(3) == CONTENT_SEGMENT)
									{{ Form::select('position', [2 => 'Content'], null, array('class' =>'form-control')) }}
									<div class="form-group">
										<label for="name">Sắp xếp theo kiểu</label>
											{{ Form::select('arrange', selectArrange(), null,  array('class' =>'form-control')) }}
									</div>
								@else
									{{ Form::select('position', [1 => 'Menu'], null, array('class' =>'form-control')) }}
								@endif
							</div>
							<div class="form-group">
								<label for="name">Mức ưu tiên</label>
									{{ Form::select('weight_number', selectWeight_number(), null,  array('class' =>'form-control')) }}
							</div>
							
							@if(Request::segment(3) == CONTENT_SEGMENT)
								<div class="form-group">
									<label for="name">Trạng thái</label>
									{{ Form::select('status', selectStatusCategoryParent(), null,  array('class' =>'form-control')) }}
								</div>
								<div class="form-group">
									<label for="name">Chọn category</label>
									{{ Form::select('game_id', getListCategory(), null,  array('class' =>'form-control')) }}
								</div>
							@else 
								<div class="form-group">
									<label for="name">Trạng thái</label>
									{{ Form::select('status', selectActive(), null,  array('class' =>'form-control')) }}
								</div>
							@endif
							<div class="form-group">
								<label>Trạng thái trong trang tải về</label>
								{{ Form::select('status_child', selectActive(), null,  array('class' =>'form-control')) }}
							</div>
							<hr />
							<h1>SEO META</h1>
							{{-- include common/meta.blade.php --}}
							@include('admin.common.meta')

						</div>
						<!-- /.box-body -->
					</div>
					@if(Request::segment(3) != CONTENT_SEGMENT)
					<div class="col-sm-6">
						<div class="box-body table-responsive no-padding">
							<table class="table table-bordered">
								<tr>
									<th>Tên thể loại game</th>
									<th style="width: 10px;">Mức ưu tiên</th>
									<th>Chọn</th>
								</tr>
								@foreach(Type::all() as $key => $value)
									<tr>
										<td>{{ $value->name }}</td>
										<td><input type="text" value="" name="weight_number_gametype[{{ $value->id }}]" /></td>
										<td>
											<input type="checkbox" name="type_id[]" value="{{ $value->id }}" />
										</td>
									</tr>
								@endforeach
							</table>
						</div>
					</div>
					@endif
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
