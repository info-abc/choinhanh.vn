@extends('admin.layout.default')

@section('title')
{{ $title='Thêm mới Relation' }}
@stop

@section('content')

@include('admin.relation.common')


<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<!-- form start -->
			{{ Form::open(array('action' => array('RelationController@store'))) }}
			<div class="box-body">
				<div class="form-group">
					<label for="name">Box trên</label>
					<div class="row">
						<div class="col-sm-2">
							Parent
						</div>
						<div class="col-sm-2">	                  	
						   {{  Form::select('model_name', selectRelationType(),null,array('class' => 'form-control' ,'onchange' => 'getRelationTypeModel()', 'id' =>'type_box_head'))  }}
						</div>
						<div class="col-sm-2  ">	                  	
						    <select name="model_id" id="model_id" class="form-control">
						    	
						    </select>
						
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="name">Box dưới</label>
					<div class="row">
						<div class="col-sm-2">
							Game 
						</div>
						<div class="col-sm-2">	                  	
						   {{  Form::select('relation_name', selectRelationType(),null,array('class' => 'form-control' ,'onchange' => 'getRelationTypeCategory()', 'id' =>'type_box_botton'))  }}
						</div>
						<div class="col-sm-2">	                  	
						   <select name="relation_id" id="relation_id" class="form-control">
						    	
						    </select>
						</div>
					</div>
				</div>
			  <!-- /.box-body -->

			  <div class="box-footer">
				{{ Form::submit('Lưu lại', array('class' => 'btn btn-primary')) }}
			  </div>
			{{ Form::close() }}
		  </div>
		  <!-- /.box -->
	</div>
</div>
@stop
