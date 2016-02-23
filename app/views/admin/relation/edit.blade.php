@extends('admin.layout.default')

@section('title')
{{ $title='Sửa Relation' }}
@stop

@section('content')

<script type="text/javascript">
	$(function () {
	  getRelationTypeModel(); 
	  getRelationTypeCategory();
	});
	function getRelationTypeModel() {
		var category = $('#type_box_head').val();

		$.ajax({
		type: 'POST',
		data:{category:category,id:{{$inputRelation->id }}},
		url: '{{ route('ajax.edit', $inputRelation->id) }}',

			success:function(data) {
				$('#model_id').empty();
					$.each(data ,function(index, value){
						if(index == {{$inputRelation->model_id}})
							$('#model_id').append('<option value="'+ index+'" selected>'+value+'</option>');
						else
							$('#model_id').append('<option value="'+ index+'" >'+value+'</option>');
					});

			}
		});
	}
	function getRelationTypeCategory() {
		var category = $('#type_box_botton').val();
		$.ajax({
		type: 'POST',
		data:{category:category},
		url: '{{ route('ajax.edit', $inputRelation->id) }}',
			success:function(data) {
				$('#relation_id').empty();
					$.each(data ,function(index, value){
						if(index == {{$inputRelation->relation_id}})
							$('#relation_id').append('<option value="'+ index+'" selected>'+value+'</option>');
						else
							$('#relation_id').append('<option value="'+ index+'" >'+value+'</option>');
					});
			}
		});
	}

</script>
<div class="row margin-bottom">
	<div class="col-xs-12">
		<a href="{{ action('RelationController@index') }} " class="btn btn-success">Danh sách Relation</a>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<!-- form start -->
			{{ Form::open(array('action' => array('RelationController@update', $inputRelation->id), 'method' => 'PUT', 'files' => true)) }}
			<div class="box-body">
				<div class="form-group">
					<label for="name">Box trên</label>
					<div class="row">
						<div class="col-sm-2">
							Model
						</div>
						<div class="col-sm-2">	 
						   {{  Form::select('model_name', selectRelationType(), 
						   selectEditRelationType($inputRelation, 'model_name', 'model_id')
						   ,array('class' => 'form-control' ,'onchange' => 'getRelationTypeModel()', 'id' =>'type_box_head'))  }}
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
							Model
						</div>
						<div class="col-sm-2">	                  	
						   {{  Form::select('relation_name', selectRelationType(), 
						  selectEditRelationType($inputRelation, 'relation_name', 'relation_id'),
						   array('class' => 'form-control' ,'onchange' => 'getRelationTypeCategory()', 'id' =>'type_box_botton'))  }}
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
