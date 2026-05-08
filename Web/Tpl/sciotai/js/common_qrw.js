 $(function(){
	 //动画
	  wow = new WOW({
            boxClass: 'wow',
            animateClass: 'animated',
            offset: 0,
            mobile: false,
            live: true
        })
        wow.init();
 });

//pc导航
var $i;
var $flag = false;
$("#obtn .sub").hover(function(){
	$flag = true;
},function(){
	$("#obtn .sub[data-m='"+$i+"']").slideUp();
	$("#obtn .menu .nli a[data-n='"+$i+"']").parent().parent().removeClass("active");
	$flag = false;
});
$("#obtn .menu .nli span a").hoverIntent(function(){
	$i = $(this).attr("data-n");
	$("#obtn .sub[data-m='"+$i+"']").slideDown();
	$(this).parent().parent().addClass("active");
},function(){
	if(!$flag){
		$("#obtn .sub[data-m='"+$i+"']").slideUp();
		$(this).parent().parent().removeClass("active");
	}
});
//手机导航
$("#obtn #menuph").click(function(){
	$(this).find(".point").toggleClass("active");
	$("#obtn .xialaph").slideToggle();
	$("#obtn .phonemeng").toggleClass('active');
	$("body,html").animate({
		//scrollobtn:0
	},500);
});
$("#obtn .xialaph h4").click(function(){
	$(this).siblings(".ul2").slideToggle();
	$(this).parent().siblings().find(".ul2,.ul3").slideUp();
	$(this).toggleClass("active");
	$(this).parent().siblings().find("h4,h5").removeClass('active');
});
$("#obtn .xialaph h5").click(function(){
	$(this).siblings(".ul3").slideToggle();
	$(this).parent().siblings().find(".ul3").slideUp();
	$(this).toggleClass("active");
	$(this).parent().siblings().find("h4,h5").removeClass('active');
});
$("#obtn .xialaph .lian h5").click(function(){
	$(this).siblings().toggleClass('active');
});
//返回顶部
$("#obtn .renter").on("click", function () {
	$('body,html').animate({ scrollTop: 0 });
})
 /*内页导航js*/
 $('#obtn .secondBox .currentLeft').click(function(){
	 $(this).stop().toggleClass('on');
	 $(this).next().stop().slideToggle();
 })

 $(window).scroll(function () {
	 if ($(window).scrollTop() >= $('#obtn .head').height() + $('#obtn .iBanner').height() ) {
		 $('#obtn .solSecBox').addClass('on')
	 } else {
		 $('#obtn .solSecBox').removeClass('on')
	 }
 });
 $(document).ready(function(){
	 var p=0,t=0;
	 $(window).scroll(function(e){
		 p = $(this).scrollTop();
		 var scroHei1 = $(window).scrollTop();
		 if(t<=p){//向下滚
			 $('#obtn .head').css('position','fixed');
			 $('#obtn .slideBox').css('top','75px');
			 $('#obtn .solSecBox').css('top','75px');
		 }else{//向上滚
			 if (scroHei1 > 200) {
				 $('#obtn .head').fadeIn(500);
				 $('#obtn .head').css('position','fixed').fadeIn(500);
				 $('#obtn .slideBox').css('top','75px');
				 $('#obtn .solSecBox').css('top','75px');
			 }
			 if (scroHei1 < 200) {
				 $('#obtn .head').css('position','absolute').fadeIn(500);
				 $('#obtn .slideBox').css('top','0');
				 $('#obtn .solSecBox').css('top','0');
			 }
			 if($(window).width()<1024){
				 $('#obtn .slideBox').css('top','63px');
				 $('#obtn .solSecBox').css('top','63px');
			 }
		 }
		 setTimeout(function(){t = p;},0);
	 });
 });

$("#obtn .menu .nli span a").click(function(){
    $(this).parent().parent().addClass("on");
});









