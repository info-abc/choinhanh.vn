function countdownload(type, id, urlDirect, urlAndroid, urlIos, urlWinphone)
{
	var dm = window.location.protocol + '//' + window.location.hostname;
	$.ajax(
	{
		type:'post',
		url: dm + '/count-download',
		data: {
			'id': id
		},
		success: function(data){
			if(type == 'android') {
				window.open(urlAndroid, '_blank');
				// location.target = "_blank";
				// location.href = urlAndroid;
			}
			else if(type == 'ios') {
				window.open(urlIos, '_blank');
				// location.target = "_blank";
				// location.href = urlIos;	
			}
			else if(type == 'winphone') {
				window.open(urlWinphone, '_blank');
				// location.target = "_blank";
				// location.href = urlWinphone;	
			}
			else {
				window.open(urlDirect, '_blank');
			}
			return;
		},
	});
}