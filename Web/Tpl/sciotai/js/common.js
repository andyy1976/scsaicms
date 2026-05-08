
var Modal = {
    $html: $("html"),
    $body: $(document.body),
    originalBodyPad: null,
    scrollbarWidth: 0,
    show: function () {
        this.checkScrollbar()
        this.setScrollbar()
        this.$html.addClass('modal-open')
    },
    hide: function () {
        this.$html.removeClass('modal-open')
        this.resetScrollbar();
    },
    checkScrollbar: function () {
        var fullWindowWidth = window.innerWidth
        if (!fullWindowWidth) { // workaround for missing window.innerWidth in IE8
            var documentElementRect = document.documentElement.getBoundingClientRect();
            fullWindowWidth = documentElementRect.right - Math.abs(documentElementRect.left);
        }
        this.bodyIsOverflowing = document.body.clientWidth < fullWindowWidth;
        this.scrollbarWidth = this.measureScrollbar();
    },
    setScrollbar: function () {
        var bodyPad = parseInt((this.$body.css('padding-right') || 0), 10)
        this.originalBodyPad = document.body.style.paddingRight || ''
        if (this.bodyIsOverflowing) this.$body.css('padding-right', bodyPad + this.scrollbarWidth)
    },
    measureScrollbar: function () {
        var scrollDiv = document.createElement('div');
        scrollDiv.className = 'modal-scrollbar-measure';
        this.$body.append(scrollDiv);
        var scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth;
        this.$body[0].removeChild(scrollDiv);
        return scrollbarWidth;
    },
    resetScrollbar: function () {
        this.$body.css('padding-right', this.originalBodyPad);
    }
}



function yxtop() {
    var test = (window.location.href).split('tp=');
    if (!isNaN(test[1])) {
        $("html,body").animate({
            scrollTop: $('[yxdatop-pags="' + test[1] + '"]').offset().top - 120
        }, 700);
    }
};

function yxtops() {
    var test = (window.location.href).split('slid=');
    if (!isNaN(test[1])) {
        $("html,body").animate({
            scrollTop: $('[yxdatop-pag="' + test[1] + '"]').offset().top - 90
        }, 700);
    }
};
// ph导航
$("#menuph").click(function () {
    $(this).find(".point").toggleClass("active");
    $(".xialaph").slideToggle();
    $(".phonemeng").toggleClass('active');
    $("body,html").animate({
        scrollTop: 0
    }, 500);
});
// ph导航二级
$(".xialaph  h4").click(function () {
    $(this).siblings(".ul2").slideToggle();
    $(this).parent().parent().siblings().find(".ul2").slideUp();
    $(this).toggleClass("active");
    $(this).parent().parent().siblings().find("h4,h5").removeClass('active');
});
/*ph导航三级*/
$(".xialaph h5").click(function () {
    $(this).siblings(".ul3").slideToggle();
    $(this).parent().siblings().find(".ul3").slideUp();
    $(this).toggleClass("active");
    $(this).parent().siblings().find("h4,h5").removeClass('active');
});
// pc下拉
$('.he_synavli').hover(function () {
    $(this).find('.he_sypcuna').stop().slideDown();
}, function () {
    $(this).find('.he_sypcuna').stop().slideUp();
})
// 导航吸顶
$(window).on('scroll', function () {
    if ($(window).scrollTop() > 0) {
        $(".g_syhead").stop().addClass('on');
    } else {
        $(".g_syhead").stop().removeClass('on');
    }
});
$(window).on('scroll', function () {
    if ($(window).scrollTop() > 0) {
        $(".header2").stop().addClass('on');
    } else {
        $(".header2").stop().removeClass('on');
    }
});
// 头部搜索
$('.he_searig').click(function () {
    $(this).siblings('.mc_search_xl').slideToggle();
})
var isShow = false;
$(".he_searig").click(function (e) {
    e.stopPropagation();
    if (!isShow) {
        $(this).addClass("isshow");
        $(this).find(".mc_search_xl").stop().slideDown().addClass("show");
        isShow = true;
    } else {
        $(this).removeClass("isshow");
        $(this).find(".mc_search_xl").stop().slideUp().removeClass("show");
        isShow = false;
    }
})
$(".mc_search_xl").click(function (e) {
    e.stopPropagation();
})

$(".mc_search_xl").mouseleave(function () {
    $(this).parents(".he_searig").removeClass("isshow");
    $(this).stop().slideUp().removeClass("show");
    isShow = false;
})

// top
$('.he_cenavli4').click(function () {
    $("html,body").animate({
        scrollTop: 0
    }, 1000);
});

$(function () {
    asideNav();
})

function asideNav() {

    asideShow();

    $(window).resize(function () {
        asideShow();
    })

    $(window).scroll(function () {
        asideShow();
    })

    function asideShow() {
        var top = $(".he_main").offset().top - $(window).height() / 2 + $(".he_cenav").height() / 2;
        var top2 = $(".he_ft").offset().top - $(window).height() / 2 - $(".he_cenav").height() / 2;
        if ($(window).scrollTop() > top && $(window).scrollTop() < top2) {
            $(".he_cenav").addClass("he_show");
        } else {
            $(".he_cenav").removeClass("he_show");
        }
    }
}



// 资讯弹窗

// if ($(window).width() > 768) {

