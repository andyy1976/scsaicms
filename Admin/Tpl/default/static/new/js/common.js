$(function () {
  //点击icon -导航
  $('.click-icon-nav').click(function(){
   $('.ss-logo, .ss-navbar-default, .ss-contanier').toggleClass('active')
   // $('.ss-contanier').toggleClass('active')
 })
  //Meus 导航栏
  $('.ss-navigation>li').click(function(e){
    if ($(this).find('ul').length){
      $(this).toggleClass('active')
      $(this).siblings('li').removeClass('active')
    }
  })
  $('.other').each(function(index, el) {
    var num = $(this).find('span').text() * 3.6;
    if (num <= 180) {
        $(this).find('.right').css('transform', "rotate(" + num + "deg)");
    } else {
        $(this).find('.right').css('transform', "rotate(180deg)");
        $(this).find('.left').css('transform', "rotate(" + (num - 180) + "deg)");
    };
  })
})