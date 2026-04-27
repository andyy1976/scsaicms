    // 关于我们数字滚动
    function ShowCountUp(Obj){          //元素进入浏览器可视区域后运行数值变化
        var Demos = SetCountUp(Obj);
        ScrollShow(Obj,false,function(){
            for(i = 0; i < Demos.length; i++){
                Demos[i].start();
            }
        });
    }
    function SetCountUp(Obj){      //设置数值变化     Obj:对象需要拥有ID
        var Demo = [],
            DefauitOptions = {
                useEasing : false,
                useGrouping : true,
                separator : '',
                decimal : '.',
                prefix : '',
                suffix : ''
            };
    
        Obj.each(function(i,e){
            if(jQuery(e).attr('id')){
                var Id = jQuery(e).attr('id'),
                    Start = jQuery(e).attr('data-start'),
                    End = jQuery(e).attr('data-end'),
                    Decimals = jQuery(e).attr('data-decimals'),
                    Duration = jQuery(e).attr('data-duration'),
                    useEasing = jQuery(e).attr('data-useEasing'),
                    useGrouping = jQuery(e).attr('data-useGrouping'),
                    separator = jQuery(e).attr('data-separator'),
                    decimal = jQuery(e).attr('data-decimal'),
                    prefix = jQuery(e).attr('data-prefix'),
                    suffix = jQuery(e).attr('data-suffix'),
                    Options = {
                        useEasing : useEasing != undefined ? useEasing : DefauitOptions.useEasing,
                        useGrouping : useGrouping != undefined ? useGrouping : DefauitOptions.useGrouping,
                        separator : separator != undefined ? separator : DefauitOptions.separator,
                        decimal : decimal != undefined ? decimal : DefauitOptions.decimal,
                        prefix : prefix != undefined ? prefix : DefauitOptions.prefix,
                        suffix : suffix != undefined ? suffix : DefauitOptions.suffix
                    };
    
                Demo[i] = new CountUp(Id, Start, End, Decimals, Duration, Options);
            }
        });
    
        return Demo;
    }
    
    var options = {
      useEasing : true,
      useGrouping : true,
      separator : ',',
      decimal : '.',
      prefix : '',
      suffix : ''
    };
    
    function ScrollShow(Obj,Repeat,Callbacks){          //对象滚动到浏览器可视区域时执行回调函数
        if(Obj.length){
            Obj.each(function(i,e){
                var Site = jQuery(e).offset(),
                    Height = jQuery(e).outerHeight(true),
                    WinTop = jQuery(this).scrollTop(),         //滚动条位置
                    WinHeight = jQuery(this).height(),      //窗口高度
                    WinArea = WinTop+WinHeight,        //浏览器可视区域
                    IsRepeat = Repeat === true ? true : false,      //重复执行
                    Switch = true;                                  //开关
                    Site = jQuery(e).offset();
                    Height = jQuery(e).outerHeight(true);
                    WinTop = jQuery(this).scrollTop();
                    WinHeight = jQuery(this).height();
                    WinArea = WinTop+WinHeight;
                    jQuery.isFunction(Callbacks) && Callbacks();
                    Switch = false;

                    var num1 = new CountUp("loadingNum_1", 0, $('#loadingNum_1').attr('data-end'), 0, 3, options);
                    var num2 = new CountUp("loadingNum_2", 0, $('#loadingNum_2').attr('data-end'), 0, 3, options);
                    var num3 = new CountUp("loadingNum_3", 0, $('#loadingNum_3').attr('data-end'), 0, 3, options);
                    var num4 = new CountUp("loadingNum_4", 0, $('#loadingNum_4').attr('data-end'), 0, 3, options);
                    var num5 = new CountUp("loadingNum_5", 0, $('#loadingNum_5').attr('data-end'), 0, 3, options);

                    num1.start();
                    num2.start();
                    num3.start();
                    num4.start();
                    num5.start();
            });
        }
        return;
    }