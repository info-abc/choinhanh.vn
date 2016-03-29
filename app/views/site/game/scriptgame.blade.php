{{ HTML::script('assets/js/owl.carousel.js') }}
{{ HTML::style('assets/css/owl.carousel.css') }}
{{ HTML::style('assets/css/owl.theme.css') }}

<style>
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
	.owl-theme .owl-controls {
		display: none !important;
	}
</style>
<script>
	$(document).ready(function() {
	    var owl1 = $("#owl1");
	    var owl2 = $("#owl2");
		$(".owl-carousel").owlCarousel({
			navigation : false,
			slideSpeed : 100,
			autoPlay: false,
			paginationSpeed : 100,
			pagination: true,
			singleItem : true,
			paginationNumbers:true,
			rewindNav: false
		});

	  	getNumberPage();

	    // Custom Navigation Events
		$("#next1").click(function(){
			owl1.trigger('owl.next');
			getNumberPage();
		})
		$("#prev1").click(function(){
			owl1.trigger('owl.prev');
			getNumberPage();
		})
		$("#next2").click(function(){
			owl2.trigger('owl.next');
			getNumberPage();
		})
		$("#prev2").click(function(){
			owl2.trigger('owl.prev');
			getNumberPage();
		})

	});

	function getNumberPage() {
		abc1 = $('#owl1 span.owl-numbers').parent('.active').text();
		$('#numberPage1').html(abc1);
		abc2 = $('#owl2 span.owl-numbers').parent('.active').text();
		$('#numberPage2').html(abc2);
	}
</script>