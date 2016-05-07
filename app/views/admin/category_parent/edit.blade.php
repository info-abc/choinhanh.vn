@extends('admin.layout.default')

@section('title')
{{ $title='Sửa chuyên mục' }}
@stop

@section('content')

@include('admin.category_parent.common')

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<!-- form start -->
			{{ Form::open(array('action' => array('CategoryParentController@update', $inputCategory->id), 'method' => 'PUT', 'files' => true)) }}
				<div class="row">
					<div class="col-sm-6">
						<div class="box-body">
							<div class="form-group">
								<label for="name">Tên chuyên mục</label>
								{{ Form::text('name', $inputCategory->name , textParentCategory('Tên chuyên mục')) }}
							</div>
								<div class="form-group">
									<label for="name">Chọn vị trí hiển thị</label>
									@if(Request::segment(3) == CONTENT_SEGMENT)
										{{ Form::select('position', [2 => 'Content'], null, array('class' =>'form-control')) }}
										<div class="form-group">
											<label for="name">Sắp xếp theo kiểu</label>
												{{ Form::select('arrange', selectArrange(), $inputCategory->arrange,  array('class' =>'form-control')) }}
										</div>
									@else
										{{ Form::select('position', [1 => 'Menu'], $inputCategory->position, array('class' =>'form-control')) }}
									@endif
								</div>
							@if(!Admin::isSeo())
								<div class="form-group">
									<label for="name">Mức ưu tiên</label>
									{{ Form::select('weight_number', selectWeight_number(), $inputCategory->weight_number ,  array('class' =>'form-control')) }}
								</div>
							@endif
							@if(!Admin::isSeo())
								@if(Request::segment(3) == CONTENT_SEGMENT)
									<div class="form-group">
										<label for="name">Trạng thái</label>
										{{ Form::select('status', selectStatusCategoryParent(), $inputCategory->status ,  array('class' =>'form-control')) }}
									</div>
									<div class="form-group">
										<label for="name">Chọn category</label>
										{{ Form::select('game_id', getListCategory(), $inputgame_category_parent->game_id ,  array('class' =>'form-control')) }}
									</div>
								@else 
									<div class="form-group">
										<label>Trạng thái</label>
										{{ Form::select('status', selectActive(), $inputCategory->status,  array('class' =>'form-control')) }}
									</div>
								@endif
							@endif
							<div class="form-group">
								<label for="name">Trạng thái trong trang tải về</label>
								{{ Form::select('status_child', selectActive(), $inputCategory->status_child,  array('class' =>'form-control')) }}
							</div>
							<hr />
							<h1>SEO META</h1>
							{{-- include common/meta.blade.php --}}
							@include('admin.common.meta', array('inputSeo' => $inputSeo, 'pathToImageSeo' => UPLOADIMG . '/'.FOLDER_SEO_PARENT.'/'. $inputCategory->id . '/'))

						</div>
						<!-- /.box-body -->
					</div>
					@if(!Admin::isSeo())
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
											<td><input type="text" value="{{ getWeightNumberType($value->id, $inputCategory->id) }}" name="weight_number_gametype[{{ $value->id }}]" /></td>
											<td>
												<input type="checkbox" name="type_id[]" value="{{ $value->id }}" {{ checkBoxChecked($value->id, $inputCategory->id) }} />
											</td>
										</tr>
									@endforeach
								</table>
							</div>
						</div>
						@endif
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
