function countplay(id, urlRedirect)
{
	var dm = window.location.protocol + '//' + window.location.hostname;
	$.ajax(
	{
		type:'post',
		url: dm + '/count-play',
		data: {
			'id': id
		},
		success: function(data){
			window.location = urlRedirect;
		},
	});
}