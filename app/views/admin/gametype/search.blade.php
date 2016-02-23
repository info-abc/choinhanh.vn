<div class="margin-bottom">
	{{ Form::open(array('action' => 'GameTypeController@search', 'method' => 'GET')) }}
		<div class="input-group" style="width: 150px; display:inline-block;">
			<label>Thể loại game</label>
			 {{  Form::select('type_id', ['0' => '-- Lựa chọn'] + returnList('Type')  ,null,array('class' => 'form-control' )) }}
		</div>
		<div class="input-group" style="width: 150px; display:inline-block;">
			<label>Kiểu game</label>
			 {{  Form::select('parent_id', ['0' => '-- Lựa chọn'] + getListCategory()  ,null,array('class' => 'form-control' )) }}
		</div>
		<div class="input-group" style="display: inline-block; vertical-align: bottom;">
			<input type="submit" value="Search" class="btn btn-primary" />
		</div>
	</form>
</div>