{{ HTML::script('assets/js/swiper.min.js') }}
{{ HTML::style('assets/css/swiper.min.css') }}
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
<script>
	var swiper = [];
    $('.swiper-container').each(function(index){
        var $el = $(this);
        swiper[index] = $el.swiper({
			threshold: 10,
            pagination: $(this).find('.swiper-pagination'),
	        paginationClickable: $(this).find('.swiper-pagination'),
	        paginationBulletRender: function (index, className) {
	            return '<span class="' + className + '">' + (index + 1) + '</span>';
	        },
			preventClicks: false,
	        preventClicksPropagation: false,
	        preloadImages: false,
	        lazyLoading: true
        })
        swiper[index].on('slideChangeStart', function (){
		    abc = $el.find('.swiper-pagination-bullet-active').text();
			$el.find('.numberPage').html(abc);
	    });
        $el.find('.next').on('click', function(){
			swiper[index].slideNext('onSlideNextStart', 300, function () {
			    abc = $el.find('.swiper-pagination-bullet-active').text();
				$el.find('.numberPage').html(abc);
			});
		});
		$el.find('.prev').on('click', function(){
			swiper[index].slidePrev('onSlidePrevStart', 300, function () {
			    abc = $el.find('.swiper-pagination-bullet-active').text();
				$el.find('.numberPage').html(abc);
			});
		});

    });
</script>