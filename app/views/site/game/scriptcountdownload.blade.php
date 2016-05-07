<script type="text/javascript">
	function countdownload(type)
	{
		$.ajax(
		{
			type:'post',
			url: '{{ url("/count-download") }}',
			data: {
				'id': {{ $id }}
			},
			success: function(data){
				if(type == 'android') {
					window.open('{{ $url_android }}', '_blank');
					// location.target = "_blank";
					// location.href = '{{ $url_android }}';
				}
				if(type == 'ios') {
					window.open('{{ $url_ios }}', '_blank');
					// location.target = "_blank";
					// location.href = '{{ $url_ios }}';	
				}
				if(type == 'winphone') {
					window.open('{{ $url_winphone }}', '_blank');
					// location.target = "_blank";
					// location.href = '{{ $url_winphone }}';	
				}
				return;
			},
		});
	}
</script>