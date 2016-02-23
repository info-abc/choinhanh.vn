var TheThumbWidth;
var TheThumbHeight;
var AdDistance;
var SimilarGamesDivWidth;
var ShowSimilarGamesDiv=false;

$(window).resize(function(){
	UpdateAdSize();
	UpdateGameSize();
	UpdateHelpSize();
	$("#adsContainer").height($(window).height()-AdDistance);
});
function UpdateAdSize(){
	if($(window).width()>=728 && $(window).height()>=728){
		AdDistance=90;
		$("#footad").height(90);
	}else if($(window).width()>=480 && $(window).height()>=480){
		AdDistance=50;
		$("#footad").height(50);
	}else if($(window).width()<$(window).height()){
		$("#footad").height(50);
		AdDistance=50;
	}else{
		$("#footad").height(50);
		AdDistance=0;
	}
	if(apptype=="android") {
		$("#footad").height(0);
		AdDistance=0;
	}
	//console.log("AdDistance:",AdDistance,",$('#footad').height():",$("#footad").height());
}
function UpdateSimilarGamesSize(){
	var Width = SimilarGamesDivWidth;
	var Height = $(window).height()-90-AdDistance;
	
	//if(ShowSimilarGamesDiv){
		if(SimilarGamesDivWidth>=400){
			Cols=4;
		}else if(SimilarGamesDivWidth>=300){
			Cols=3;
		}else if(SimilarGamesDivWidth>=140){
			Cols=2;
		}else{
			Cols=1;
		}
		//Cols=parseInt(SimilarGamesDivWidth/100);
		//if(Cols==1&&SimilarGamesDivWidth>=140) Cols=1;
		SimilarGamesDivMarginLeft=0;
	//}else{
	//	Cols=1;
	//	SimilarGamesDivMarginLeft=0;
	//}
	TheThumbWidth=parseInt(Width/Cols-10);
	TheThumbHeight=TheThumbWidth;
	Rows=parseInt(Height/(TheThumbHeight+10));
	while(Rows==1 && TheThumbWidth>70){
		Cols=Cols+1;
		TheThumbWidth=parseInt(Width/Cols-10);
		TheThumbHeight=TheThumbWidth;
		Rows=parseInt(Height/(TheThumbHeight+10));
	}
	if(Rows*Cols>16) Rows=parseInt(16/Cols);
	ContainerWidth=Cols*(TheThumbWidth+10);
	ContainerHeight=Rows*(TheThumbHeight+10)+80;
	
	$("#similargames_container").width(ContainerWidth);
	//$("#similargames_container").height($(window).height()-AdDistance-5);
	$("#similargames_container").height(ContainerHeight);
	$("#similargames").width(ContainerWidth); if(ContainerWidth<200) $("#similargames_title_logo").hide();else $("#similargames_title_logo").show();
	$("#similargames").height(ContainerHeight);

	$("#similargames").css({
		"margin-left":	SimilarGamesDivMarginLeft+"px",
		"padding-top":0
	});
	
	
	//console.log(Width,Height,Rows,Cols,TheThumbWidth,TheThumbHeight,ContainerWidth,ContainerHeight);
	UpdateThumbSize();
	var ThumbsNum=Rows*Cols;
	$(".thumb" ).hide();
	$(".thumb:lt("+ThumbsNum+")").show();
	
	if(ShowSimilarGamesDiv){
		$("#similargames_container").show();
		$('#settingImg').hide();
		$('#CloseSimilarGamesImg').hide();
	}else{
		$("#similargames_container").hide();
		$('#settingImg').show();
		$('#CloseSimilarGamesImg').show();
	}
}
function UpdateGameSize(){
	var Width;
	if($(window).width()>720) Width=$(window).width()-132; else	Width = $(window).width();
	var Height = $(window).height()-AdDistance;
	
	//$("#footad").html(Math.floor(Math.random() * ( 100000 + 1)) + ": " + Width+"x"+Height);
	
	if(thegame_width==0 || thegame_height==0){
		thegame_width=Width;
		thegame_height=Height;
	}
	var TheGameWidth;
	var TheGameHeight;
	var ScreenRatio=Width/Height;
	var GameRatio=thegame_width/thegame_height;
	if( ScreenRatio > GameRatio ){
		TheGameHeight=Height;
		TheGameWidth=parseInt(thegame_width*TheGameHeight/thegame_height);
	}else{
		TheGameWidth=Width;
		TheGameHeight=parseInt(thegame_height*TheGameWidth/thegame_width);
	}
	$("#TheGameDiv").width(TheGameWidth);	
	$("#TheGameDiv").height(TheGameHeight);
	$("#game_frame").width($("#TheGameDiv").width());
	$("#game_frame").height($("#TheGameDiv").height());

	if(($(window).width()-TheGameWidth>130)){
		SimilarGamesDivWidth=$(window).width()-TheGameWidth-30;
		ShowSimilarGamesDiv=true;
	}else{
		if(parseInt($(window).width()/2)>150){
			SimilarGamesDivWidth=150;
		}else{
			SimilarGamesDivWidth=parseInt($(window).width()/2);
		}
		ShowSimilarGamesDiv=false;
	}
	
	var MarginLeft;
	if(ShowSimilarGamesDiv){
		MarginLeft=20+SimilarGamesDivWidth;
	}else{
		MarginLeft=parseInt(($(window).width()-TheGameWidth)/2);
	}
	UpdateSimilarGamesSize();
	var MarginTop=parseInt(($(window).height()-AdDistance-TheGameHeight)/2);
	$("#TheGameDiv").css({
		"margin-left":	MarginLeft+"px",
		"margin-top":	MarginTop+"px"
	});	
	//$("#footad").html(Math.floor(Math.random() * ( 100000 + 1)) + ": " + $(window).width()+ "-" + TheGameWidth + ", " + $(window).height()+ "-" + AdDistance + "-" + TheGameHeight + ", " + TheGameWidth +"x"+TheGameHeight + ", " + $("#TheGameDiv").width()+"x"+$("#TheGameDiv").height() + ", MarginLeft: " + MarginLeft+", MarginTop: "+MarginTop);	
	if(apptype=="android"){
		setTimeout("$('#adsContainer').hide();",6000);
	}else{
		setTimeout("PreRollAd.showGame();",20000);
	}
	//alert(Width+","+Height+","+TheGameWidth+","+TheGameHeight+","+ MarginLeft +","+MarginTop);
	//console.log(($(window).height()-AdDistance));
	$(".GameBottomAd").css({
		"top":	($(window).height()-AdDistance)+"px"
	});	
			
}
function UpdateAdTitleHeight(){
	var Height = $(window).height()-AdDistance;
	$("#adTitle").show().height(Height/2-50);
	$("#adContainer_logo").show();
}

