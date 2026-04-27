var mouseover_tid = [];
var mouseout_tid = [];
jQuery(document).ready(function(){
    jQuery('#navMenu > li').each(function(index){
        jQuery(this).hover(
            function(){
                var _self = this;
                clearTimeout(mouseout_tid[index]);
                mouseover_tid[index] = setTimeout(function(){
                    var mleft=jQuery(_self).position().left+parseInt(jQuery(_self).find('ul:eq(0)').attr('alt'));
                    jQuery(_self).find('ul:eq(0)').css("left",mleft);
                    jQuery(_self).find('ul:eq(0)').slideDown(0);
                });
            },
            function(){
                var _self = this;
                clearTimeout(mouseover_tid[index]);
                mouseout_tid[index] = setTimeout(function() {jQuery(_self).find('ul:eq(0)').slideUp();});
            }
        );
    });

});

jQuery(document).ready(function(){
    jQuery('.VoteColumnList').each(function(){
        jQuery(this).find('.VoteColumnBar').animate({
            width:jQuery(this).attr('data-percent')
        },4000);
    });
});

var sft,sft_speed;
jQuery(document).ready(function(){
    var sft_speed = 500;//滚动速度
    sft=jQuery('#slider_float_tooler');
});

jQuery(document).ready(function(){
    jQuery('.pagegototop').click(function(){$("html, body").animate({"scroll-top":0},"fast");});
});


jQuery(document).ready(function(){
    jQuery('#searchInput').focus(function(){
        if(jQuery(this).val()=="请输入关键字"){
            jQuery(this).val("");
        }
    });
    jQuery('#searchInput').blur(function(){
        if(jQuery(this).val()==""){
            jQuery(this).val("请输入关键字");
        }
    });
});

jQuery(document).ready(function(){
    $(".btshow_hiden").each(function(){
        $(this).mouseover(function(){
            $(this).children().css("display","block");
        })
        $(this).mouseout(function(){
            $(this).children().css("display","none");
        })
    })
})

//图片滚动 调用方法 imgscroll({speed: 30,amount: 1,dir: "up"});
$.fn.imgscroll = function(o){
    var defaults = {
        speed: 40,
        amount: 0,
        width: 1,
        dir: "left"
    };
    o = $.extend(defaults, o);

    return this.each(function(){
        var _li = $("li", this);
        _li.parent().parent().css({overflow: "hidden", position: "relative"}); //div
        _li.parent().css({margin: "0", padding: "0", overflow: "hidden", position: "relative", "list-style": "none"}); //ul
        _li.css({position: "relative", overflow: "hidden"}); //li
        if(o.dir == "left") _li.css({float: "left"});

        //初始大小
        var _li_size = 0;
        for(var i=0; i<_li.size(); i++)
            _li_size += o.dir == "left" ? _li.eq(i).outerWidth(true) : _li.eq(i).outerHeight(true);

        //循环所需要的元素
        if(o.dir == "left") _li.parent().css({width: (_li_size*3)+"px"});
        _li.parent().empty().append(_li.clone()).append(_li.clone()).append(_li.clone());
        _li = $("li", this);

        //滚动
        var _li_scroll = 0;
        function goto(){
            _li_scroll += o.width;
            if(_li_scroll > _li_size)
            {
                _li_scroll = 0;
                _li.parent().css(o.dir == "left" ? { left : -_li_scroll } : { top : -_li_scroll });
                _li_scroll += o.width;
            }
            _li.parent().animate(o.dir == "left" ? { left : -_li_scroll } : { top : -_li_scroll }, o.amount);
        }

        //开始
        var move = setInterval(function(){ goto(); }, o.speed);
        _li.parent().hover(function(){
            clearInterval(move);
        },function(){
            clearInterval(move);
            move = setInterval(function(){ goto(); }, o.speed);
        });
    });
};

function DoSltJump(o){
    var sltval=$(o).val();
    if(sltval!=""){window.open(sltval);}
    o.selectedIndex=0;
}

function DoCloseWin(){
    window.top.opener = null; window.close();
}

function AddFavorite(){
    if(document.all){
        try{
            window.external.addFavorite(window.location.href,document.title);
        }catch(e){
            alert("加入收藏失败，请使用Ctrl+D进行添加！");
        }
    }else if(window.sidebar){
        window.sidebar.addPanel(document.title, window.location.href, "");
    }else{
        alert("加入收藏失败，请使用Ctrl+D进行添加！");
    }
}

//设为首页
function SetHome(){
    try{
        this.style.behavior='url(#default#homepage)';
        this.setHomePage(window.location.href);
    }catch(e){
        if(window.netscape){
            try{
                netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
            }catch(e){
                alert("抱歉，此操作被浏览器拒绝！'");
            };
        }else{
            alert("抱歉，您所使用的浏览器无法完成此操作。");
        };
    };
};
