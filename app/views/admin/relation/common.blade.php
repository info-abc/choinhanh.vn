<script type="text/javascript">
	$(function () {
	  getRelationTypeModel(); 
	  getRelationTypeCategory();
	});
	function getRelationTypeModel() {
		var category = $('#type_box_head').val();

		$.ajax({
		type: 'POST',
		data:{category:category},
		url: 'ajax',
			success:function(data) {
				$('#model_id').empty();
					$.each(data ,function(index, value){
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
		url: 'ajax',
			success:function(data) {
				$('#relation_id').empty();
				
					$.each(data ,function(index, value){
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