<div class="margin-bottom">
    {{ Form::open(array('action' => 'ScoreManagerController@search', 'method' => 'GET')) }}
        <div class="input-group" style="width: 150px; display:inline-block;">
            <label>Tài khoản</label>
            <input type="text" name="user_name" class="form-control" placeholder="Tài khoản" />
        </div>
        <div class="input-group" style="width: 150px; display:inline-block;">
            <label>Game</label>
            <input type="text" name="game_name" class="form-control" placeholder="Tài khoản" />
        </div>
        <div class="input-group" style="width: 150px; display:inline-block;">
            <label>Sắp xếp điểm</label>
            {{ Form::select('sortByScore', orderByScore(), null, array('class' =>'form-control')) }}
        </div>
         <div class="input-group" style="width: 150px; display:inline-block;">
            <label>Trạng thái</label>
            {{ Form::select('status', ['' => '--chọn' ]+selectActive(), null, array('class' =>'form-control')) }}
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
    {{ Form::close() }}
</div>