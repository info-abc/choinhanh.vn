$(document).ready(function(){
	$('#cssmenu ul ul li:odd').addClass('odd');
	$('#cssmenu ul ul li:even').addClass('even');
	$('#cssmenu > ul > li > a').click(function() {
		$('#cssmenu li').removeClass('active');
		$(this).closest('li').addClass('active');
		var checkElement = $(this).next();
		if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
			$(this).closest('li').removeClass('active');
			checkElement.slideUp('normal');
		}
		if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
			$('#cssmenu ul ul:visible').slideUp('normal');
			checkElement.slideDown('normal');
		}
		if($(this).closest('li').find('ul').children().length == 0) {
			return true;
		} else {
			return false;
		}
	});

	dw_Tooltip.defaultProps = {
        supportTouch: true, // set false by default
        content_source: 'class_id' // class holds id of element with tooltip content
    }

});

function menushow(){
	$('#cssmenu').addClass('menushow');
	$(".glass").css({ display: "block" });
	$("#searchmenu").focus().val("");
}
function menuhide(){
	$('#cssmenu').removeClass('menushow');
	$(".glass").css({ display: "none" });
}

$(document).mouseup(function (e)
{
    var container = $("#cssmenu");

    if (!container.is(e.target)
        && container.has(e.target).length === 0)
    {
        menuhide();
    }
});
