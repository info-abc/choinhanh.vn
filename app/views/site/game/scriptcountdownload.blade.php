<script type="text/javascript">
	function countdownload()
	{
		$.ajax(
		{
			type:'post',
			url: '{{ url("/count-download") }}',
			data: {
				'id': {{ $id }}
			},
			success: function(data){
				window.location = '{{ $url }}';
			},
		});
	}
</script>