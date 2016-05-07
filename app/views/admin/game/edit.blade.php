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
		@if(!Admin::isSeo())
		<a href="{{ action('AdminGameController@create') }}" class="btn btn-primary">Thêm game</a>
		@endif
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
							<label for="name">Tên game</label><br>
							<span style="font-size:10px;">Tổng số chữ: <label id="divID"  style="color:red;"></label></span>
							{{ Form::text('name', $inputGame->name , textParentCategory('Tên game','','name_game')) }}
						</div>
						<div class="form-group">
			                <label>Lịch xuất bản</label>
			                <input type="text" class="form-control" maxlength="10" name="start_date" id="start_date" value="{{ $inputGame->start_date }}">
		              	</div>
						<div class="form-group">
			                <label>Chọn category</label>
			                {{ Form::select('parent_id', Game::where('parent_id', NULL)->lists('name', 'id'), $inputGame->parent_id, array('class' => 'form-control', 'onchange' => 'getFormGameOffline()')) }}
		              	</div>
						<div class="form-group">
							<label for="">Upload avatar</label>
							{{ Form::file('image_url') }}
							<img class="image_fb" src="{{ url(UPLOAD_GAME_AVATAR . '/' . $inputGame->image_url) }}" />
						</div>
					</div>
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
										 	<input type="radio" name="type_main" value="{{ $value->id }}" id="type_main_{{ $value->id }}" onclick="checkTypeMain({{ $value->id }});" {{ checkedGameTypeMain($value->id, $inputGame->type_main) }} />
										</td>
										<td>
											<input type="checkbox" name="type_id[]" value="{{ $value->id }}" id="type_id_{{ $value->id }}" onclick="checkType({{ $value->id }});" {{ checkedGameType($value->id, $inputGame->id) }} />
										</td>
									</tr>
								@endforeach
							</table>
						</div>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="box-body">
						<div class="form-group">
							<label for="name">Mô tả</label>
							{{ Form::textarea('description', $inputGame->description, array('class' => 'form-control',"rows"=>6, 'id' => 'editor1')) }}
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="box-body">
						<div class="form-group">
							<label for="">Upload game</label>
							<input type="checkbox" id="checkUpload" name="checkUpload" onclick="checkUploadAction();" @if($inputGame->link_upload_game && !$inputGame->link_download) checked="checked" disabled @endif  />
							{{ Form::file('link_upload_game', array('id' => 'link_upload_game')) }}
							<strong id="fileNameUpload">{{ $inputGame->link_upload_game }}</strong>
						</div>

						<div class="form-group link_download">
							<label>Link download game</label>
							<input type="checkbox" id="checkLinkDownload" name="checkLinkDownload" onclick="checkLinkDownloadAction();" @if($inputGame->link_download) checked="checked"  disabled @endif />
							<input type="text" name="link_download" id="link_download" class="form-control link_download" placeholder="Link download game" value="{{ $inputGame->link_download }}" />
							<input type="text" name="link_download_ios" id="link_download_ios" class="form-control link_download" placeholder="Link download game ios" value="{{ $inputGame->link_download_ios }}" />
							<input type="text" name="link_download_winphone" id="link_download_winphone" class="form-control link_download" placeholder="Link download game winphone" value="{{ $inputGame->link_download_winphone }}" />
						</div>

						<div class="form-group">
							<label for="">Tên file</label>
							<input type="text" name="link_url" class="form-control" placeholder="Tên game" value="{{ $inputGame->link_url }}" />
						</div>

						<div class="form-group">
							<label for="">Mức ưu tiên</label>
							{{ Form::text('weight_number', $inputGame->weight_number , textParentCategory('Mức ưu tiên')) }}
						</div>

						<div class="form-group blockDisabled">
							<label for="">Cơ chế lưu điểm</label>
							{{ Form::select('score_status', saveScore(), $inputGame->score_status, array('class' => 'form-control blockDisabled')) }}
						</div>

						<div class="form-group">
							<label>Gname</label>
							{{ Form::text('gname', $inputGame->gname , textParentCategory('Gname')) }}
						</div>

		              	<div class="form-group">
			                <label>Trạng thái</label>
			                {{ Form::select('status', selectStatusGame(), $inputGame->status, array('class' => 'form-control')) }}
		              	</div>
		              	<div class="ui-widget">
			                <label>Slide</label>
			                {{ Form::select('slide_id', ['' => 'No slide'] +CommonGame::getSlide(), $inputGame->slide_id, array('id' => 'combobox')) }}
		              	</div>
		              	<div class="box-body table-responsive">
							<h4>Khung game</h4>
							<div class="overflow-box">
								<table class="table table-bordered">
									<tr>
										<th>Width</th>
										<th>Height</th>
									</tr>
									<tr>
										<td>
											 {{ Form::text('width', $inputGame->width , textParentCategory('Width fix to px')) }}
										</td>
										<td>
											{{ Form::text('height', $inputGame->height , textParentCategory('Height fix to px')) }}
										</td>
									</tr>
								</table>
							</div>
						</div>

						<div class="form-group">
							<label>Link game redirect</label>
							{{ Form::text('link_game_redirect', $inputGame->link_game_redirect , textParentCategory('')) }}
						</div>

						<div class="form-group">
			                <label>Kiểu xoay màn hình</label>
			                {{ Form::select('screen', selectScreenGame(), $inputGame->screen, array('class' => 'form-control')) }}
		              	</div>

		              	<div class="form-group">
							<label>Tags</label>
							{{ Form::select('tag_id[]', AdminTag::orderBy('id', 'desc')->lists('name', 'id'), GameTag::where('game_id', $inputGame->id)->lists('tag_id'), array('class' => 'form-control', 'multiple' => true, 'style' => 'height: 200px;', 'id' => 'mysel')) }}
						</div>

						<hr />
						<h1>SEO META</h1>

						{{-- include common/meta.blade.php --}}
						@include('admin.common.meta', array('inputSeo' => $inputSeo, 'pathToImageSeo' => UPLOADIMG . '/'.FOLDER_SEO_GAME.'/'. $inputGame->id . '/'))

					</div>
					<!-- /.box-body -->
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
											<input type="checkbox" name="category_parent_id[]" value="{{ $value->id }}" {{ checkBoxGame($inputGame->id, $value->id) }} />
										</td>
									</tr> --}}
								{{-- @endforeach --}}
							{{-- </table>
						</div>
					</div> --}}
			</div>
			<div class="box-footer">
				{{ Form::submit('Lưu lại', array('class' => 'btn btn-primary')) }}
			</div>
			{{ Form::close() }}
		</div>
		<!-- /.box -->
	</div>
</div>

@include('admin.common.ckeditor')

@stop
