//版权所有 @深圳联雅网络
$(function(){
    if(!placeholderSupport()){   // 判断浏览器是否支持 placeholder
        $('[placeholder]').focus(function() {
            var input = $(this);
            if (input.val() == input.attr('placeholder')) {
                input.val('');
                input.removeClass('placeholder');
            }
        }).blur(function() {
            var input = $(this);
            if (input.val() == '' || input.val() == input.attr('placeholder')) {
                input.addClass('placeholder');
                input.val(input.attr('placeholder'));
            }
        }).blur();
    };
    })
    function placeholderSupport() {
        return 'placeholder' in document.createElement('input');
    }

Element.prototype.addEvent = function(type,fn){
    if(window.addEventListener){
      this.addEventListener(type, fn);
    }else if(window.attachEvent){
      this.attachEvent('on' + type, fn);
    }else{
      this['on' + type] = fn;
    }
}

$(function(){
    // 搜索框
    $('#header .submit').click(function(){
        if (!$('#header .search').hasClass('open')) {
            $('#header .search').addClass('open');
        }else{
            $('#header .search').removeClass('open');
        }
    });
});