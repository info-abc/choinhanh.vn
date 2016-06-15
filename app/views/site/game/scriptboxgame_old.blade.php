<style rel="stylesheet" type="text/css" media="all">
	.boxgame-pagination {
		border: 1px solid #474747;
	    border-radius: 5px;
	    text-align: center;
	}
	.boxgame-pagination a {
		color: #474747;
	    cursor: pointer;
	    display: inline-block;
	    font-weight: bold;
	    padding: 10px;
	    text-decoration: none;
	}
	.boxgame-pagination .prev {
		float: left;
	}
	.boxgame-pagination .next {
		float: right;
	}
	.boxgame-pagination .boxgame-pagenumber {
		border-left: 1px solid #474747;
	    border-right: 1px solid #474747;
	    display: inline-block;
	    font-weight: bold;
	    padding: 10px;
	}
	.boxgame-pagination span {

	}
	.swiper-pagination {
		display: none !important;
	}
</style>
<script type="text/javascript">
	$(function () {
		
	});
	function loadGameBox(view, orderBy, device, i)
	{
		$.ajax(
		{
			type:'post',
			url: '{{ url("/loadGameBox") }}',
			data: {
				'view': view,
				'orderBy': orderBy,
				'device': device,
				'i': i,
			},
			success: function(data){
				$('#boxgame-wrapper-1').html(data);
			},
		});
	}
	function loadGamePrev(view, orderBy, device)
	{
		var i = parseInt($('.numberPage1').text());
		if(i>1) {
			//change text
			i--;
			$('.numberPage1').text(i);
			//load game
			loadGameBox(view, orderBy, device, i);
		}
	}
	function loadGameNext(view, orderBy, device)
	{
		var i = parseInt($('.numberPage1').text());
		var count = parseInt($('.totalNumberPage1').text());
		if(i<count) {
			//change text
			i++;
			$('.numberPage1').text(i);
			//load game
			loadGameBox(view, orderBy, device, i);
		}
	}

</script>