@extends('site.layout.default', array('page404' => 1))

@section('title')
	{{ $title='Bạn đã truy cập trang game báo lỗi 404 vui lòng thử lại' }}
@stop

@section('content')

<div class="box">
    @include('site.common.boxgame', array('inputSearch' => '', 'text' => 'trang yêu cầu'))
</div>

@stop
