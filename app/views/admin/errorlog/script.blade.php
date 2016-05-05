<script>

	function toggle(source) {
		checkboxes = document.getElementsByName('error_id[]');
		for(var i=0, n=checkboxes.length;i<n;i++) {
			checkboxes[i].checked = source.checked;
		}
	}

	function deleteSelected()
	{
		var check = $('input:checkbox:checked.error_id').val();
		if(check) {
			callDeleteSelected();
		} else {
			alert('Bạn chưa chọn!');
		}
	}
	function deleteSelectedAllErrors()
	{
		confirm = confirm('Bạn có chắc chắn muốn xóa?')
		if(confirm) {
			$.ajax({
				type: 'post',
				url: "{{ url('/admin/errors/deleteAll') }}",
				success: function ()
	            {
	                console.log("it Work");
					window.location.reload();
	            }
			});
		}
	}

	function callDeleteSelected()
	{
		var values1 = $('input:checkbox:checked.error_id').map(function () {
		  	return this.value;
		}).get();
	
		confirm = confirm('Bạn có chắc chắn muốn xóa?')
		if(confirm) {
			$.ajax(
			{
				type:'post',
				url: '{{ url("/admin/errors/deleteErrors") }}',
				data:{
					'error_id': values1
				},
				success: function()
				{
					window.location.reload();
				}
			});
		} else {
			window.location.reload();
		}
	}

</script>
