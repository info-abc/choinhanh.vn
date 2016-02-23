<script type="text/javascript">
function updateScore()
	{
	var values1 = $('input[name^=id]').map(function () {
		  	return this.value;
		}).get();
		var values2 = $('select[name^="status"]').map(function () {
		  	return this.value;
		}).get();
		$.ajax(
		{
			type:'post',
			url: "{{ url('/admin/score/updateScore') }}",
			data:{
				'id': values1,
				'status': values2,
			},
			success: function(data)
			{
				if(data) {
					window.location.reload();
				}
			}
		});
		// window.location.reload();
	}
</script>