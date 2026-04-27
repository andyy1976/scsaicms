//搜索下拉选择
$(function(){
	
	$(".language .select").click(function(){
		var ul=$(".language .list");
		if(ul.css("display")=="none"){
			ul.slideDown();
		}else{
			ul.slideUp();
		}
	});
	
	$(".language .list p").click(function(){
		var li=$(this).text();
		$(".language .select span").text(li);
		$(".language .list").hide();
  
	});
	
});

//最新动态滚动
$(function(){
    var $this = $(".scroll");
    var scrollTimer;
    $this.hover(function(){
          clearInterval(scrollTimer);
     },function(){
       scrollTimer = setInterval(function(){
                   scrollContent( $this );
                },2000 );
    }).trigger("mouseout");
});
function scrollContent(obj){
       var $self = obj.find("ul:first");
       var lineHeight = $self.find("li:first").height(); //获取行高 
           $self.animate({ "margin-top" : -lineHeight +"px" },1000 , function(){
           $self.css({"margin-top":"0px"}).find("li:first").appendTo($self); //appendTo能直接移动元素而不是复制，被appendto的元素位置发生变化 
     }) 
}


//业务指引-正文tag切换
$(function(){
	$(".business .menu ul li").mousedown(function(){
		$(this).addClass('active').siblings().removeClass('active');
		var index = $(this).index();
		number = index;
		$('.business .m-what').hide();
		$('.business .m-what:eq('+index+')').show();
	});

});

//查看详情弹层
$(function(){
	
	$('.list-block .cdc_bottom').click(function(event){
		$('.box-xq').fadeIn();
		$('.modal-close').click(function(){
			$('.box-xq').fadeOut();
		});
	});
	
});

//实务课堂左侧导航
$(document).ready(function(){
	
	$(".left-menu .heats").click(function(){
		
		if($(this).siblings('ul').css('display')=='none'){
			
				$(this).addClass('up');
				$(this).siblings('ul').slideDown(300);
				
				if($(this).siblings('ul').css('display')=='block'){
					
					$(this).parent('li').siblings('li').find('div').removeClass('up');
					$(this).parent('li').siblings('li').find('ul').slideUp(300);
				}
				
			}else{
				//控制箭头旋转180°
				$(this).removeClass('up');
				//控制箭头还原
				$(this).siblings('ul').slideUp(300);
			}
		
	});

});


//专家展开收缩
$(document).ready(function(){
	
	$(".open-retract").click(function(){
		$(this).toggleClass("k-open");
		if($(".connect").css("bottom")=="-347px"){
			$(".connect").animate({bottom:'0'},200);
		}else{
			$(".connect").animate({bottom:'-347px'},200);
		};
	});

});

/*
//关联案例弹层
$(function()
{
	
	$('.al-tc').click(function(event)
	{
	//	alert("a");
	
		$('.box-al').fadeIn();
		$('.pul-close').click(function(){
			$('.box-al').fadeOut();
		});
	});
	
});
	
	
//关联法规弹层
$(function()
{
	
	$('.fg-tc').click(function(event)
	{
	alert("a");
	
		$('.box-fg').fadeIn();
		$('.pul-close').click(function(){
			$('.box-fg').fadeOut();
		});
	});
	
});
*/

//登录弹层
$(function(){
	
	$('.dl-tc').click(function(event)
	{
	//	alert("a");
	
		$('.box-dl').fadeIn();
		$('.pul-close').click(function(){
			$('.box-dl').fadeOut();
		});
	});
	
});
//注册弹层
$(function()
{
	
	$('.zc-tc').click(function(event)
	{
		$('.box-dl').fadeOut();
		$('.box-zc').fadeIn();
		$('.pul-close').click(function(){
			$('.box-zc').fadeOut();
		});
	});
	
});


