<div class="margin-bottom">
	{{ Form::open(array('action' => 'ManagerController@searchHistory', 'method' => 'GET')) }}
		<div class="input-group" style="width: 150px; display:inline-block;">
			<label>Từ ngày </label>
		  	<input type="text" name="start_date" class="form-control" id="start_date" placeholder="Từ ngày" />
		</div>
		<div class="input-group" style="width: 150px; display:inline-block;">
			<label>Đến ngày</label>
		  	<input type="text" name="end_date" class="form-control" id="end_date" placeholder="Đến ngày" />
		</div>
		<div class="input-group" style="display: inline-block; vertical-align: bottom;">
			<input type="submit" value="Search" class="btn btn-primary" />
		</div>
	{{ Form::close() }}
</div>