@extends('admin.layout.default')

@section('title')
{{ $title='Sửa game' }}
@stop

@section('content')

{{-- //script for edit game form --}}
@include('admin.game.scriptedit')

<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ action('AdminGameController@index') }}" class="btn btn-success">Danh sách game</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<!-- form start -->
			{{ Form::open(array('action' => array('AdminGameController@update', $inputGame->id), 'method' => 'PUT', 'files' => true)) }}
			<div class="box-footer">
				{{ Form::submit('Lưu lại', array('class' => 'btn btn-primary')) }}
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="box-body">
						<div class="form-group">
							<label for="name">Tên game</label>
							{{ Form::text('name', $inputGame->name , textParentCategory('Tên game')) }}
						</div>
						<div class="form-group">
			                <label>Ngày đăng</label>
			                <input type="text" class="form-control" maxlength="10" name="start_date" id="start_date" value="{{ $inputGame->start_date }}" readonly />
		              	</div>
						<div class="form-group">
			                <label>Chọn category</label>
			                {{ Form::select('parent_id', Game::where('parent_id', NULL)->lists('name', 'id'), $inputGame->parent_id, array('class' => 'form-control', 'readonly' => true)) }}
		              	</div>
						<div class="form-group">
							<label for="">Upload avatar</label>
							{{ Form::file('image_url', array('disabled' => true)) }}
							<img class="image_fb" src="{{ url(UPLOAD_GAME_AVATAR . '/' . $inputGame->image_url) }}" />
						</div>
						<div class="form-group">
							<label for="name">Mô tả</label>
							{{ Form::textarea('description', $inputGame->description, array('class' => 'form-control',"rows"=>6, 'readonly' => true)) }}
						</div>
						<div class="form-group">
							<label for="">Upload game</label>
							<input type="checkbox" id="checkUpload" name="checkUpload" onclick="checkUploadAction();" @if($inputGame->link_upload_game && !$inputGame->link_download) checked="checked" @endif disabled />
							{{ Form::file('link_upload_game', array('id' => 'link_upload_game', 'disabled' => true)) }}
							<strong id="fileNameUpload">{{ $inputGame->link_upload_game }}</strong>
						</div>

						<div class="form-group link_download">
							<label>Link download game</label>
							<input type="checkbox" id="checkLinkDownload" name="checkLinkDownload" onclick="checkLinkDownloadAction();" @if($inputGame->link_download) checked="checked" @endif disabled />
							<input type="text" name="link_download" id="link_download" class="form-control link_download" placeholder="Link download game" value="{{ $inputGame->link_download }}" readonly />
						</div>

						<div class="form-group">
							<label for="">Tên file</label>
							<input type="text" name="link_url" class="form-control" placeholder="Tên game" value="{{ $inputGame->link_url }}" readonly />
						</div>

						<div class="form-group">
							<label for="">Mức ưu tiên</label>
							{{ Form::text('weight_number', $inputGame->weight_number , textParentCategory('Mức ưu tiên')) }}
						</div>

						<div class="form-group blockDisabled">
							<label for="">Cơ chế lưu điểm</label>
							{{ Form::select('score_status', saveScore(), $inputGame->score_status, array('class' => 'form-control blockDisabled', 'readonly' => true)) }}
						</div>

						<div class="form-group">
							<label>Gname</label>
							{{ Form::text('gname', $inputGame->gname , textParentCategory('Gname')) }}
						</div>

		              	<div class="form-group">
			                <label>Trạng thái</label>
			                {{ Form::select('status', selectStatusGame(), $inputGame->status, array('class' => 'form-control', 'readonly' => true)) }}
		              	</div>

		              	<!-- <div class="form-group">
		              				                <label>Slide</label>
		              				                {{ Form::select('slide') }}
		              	</div> -->

						<hr />
						<h1>SEO META</h1>

						{{-- include common/meta.blade.php --}}
						@include('admin.common.meta', array('inputSeo' => $inputSeo, 'pathToImageSeo' => UPLOADIMG . '/'.FOLDER_SEO_GAME.'/'. $inputGame->id . '/'))

					</div>
					<!-- /.box-body -->
				</div>
				<div class="col-sm-6">
					<div class="box-body table-responsive">
						<h4>Chọn thể loại game</h4>
						<div class="overflow-box">
							<table class="table table-bordered">
								<tr>
									<th>Tên thể loại game</th>
									<th>Thể loại chính</th>
									<th>Chọn</th>
								</tr>
								@foreach(Type::all() as $key => $value)
									<tr>
										<td>{{ $value->name }}</td>
										<td>
										 	<input type="radio" name="type_main" value="{{ $value->id }}" id="type_main_{{ $value->id }}" onclick="return false" {{ checkedGameTypeMain($value->id, $inputGame->type_main) }} />
										</td>
										<td>
											<input type="checkbox" onclick="return false" name="type_id[]" value="{{ $value->id }}" {{ checkedGameType($value->id, $inputGame->id) }} />
										</td>
									</tr>
								@endforeach
							</table>
						</div>
					</div>
					{{-- <div class="box-body table-responsive">
						<h4>Chọn chuyên mục</h4>
						<div class="overflow-box">
							<table class="table table-bordered">
								<tr>
									<th>Tên chuyên mục</th>
									<th>Chọn</th>
								</tr> --}}
								{{-- @foreach(CategoryParent::all() as $key => $value) --}}
									{{-- <tr>
										<td>{{ $value->name }}</td>
										<td>
											<input type="checkbox" onclick="return false" name="category_parent_id[]" value="{{ $value->id }}" {{ checkBoxGame($inputGame->id, $value->id) }} />
										</td>
									</tr> --}}
								{{-- @endforeach --}}
							{{-- </table>
						</div>
					</div> --}}
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

{{-- @include('admin.common.ckeditor') --}}

@stop
