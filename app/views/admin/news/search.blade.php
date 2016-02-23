<div class="margin-bottom">
	{{ Form::open(array('action' => 'NewsController@search', 'method' => 'GET')) }}
		<div class="input-group" style="width: 150px; display:inline-block;">
			<label>Tiêu đề</label>
		  	<input type="text" name="title" class="form-control" placeholder="Tiêu đề" />
		</div>
		<div class="input-group" style="width: 150px; display:inline-block;">
			<label>Thể loại</label>
			 {{  Form::select('type_new_id', ['0' => '-- Lựa chọn'] + returnList('TypeNew')  ,null,array('class' => 'form-control' )) }}
		</div>
		<div class="input-group" style="width: 150px; display:inline-block;">
			<label>Sắp xếp theo lượt xem</label>
		  	{{ Form::select('sortByCountView', selectSortBy('count_view'), null, array('class' =>'form-control')) }}
		</div>
		<div class="input-group" style="width: 150px; display:inline-block;">
			<label>Trạng thái Seo</label>
			 {{  Form::select('status_seo', ['' => '-- Lựa chọn'] + selectStatusGame()  ,null,array('class' => 'form-control' )) }}
		</div>
		<div class="input-group" style="width: 150px; display:inline-block;">
			<label>Từ ngày</label>
		  	<input type="text" name="start_date" class="form-control" id="datepickerStartdate" placeholder="Từ ngày" />
		</div>
		<div class="input-group" style="width: 150px; display:inline-block;">
			<label>Đến ngày</label>
		  	<input type="text" name="end_date" class="form-control" id="datepickerEnddate" placeholder="Đến ngày" />
		</div>
		<div class="input-group" style="display: inline-block; vertical-align: bottom;">
			<input type="submit" value="Search" class="btn btn-primary" />
		</div>
	</form>
</div>