
@extends('site.layout.default')

@section('title')
{{ $title='Chính sách' }}
@stop

@section('content')

@if($input_policy)
<div class="box">
	<h3>Chính sách</h3>

	<div class=" ad">
		<h4><b>{{ $input_policy->title }}</b></h4>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-4">
			@include('site.common.message')
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="box-body table-responsive no-padding">
		{{ $input_policy->description }}
	</div>
	<div class="clearfix"></div>
</div>
@endif

@stop