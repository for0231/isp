$(document).ready(function(){
	changeHover();
	serverHover();
	chooseHeight();
	theAdvantagesHeight();
	serverListHover();
	$('.theMyCarousel').hover(function(){
	    $('.slide .carousel-control.right').stop(true,true).animate({opacity:'1',backgroundPositionX:'60%'},300);
	    $('.slide .carousel-control.left').stop(true,true).animate({opacity:'1',backgroundPositionX:'40%'},300)
	},function(){
	    $('.slide .carousel-control.right').stop(true,true).animate({backgroundPositionX:'100%',opacity:0},300);
	    $('.slide .carousel-control.left').stop(true,true).animate({backgroundPositionX:'0',opacity:0},300)
	})
	
})

//bs������click��Ϊhover
function changeHover(){
	$('[data-toggle="dropdown"]').each(function() {
					var $this = $(this),
						$parent = $this.parent();
					$this.off('click.dropdown.data-api');
					$parent.hover(function() {
						$this.dropdown('toggle');
					});
	});
}

//server�����Ԫ��״̬�仯
function serverHover(){
	$(".server-k-li").hover(
		function(){
//			$(this).find(".server-k-li-tj-k").find("p").addClass("server-k-li-tj-k-p-hover");
			$(this).find(".server-k-li-middle-w").find("span").addClass("server-k-li-middle-w-span-hover");
			$(this).find(".server-k-li-button").find("span").addClass("server-k-li-button-span-hover").text("ORDER");	
			$(this).find(".server-k-li-middle-line").css({
				background:"#fff",		
			})
			$(this).css('color','white');
		}
		,
		function(){
//			$(this).find(".server-k-li-tj-k").find("p").removeClass("server-k-li-tj-k-p-hover");
			$(this).find(".server-k-li-middle-w").find("span").removeClass("server-k-li-middle-w-span-hover");
			$(this).find(".server-k-li-button").find("span").removeClass("server-k-li-button-span-hover").text("OUT OF STOCK");	
			$(this).find(".server-k-li-middle-line").css({
				background:"#ccc",		
			})
			$(this).css('color','black');
			
		}
	)	
}


//choose������������ֵȸ�����
function chooseHeight(){
	var xheight = 0;
	$(".choose-xx").find(".the-choose").each(function(){
		var theight = $(this).height();
		//alert(theight);	
		if(theight>xheight){
			xheight = theight;//�߶ȸ�ֵ����ȡ���ֵ
		}
		//alert(xheight);
	});
	$(".choose-xx").find(".the-choose").css({
		height:xheight+"px",
	})
}



//about������ȸ���Ӧ�߶�

function aboutHeight(){
	var theHeight = $(".about-k-zs").height();
	$(".about-k-zs-z").css({
		height:theHeight+"px"
	})
	
}


//server-theAdvantages ��ȡ�ȸ�
function theAdvantagesHeight(){
	var getHeight = 0;
	$(".Advantages-nr").find("p").each(function(){
		var theHeight = $(this).height();
		//alert(theHeight);
		if(theHeight>getHeight){
			getHeight = theHeight;
			//alert(getHeight);
		}
	})
	$(".Advantages-nr").find("p").css({
		height:getHeight+"px",
	})
}

//server-list  HOVERȴ��
function serverListHover(){
	$(".server-list-header-k").find("li").hover(function(){
		var theIndex = $(this).index();
		//alert(theIndex);
		if(theIndex>=0&&theIndex<4){
			$(".server-list-nr").css({display:"none"}).eq(theIndex).css({display:"block"});
		}
	})						
}