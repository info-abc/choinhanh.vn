@extends('admin.layout.default')

@section('title')
{{ $title='Quản lý Relation' }}
@stop

@section('content')
<!-- inclue Search form 

-->
<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ action('RelationController@create') }}" class="btn btn-primary">Thêm mới Relation</a>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-header">
		  <h3 class="box-title">Danh sách loại Relation</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive no-padding">
		  <table class="table table-hover">
			<tr>
			  <th>ID</th>
			 
			  <th>Thể loại box trên</th>
			   <th>Name box above</th>
			  <th>Thể loại box dưới</th>
			  <th>Tên box dưới</th>
			  <th style="width:200px;">Adcion</th>
			</tr>
			 @foreach($inputRelation as $value)
			<tr>
			  <td>{{ $value->id }}</td>
			  <td>{{ RelationBox::getNameBox($value, 'model_name', 'model_id') }}</td>
			  <td>{{  RelationBox::getCategoryRelation($value->model_id, $value->model_name) }}</td>
			  <td>{{ RelationBox::getNameBox($value, 'relation_name','relation_id') }}</td>
			  <td>{{ RelationBox::getCategoryRelation($value->relation_id, $value->relation_name) }}</td>
			  <td>
				<a href="{{  action('RelationController@edit', $value->id) }}" class="btn btn-primary">Sửa</a>
				{{ Form::open(array('method'=>'DELETE', 'action' => array('RelationController@destroy', $value->id), 'style' => 'display: inline-block;')) }}
				<button class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</button>
				{{ Form::close() }}
			  </td>
			</tr>
			@endforeach
		  </table>
		</div>
		<!-- /.box-body -->
	  </div>
	  <!-- /.box -->
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<ul class="pagination">
		<!-- phan trang -->
		{{ $inputRelation->appends(Request::except('page'))->links() }}
		</ul>
	</div>
</div>

@stop