// $(function () {
//     timea = setInterval(function () {
//         $('.he_zixun').fadeIn();
//         Modal.show();
//     }, 120000);
//     $('.he_ganb').click(function () {
//         var timea = null;
//         $('.he_zixun').fadeOut();
//         clearInterval(timea);
//         Modal.hide();
//     });
//     $('.he_zixshri').click(function () {
//         var timea = null;
//         $('.he_zixun').fadeOut();
//         clearInterval(timea);
//         Modal.hide();
//     })
// })
// }

// 导航案例切换
$('.he_solutuli').hover(function () {
    var pag = $(this).attr('data-num');
    $('.he_solrihvb').siblings('.he_solrihvb').stop().removeClass('active');
    $('.he_solrihvb[data-num="' + pag + '"]').stop().addClass('active');
    $(this).stop().addClass('yxnav_active2 ');
    $(this).siblings().stop().removeClass('yxnav_active2 ');
});

// 案例滚动条
$(function () {
    var scrollInertiaNum;
    if (/firefox/.test(navigator.userAgent.toLowerCase())) {
        scrollInertiaNum = 200;
    } else {
        scrollInertiaNum = 200;
    }
    $(".he_solrili1").mCustomScrollbar({
        theme: 'dark',
        scrollInertia: scrollInertiaNum,
        horizontalScroll: false,
        axis: "y",
    });
});

$('.he_plnavli').click(function () {
    $(this).addClass('yxnav_active2');
    $(this).siblings('.he_plnavli').removeClass('yxnav_active2')
})



$('.he_xjbtn').click(function () {
    $('.he_obtain').fadeIn();
    Modal.show();
})


if ($(window).width() < 1025) {

    $('.g_ftnav').click(function(){
        $(this).toggleClass('on');
        $(this).siblings('.g_ftnav').removeClass('on');
        $(this).find('.he_navfu').slideToggle();
        $(this).siblings('.g_ftnav').find('.he_navfu').slideUp();
    })

}

$('.he_obtagb').click(function(){
    $('.he_obtain').fadeOut();
    Modal.hide();
})



    // 滚动条
    $(function () {
        var scrollInertiaNum;
        if (/firefox/.test(navigator.userAgent.toLowerCase())) {
            scrollInertiaNum = 350;
        } else {
            scrollInertiaNum = 350;
        }
        $(".he_h3pjur").mCustomScrollbar({
            theme: 'dark',
            scrollInertia: scrollInertiaNum,
            horizontalScroll: false,
            axis: "y",
        });
    });


$('.he_cenavli3 .he_cenavjl').click(function(){
    Modal.show();
})

$('.tans').click(function(){
    Modal.show();
})

$('.he_h3p3ubin').click(function (e) {
    e.stopPropagation();
    $(this).siblings('.he_h3p3xl').slideToggle();
    $(this).parents('.he_h3p3li').toggleClass('on');
    $(this).parents('.he_h3p3li').siblings('.he_h3p3li').find('.he_h3p3xl').slideUp();
    $(this).parents('.he_h3p3li').siblings('.he_h3p3li').removeClass('on');
})
$('body').click(function (e) {
    e.stopPropagation();
    $('.he_h3p3xl').stop().slideUp();
    $('.he_h3p3li').stop().removeClass('on');
});
$('.he_h3p3xl p').click(function () {
    var val = $(this).text();
    $(this).parents('.he_h3p3xiala').find(".he_h3p3ubin input").attr('value', val);
})
// 滚动条
$(function () {
    var scrollInertiaNum;
    if (/firefox/.test(navigator.userAgent.toLowerCase())) {
        scrollInertiaNum = 350;
    } else {
        scrollInertiaNum = 350;
    }
    $(".he_h3p3xhy").mCustomScrollbar({
        theme: 'dark',
        scrollInertia: scrollInertiaNum,
        horizontalScroll: false,
        axis: "y",
    });
});
$('.he_obtasli').click(function () {
    $(this).addClass('on');
    $(this).siblings().removeClass('on');
})
// 数字滚动
function numRoll(selector, addZero, speed) {
    var $ele = $(selector);
    var speed = speed || 1000;
    $ele.appear(function() {
        var realContent = $(this).text();
        $(this).width($(this).width());
        var content = $(this).data("to");
        if (!content) {
            content = realContent;
        };
        var to = parseFloat(content.toString().replace(/,/g, ""));
        var length = parseInt(to).toString().length;
        var hasDou = false;
        var contentArr = content.toString().split(",");
        if (contentArr[1]) {
            hasDou = true;
        };
        if (addZero) {
            formatter = function(value, options) {
                var myValue = value.toFixed(options.decimals);
                var valLength = parseInt(myValue).toString().length;
                for (var i = 0; i < (length - valLength); i++) {
                    myValue = "0" + myValue;
                }
                if (hasDou) {
                    myValue = toThousands(myValue);
                }
                return myValue;
            }
        } else {
            formatter = function(value, options) {
                var myValue = value.toFixed(options.decimals);
                if (hasDou) {
                    myValue = toThousands(myValue);
                }
                return myValue;
            }
        }


        function toThousands(num) {
            return (num || 0).toString().replace(/(\d)(?=(?:\d{3})+$)/g, '$1,');
        }

        $(this).countTo({
            speed: speed,
            refreshInterval: 60,
            formatter: formatter,
            onComplete: function() {
                $(this).removeAttr("style");
                $(this).text(realContent);
            }
        });
    });
}