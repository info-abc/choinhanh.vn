@extends('site.layout.default')

@section('title')
{{ $title='Quên mật khẩu' }}
@stop

@section('content')

<div class="box">
    <h3>Quên mật khẩu</h3>
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-4">
            @include('site.common.message')
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-xs-12">
        {{ Form::open(array('action' => 'PasswordController@store', 'class' => 'form-horizontal', 'id' => 'loginform')) }}
            <div class="form-group">
                <label for="email" class="col-sm-4 control-label label-text">Email (*):</label>
                <div class="col-sm-4">
                    <input id="login-username" type="email" class="form-control" name="email" value="{{ Input::old('email') }}" placeholder="email" required>
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-sm-4 control-label label-text">Mật khẩu (*):</label>
                <div class="col-sm-4">
                    <input id="new_password" type="password" class="form-control" name="new_password" placeholder="password" maxlength="20" minlength="6" required>
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-sm-4 control-label label-text">Nhập lại mật khẩu (*):</label>
                <div class="col-sm-4">
                    <input id="re_password" type="password" class="form-control" name="re_password" placeholder="repeat password" maxlength="20" minlength="6" required>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-4">
                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                    <input type="submit" value="Reset password " id="btn-login" class="btn btn-success" />
                </div>
            </div>

        {{ Form::close() }}
    </div>
    <div class="clearfix"></div>
</div>

@stop