$(document).ready(function()
{	
	$(window).trigger('resize');
	UpdateAdTitleHeight();
	/*if(apptype=="android"){
		
	}else{
		PreRollAd.start();
	}*/
     $('#settingImg').click(function(){
		$("#similargames_container").show();
		$('#settingImg').hide();
	});
	
     $('#CloseSimilarGamesImg').click(function(){
		$("#similargames_container").hide();
		$('#settingImg').show();
	});
     var type = false;
     $("#helpImg").click(function() {
     	if(!type){
			UpdateHelpSize();
			$("#help").show();
			// desc_con_height = $(".desc_con").height();
			// if(desc_con_height > 50){
			// 	$(".all_desc").css('display','block');
			// 	$(".help_desc").height(75);
			// }
			type= true;
     	}else{
     		$("#help").hide();
     		type = false;
     	}	
     });  

     $(".close_help").click(function() {
     	$("#help").hide();
     	type = false;
     });
});
function UpdateHelpSize(){
	// console.log("UpdateHelpSize",$(window).height(),$("#help").height());
	$("#help").css({
		"top":Math.max(0,($(window).height()-$("#help").height()-50)/2)
	});
}
function UpdateThumbSize(){
	//console.log("call UpdateThumbSize",TheThumbWidth,TheThumbHeight);
	$(".thumb").css("width",TheThumbWidth+"px");
	$(".thumb").css("height",TheThumbHeight+"px");
	$(".thumb .GameName").css("width",TheThumbWidth+"px");
	$(".thumb img").css("width",TheThumbWidth+"px");
	$(".thumb img").css("height",TheThumbHeight+"px");
}

function RateGame(id,v){
	$.ajax({  
			url: "/ajax_vote.php?id=" + id +"&v=" + v,
			success: function(msg){
				
		   }
	});
	$('#VoteGameDiv').html("Thank You!");
}