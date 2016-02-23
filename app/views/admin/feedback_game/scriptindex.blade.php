<script>

;

	function toggle(source) {
		checkboxes = document.getElementsByName('feedback_game_id[]');
		for(var i=0, n=checkboxes.length;i<n;i++) {
			checkboxes[i].checked = source.checked;
		}
	}

	function updateFeedbackGame()
	{
		var check = $('input:checkbox:checked.feedback_game_id').val();
		if(!check) 
			alert('Bạn chưa chọn báo lỗi game nào!');
		var values1 = $('input:checkbox:checked.feedback_game_id').map(function () {
			  	return this.value;
			}).get();
		// alert(values1);
		$.ajax(
		{
			type:'post',
			url: '{{ url("/admin/feedback_game/updateIndexData")}}',
			data:{
				'feedback_game_id': values1,
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

	function updateInActive()
	{
		var check = $('input:checkbox:checked.feedback_game_id').val();
		if(!check) 
			alert('Bạn chưa chọn báo lỗi game nào!');
		var values1 = $('input:checkbox:checked.feedback_game_id').map(function () {
			  	return this.value;
			}).get();
		// alert(values1);
		$.ajax(
		{
			type:'post',
			url: '{{ url("/admin/feedback_game/updateInActive")}}',
			data:{
				'feedback_game_id': values1,
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

	function deleteSelected()
	{
		var check = $('input:checkbox:checked.feedback_game_id').val();
		if(check) {
			callDeleteSelected();
		} else {
			alert('Bạn chưa chọn comment nào!');
		}
	}

	function callDeleteSelected()
	{
		confirm = confirm('Bạn có chắc chắn muốn xóa?')
		if(confirm) {
			var values1 = $('input:checkbox:checked.feedback_game_id').map(function () {
			  	return this.value;
			}).get();

			$.ajax(
			{
				type:'post',
				url: '/admin/comment/deleteSelected',
				data:{
					'feedback_game_id': values1
				},
				success: function(data)
				{
					if(data) {
						window.location.reload();
					}
				}
			});
		} else {
			window.location.reload();
		}
	}

</script>