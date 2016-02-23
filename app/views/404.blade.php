@extends('site.layout.default')

@section('title')
{{ $title='404 Page not found' }}
@stop

@section('content')

<div class="box">
    @include('site.common.boxgame', array('inputSearch' => '', 'text' => 'trang yêu cầu'))
</div>

@stop
