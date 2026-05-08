$(function() {
	var offset = 150;
    $(window).scroll(function(){
	( $(this).scrollTop() > offset ) ? $("#header_fix").show() : $("#header_fix").hide();
    });
	$(".header_fixed_login_dl").hover(function(){
	    var t=$(this).attr("did");
		$("#"+t+"_t").show();
	},function(){
	    var t=$(this).attr("did");
	   $("#"+t+"_t").hide();    
	});
	$('.fy_index_zx_hfb_list').slide({mainCell:".wrap-huifu .slide-huifu ul",autoPlay:true,effect:"topLoop",scroll:1,vis:5,interTime:3000})
});

$(document).ready(function() {
    $(".hp_top_rt_regist").hover(function() {
        $(".hp_top_regist_list").show();
    },function(){
        $(".hp_top_regist_list").hide();
	});
	$(".navselectthree").hover(function() {
        $(".nav_select").show();
    },function(){
        $(".nav_select").hide();
	});
	$('.hp_nav li').hover(function() {
		var aid=$(this).attr('aid');
		$("#nav"+aid).addClass('hp_nav_cur');        
    },function(){
		var aid=$(this).attr('aid');
		$("#nav"+aid).removeClass('hp_nav_cur');
	});
	$('.hp_head_search_job').hover(function() {
        $('.yunHeaderSearch_list_box').show();
    },function(){
        $('.yunHeaderSearch_list_box').hide();
	});
	
	getConsult_total();
});

//验证码，根据id刷新验证码，无需写多个方法
function checkCode(id){
	document.getElementById(id).src=weburl+"/app/include/authcode.inc.php?"+Math.random();
}

//由于复选框一般选中的是多个,所以可以循环输出
function get_comindes_jobid(){
	var codewebarr="";
	$("input[name=checkbox_job]:checked").each(function(){ //由于复选框一般选中的是多个,所以可以循环输出
		if(codewebarr==""){codewebarr=$(this).val();}else{codewebarr=codewebarr+","+$(this).val();}
	});
	return codewebarr;
}
function search_keyword(myform,defkeyword){
    var keyword = myform.keyword.value;
	if(defkeyword==keyword&&keyword){
		myform.keyword.value='';
	}
}
function check_keyword(name){
	var keyword=$("#keyword").val();
	if(keyword&&keyword==name){$("#keyword").val('');}
}

function search_hide(id){$("#"+id).hide();}
function logout(url,redirecturl){
	$.get(url,function(msg){
		if(msg==1 || msg.indexOf('script')){
			if(msg.indexOf('script')){
				$('#uclogin').html(msg);
			}
			layer.msg('您已成功退出！', 2, 9,function(){window.location.href =redirecturl?redirecturl:weburl;});
		}else{
			layer.msg('退出失败！', 2, 8);
		}
	});
}

$(document).ready(function(){	
	
	$(".yun_topLogin").hover(function(){
		$(this).find(".yun_More").attr("class","yun_More yun_Morecurrent");
		$(this).find("ul").show();
	},function(){
		$(this).find(".yun_More").attr("class","yun_More");
		$(this).find("ul").hide();
	});
	$(".yun_topNav").hover(function(){
		$(this).find(".yun_navMore").attr("class","yun_navMore yun_webMorecurrent");
		$(this).find(".yun_webMoredown").show();
	},function(){
		$(this).find(".yun_navMore").attr("class","yun_navMore");
		$(this).find(".yun_webMoredown").hide();
	});
	
	
	$("input[name=city]").click(function(){
		$('.city_box').show();
	})
	$(".p_t_right").click(function(){
		$("#bg").hide(1000);
		$('.city_box').hide(1000);
	})
	$("#colse_box").click(function(){
		$('.job_box').hide();
	})
	$("#close_job").click(function(){
		var check_val="0";
		var name_val = "不限";
		$("input[type='checkbox'][name='job_box']:checked").each(function(){
		  var info = $(this).val().split("+");
			  check_val+=","+info[0];
			  name_val+="+"+info[1];
		  });
		  check_val = check_val.replace("0,","");
		  $("#qw_job").val(check_val);
		  name_val = name_val.replace("不限+","");
		  $("#qw_show_job").html(name_val);
		  $("#bg").hide(1000);
		  $('#pannel_job').hide(1000);
	})
	$("#click").click(function(){
		var info = $("input[@type=radio][name=cityid][checked]").val();
		var info_arr = info.split("+");
		var name = info_arr[0];
		var id = info_arr[1];
		$("#sea_place").val(name);
		$("#cityid").val(id);
		$("#bg").attr("style","display:none");
		$('.city_box').hide(1000);
	});
	$("#click_head").click(function(){
		var info = $("input[@type=radio][name=cityid][checked]").val();
		var info_arr = info.split("+");
		var name = info_arr[0];
		var id = info_arr[1];
		$("#sea_place_head").val(name);
		$("#cityid_head").val(id);
		$("#bg").hide(1000);
		$('#city_box_head').hide(1000);
	});
	$(".header_zlsearch_box_select").mouseover(function(){
	    $(".header_zlsearch_box_selectlist").show();
	}).mouseout(function(){
	    $(".header_zlsearch_box_selectlist").hide();
	});
	
	$(".index_search_place").mouseover(function(){
		$(".index_place_position").show();
	}).mouseout(function(){
		$(".index_place_position").hide();
	});
	$(".index_place_position").mouseover(function(){
		$(".index_place_position").show();
	});
	$(".Company_post_ms span").click(function(){
		$(".Company_post_ms span").attr("class","");
		$(this).attr("class","Company_post_cur");
		$(".Company_toggle").hide();
		var name=$(this).attr("name");
		$("#Company_job_"+name).show();
	});
	//头部提醒
	$(".header_Remind_hover").hover(function(){
		$(".header_Remind_list").show();
		$(".header_Remind_em").addClass("header_Remind_em_hover");
	},function(){
		$(".header_Remind_list").hide();
		$(".header_Remind_em_hover").removeClass("header_Remind_em_hover");
	}); 
	
	//前台头部登录后样式
	$(".header_fixed_login_after").hover(function(){
		$(".header_fixed_reg_box").show();
	},function(){
		$(".header_fixed_reg_box").hide();
	});
	
	
	if(!isPlaceholder()){
		$("input").not("input[type='password']").each(//把input绑定事件 排除password框
		function(){
			
			if($(this).val()=="" && $(this).attr("placeholder")!=""){
				$(this).val($(this).attr("placeholder"));
				$(this).focus(function(){
					if($(this).val()==$(this).attr("placeholder")) $(this).val("");
				});
				$(this).blur(function(){
					if($(this).val()=="") $(this).val($(this).attr("placeholder"));
				});
			}
		});
		$("textarea").each(//把textarea绑定事件
		function(){
			if($(this).val()=="" && $(this).attr("placeholder")!=""){
				$(this).val($(this).attr("placeholder"));
				$(this).focus(function(){
					if($(this).val()==$(this).attr("placeholder")) $(this).val("");
				});
				$(this).blur(function(){
					if($(this).val()=="") $(this).val($(this).attr("placeholder"));
				});
			}
		});
	};
	
})
function check_email(strEmail) {
	 var emailReg = /^([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9\-]+@([a-zA-Z0-9\-]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	 if (emailReg.test(strEmail))
	 return true;
	 else
	 return false;
 }
function isjsMobile(obj){
	var reg= /^[1][3456789]\d{9}$/;	//验证手机号码   
	return reg.test(obj);
}
function isjsTell(str) {
    var result = str.match(/\d{3}-\d{8}|\d{4}-\d{7}/);
    if (result == null) return false;
    return true;
}
function isPlaceholder(){
    var input = document.createElement('input');
    return 'placeholder' in input;
	var textarea = document.createElement('textarea');
    return 'placeholder' in textarea;
}

//加入收藏夹
function addwebfav(url,title){
	var title,url;
	if(document.all){
		window.external.addFavorite(url,title);
	}else if(window.sidebar){
		window.sidebar.addPanel(title,url,"");
	}
}
//设置首页
function setHomepage(url){
   var url;
   if(document.all){
	  document.body.style.behavior='url(#default#homepage)';
	  document.body.setHomePage(url);
   }else if(window.sidebar){
		if(window.netscape){
			 try{
				netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
			 }
			 catch(e){
				layer.alert('您的浏览器未启用[设为首页]功能，开启方法：先在地址栏内输入about:config,然后将项 signed.applets.codebase_principal_support 值该为true即可！', 2,8);return false; 
			 }
		}
		var prefs=Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
		prefs.setCharPref('browser.startup.homepage',url);
   }
}
function marquee(time,id){
	$(function(){
		var _wrap=$(id);
		var _interval=time;
		var _moving;
		_wrap.hover(function(){
			clearInterval(_moving);
		},function(){
			_moving=setInterval(function(){
			var _field=_wrap.find('li:first');
			var _h=_field.height();
			_field.animate({marginTop:-_h+'px'},800,function(){
			_field.css('marginTop',0).appendTo(_wrap);
			})
		},_interval)
		}).trigger('mouseleave');
	});
}
//弹出框
function forget(){
	var aucode = $("#txt_CheckCode").val();
	var username =  $("#username").val();
	if(username==""){
		$("#msg_error").html("<font color='red'>请填写你注册时的用户名！</font>");
		return false;
	}
	if(aucode==""){
		$("#msg_error").html("<font color='red'>验证码不能为空！</font>");
		return false;
	}
	return true;
}
function unselectall(){
	if(document.getElementById('chkAll').checked){
		document.getElementById('chkAll').checked = document.getElementById('chkAll').checked&0;
	}
}
function CheckAll(form){
	for (var i=0;i<form.elements.length;i++){
		var e = form.elements[i];
		if (e.Name != 'chkAll'&&e.disabled==false)
		e.checked = form.chkAll.checked;
	}
}


/*-------------------------------------------------*/
function check_skill(id){
	$(".pop-ul-ul").hide();
	$(".user_tck_box1").removeClass("tanchu");
	$("#showskill"+id).addClass("tanchu");
	$("#skill"+id).show();
}
function box_delete(id){
	$("#sk"+id).remove();
	$("#td_"+id).remove();
	 $("#zn"+id).removeAttr("checked");
}

$(document).ready(function () {
    //首页搜索框，搜索类型的选择
    $('body').click(function (evt) {
        if (!$(evt.target).parent().hasClass('yunHeaderSearch_s') && !$(evt.target).hasClass('yunHeaderSearch_s') && evt.target.id != 'search_name') {
            $('.yunHeaderSearch_list_box').hide();
        }
    });
	var jobarr=new Array();
	$("#close_skill").click(function(){
		$("#bg").hide();
		$('#skill_box').hide();
		var skill_val = "";
		var i=0;
		$("input[type='checkbox'][name='job_classid']:checked").each(function(){
		  var info = $(this).val().split("+");
			jobarr[i]=info[0];
			i++;
		  skill_val+="<li id=\"sk"+info[0]+"\" class=\"show_type"+info[0]+"\" onclick=\"box_delete('"+info[0]+"');\"><input type=\"checkbox\" name=\"job_classid[]\" checked=\"\" value="+info[0]+"><span>"+info[1]+"</span></li>";
		  });
		$("#job_classid").html(skill_val);
	})
	// 打赏金额
	$(".dashang_1 ul li").click(function(){
		var u = $(this); 
		var index = u.index(); 
		u.addClass("dashang_bc"); 
		u.siblings("li").removeClass("dashang_bc"); 
		});
	$(".pay_style  ul li").click(function(){
		var  u = $(this); 
		var index = u.index();
		u.addClass("pay_bc"); 
		u.siblings("li").removeClass("pay_bc");
	});
	$(".rewardwrap .rewrad_lead i").click(function(){
		$(".rewardwrap").hide(); 
	});
})
function checkmore(type,div,size,msg){
	if(msg=="展开"){
		var msg="收起";
		$("#"+type+" a:gt("+size+")").show();
		$("#"+div).html("<a class=\"yun_close  icon\" href=\"javascript:;\" onclick=\"checkmore('"+type+"','"+div+"','"+size+"','"+msg+"');\">"+msg+"</a>");
	}else{
		var msg="展开";
		$("#"+type+" a:gt("+size+")").hide();
		$("#"+div).show();
		$("#"+div).html("<a class=\"yun_open  icon\" href=\"javascript:;\" onclick=\"checkmore('"+type+"','"+div+"','"+size+"','"+msg+"');\">"+msg+"</a>");
	}
}
function checkrest(url){window.location.href="index.php?m="+url;}
function Close(id){
	$("#"+id).hide();
	$("#bg").hide();
}
function check_pl(){//企业评论
	if($.trim($("#content").val())==""){
		layer.msg('评论留言内容不能为空！', 2,8);return false;
	}
	var authcode=$("#msg_CheckCode").val();
	if(authcode==''){
		layer.msg('验证码不能为空！', 2, 8);return false;
	} 
}
function huifu(id){
	$("#huifu"+id).show();
}
function check_huifu(id){
	if($("#reply"+id).val()==""){
		layer.msg('回复内容不能为空！', 2,8);return false;
	}
}

function show_im(id){
	$('#WB_webim').find('#im_'+id).click();
}
function add_im(id,type,status,username){
	$('#WB_webim').find('#im_'+id).click();
	var lis=$("#list_content4").find("ul").find("li");
	var ul=$("#list_content4").find("ul");
	var statusHtml='';
	if(status=="1"){
		statusHtml='<span class="W_chat_stat W_chat_stat_online"></span>';
	}else{
		statusHtml='<span class="W_chat_stat W_chat_stat_offline"></span>';
	}
	var typeName='';
	if(type=="2"){
		typeName='企业';
	}else if(type=="1"){
		typeName='个人';
	}
	var lihtml='<li class="clearfix" style="height:20px;line-height:20px;"><div class="webim_list_name" id="right_im_'+type+'"><div class="list_head_state" style="float:left;margin-top:5px; margin-right:5px;">'+statusHtml+'</div><span class="user_name" id="im_'+id+'" uid="'+id+'" usertype="'+type+'" style="float:left;">['+typeName+'] '+username+'</span></div></li>';

	if(lis.length==1){
		if(lis.text()=="暂无好友"){
			ul.html(lihtml);
		}else if(lis.attr("uid")!=id){
			ul.append(lihtml);
		}
	}else{
		var flag=false;
		for(var i in lis){
			if(lis[i].attr("uid")==id){
				flag=true;break;
			}
		}
		if(!flag){
			ul.append(lihtml);
		}
	}
}
function layer_del(msg,url){ 
	if(msg==''){
		var i=layer.load('执行中，请稍候...',0);
		$.ajaxSetup({cache:false});
		$.get(url,function(data){
			layer.close(i);
			var data=eval('('+data+')');
			if(data.url=='1'){
				layer.msg(data.msg, Number(data.tm), Number(data.st),function(){location.reload();});return false;
			}else{
				layer.msg(data.msg, Number(data.tm), Number(data.st),function(){location.href=data.url;});return false;
			}
		});
	}else{
		layer.confirm(msg, function(){
			var i=layer.load('执行中，请稍候...',0);
			$.ajaxSetup({cache:false});
			$.get(url,function(data){
				layer.close(i);
				var data=eval('('+data+')');
				if(data.url=='1'){
					layer.msg(data.msg, Number(data.tm), Number(data.st),function(){location.reload();});return false;
				}else{
					layer.msg(data.msg, Number(data.tm), Number(data.st),function(){location.href=data.url;});return false;
				}
			});
		});
	}
}
function top_search(M,C, name, url, is_module_open, module_dir) {
    if ((is_module_open == '1') && (module_dir != '')) {
        $('#index_search_form #m').attr('name', '');
    } else {
        $('#index_search_form #m').attr('name', 'm');
    }
    $('#index_search_form').attr('action', url);
    $('#index_search_form #m').val(M);
	$('#index_search_form #search').val(C);
	$(".yunHeaderSearch_list_box").hide();
	$('#search_name').html(name);
	if(M=='caipan'){
		var inputname="请输入法院、律师、案号等关键词";
	}else{
		var inputname="请输入你要查找的"+name;
	}
	$('#bdcsMain').attr('placeholder', inputname);
}
function top_searchs(M,name){
	$("input[name='m']").val(M);
	$(".index_place_position").hide();
	$('#search_name').html(name)
}
function returnmessage(frame_id){ 
	if(frame_id==''||frame_id==undefined){
		frame_id='supportiframe';
	}
	var message = $(window.frames[frame_id].document).find("#layer_msg").val(); 
	if(message != null){
		var url=$(window.frames[frame_id].document).find("#layer_url").val();
		var layer_time=$(window.frames[frame_id].document).find("#layer_time").val();
		var layer_st=$(window.frames[frame_id].document).find("#layer_st").val();
		if(message=='验证码错误！'){$("#vcode_img").trigger("click");$("#vcodeimgs").trigger("click");}
		if(message=='验证码错误！'){$("#vcode_imgs").trigger("click");}
		if(message=='验证码错误！'){$("#vcodeimgs").trigger("click");}
		if(message=='请点击按钮进行验证！'){
			$("#popup-submit").trigger("click");
		}
		layer.closeAll('loading');
		if(url=='1'){
			layer.msg(message, layer_time, Number(layer_st),function(){window.location.reload();window.event.returnValue = false;return false;});
		}else if(url==''){
			layer.msg(message, layer_time, Number(layer_st));
		}else{
			layer.msg(message, layer_time, Number(layer_st),function(){location.replace(url);return false;});
		}
	}
}

function com_msg(){
	noplaceholder('msg_content');
	var msg_content=$.trim($("#msg_content").val());
	if(msg_content==''){
		layer.msg('咨询内容不能为空！', 2,8);return false;
	}
	noplaceholder('msg_CheckCode');
	var authcode=$("#msg_CheckCode").val();
	if(authcode==''){
		layer.msg('验证码不能为空！', 2, 8);return false;
	} 
}


function close_prop(div,id){
	$("#"+div).hide();
	$("#"+id).removeClass("city_cur");
}
function del_ck(id){
	$("#span_"+id).remove();
	$("#"+id).removeAttr("checked");
}
/*弹出框结束*/
function atn(id,url,tid){//关注企业
	if(id){
		$.post(url,{id:id,tid:tid},function(data){
			if(data==1){
				$("#atn_"+id).removeClass('zg-btn-unfollow');
				$("#atn_"+id).addClass('zg-btn-green'); 
				if($("#atn_"+id).attr('tagName')=='input'){
					$("#atn_"+id).val("取消关注"); 
				}else{
					$("#atn_"+id).html("取消关注");
				}
				$("#guanzhu"+id).val('取消关注');
				var antnum=$("#antnum"+id).html();
				$("#antnum" + id).html(parseInt(antnum) + 1);//关注数加1
				$("#atn_" + id).addClass('company_att');
			}else if(data==2){
				$("#atn_"+id).removeClass('zg-btn-green');
				$("#atn_"+id).addClass('zg-btn-unfollow attentioned'); 
				if($("#atn_"+id).attr('tagName')=='input'){
					$("#atn_"+id).val("关注"); 
				}else{
					$("#atn_"+id).html("关注");
				}
				$("#guanzhu"+id).val('+关注');
				var antnum=$("#antnum"+id).html();
				$("#antnum" + id).html(parseInt(antnum) - 1);//关注数减1
				$("#atn_" + id).removeClass('company_att');
			}else if(data==3){
				layer.msg('请先登录！只有个人用户才能关注', 2,8);return false;
			}else if(data==4){
				layer.msg('只有个人用户才能关注', 2,8);return false;
			}
		});
	}
}




function jsmsg(id){
	var myuid = $("#myuid").val();
	if(myuid==""){
		layer.msg('你还没有登录！', 2, 8);
	}
	$("#msg"+id).show();
}
function showImgDelay(imgObj,imgSrc,maxErrorNum){   
	if(maxErrorNum>0){ 
        imgObj.onerror=function(){
            showImgDelay(imgObj,imgSrc,maxErrorNum-1);
        };
		
        setTimeout(function(){
            imgObj.src=imgSrc;
        },500);
		maxErrorNum=parseInt(maxErrorNum)-parseInt(1);
    }
}
function reportSub(img){
	var authcode=$("#report_authcode").val();
	var r_reason=$("#r_reason").val();
	var r_uid=$("#r_uid").val();
	var id=$("#id").val();
	var r_name=$("#r_name").val();
	if($.trim(r_reason)==""){
		layer.msg('举报内容不能为空！', 2, 8);
		return false;
	}
	var i = layer.load('执行中，请稍候...',0);
	$.post(weburl+"/job/index.php?c=report",{authcode:authcode,r_reason:r_reason,id:id,r_name:r_name,r_uid:r_uid},function(data){
		layer.close(i);
		if(data==1){
			layer.msg('验证码不正确！', 2, 8,function(){checkCode(img);});
		}else if(data==2){
			layer.msg('您已经举报过该用户！', 2, 8,function(){checkCode(img);});
		}else if(data==3){
			layer.closeAll();
			layer.msg('举报成功！', 2,9);
		}else if(data==4){
			layer.msg('举报失败！', 2, 8,function(){checkCode(img);});
		}else if(data==5){
			layer.msg('网站已关闭举报功能！', 2, 8,function(){checkCode(img);});
		}
	})
}

$(function(){
	$('body').click(function(evt) {
		if($(evt.target).parents("#listhy").length==0 && evt.target.id != "buttonhy") {
			$('#listhy').hide();
		}
	})
});


function redeem_dh(){
	var linkman=$("input[name=linkman]").val();
	var linktel=$("input[name=linktel]").val();
	var password=$("input[name=password]").val();
	if(!linkman || !linktel){
		layer.msg('联系人或联系电话不能为空！', 2, 8);
		return false;
	}
	if(!password){
		layer.msg('请输入密码！', 2, 8);
		return false;
	}
	return true;
}
function noplaceholder(id){
	var value=$("#"+id).val();
	var placeholder=$("#"+id).attr('placeholder');
	if(value==placeholder){
		$("#"+id).val('');
	}
}

//注册、发布问题选择地点
function select_fy_city(id,type,gettype){
	$("#" + type + "id").val(id);
	if(type=='province'){
		$("#cityid").val('0');
		$("#three_cityid").val('0');
	}
	if(type=='city'){
		$("#three_cityid").val('0');
	}
	var url=weburl+"/index.php?m=ajax&c=ajax_fy_city";
	$.post(url,{id:id,gettype:gettype},function(data){
		$("#"+gettype+"id").html(data);
		$("#"+gettype+"id").show();
		if($("#three_cityid").val()=='0'){
			msg="请选择地区！";
			$("#ajax_three_cityid").show();
			$("#ajax_three_cityid").html('<p>请选择地区！</p>'); 
			$("#three_cityid").attr('date','0');return false;
		 }else{
			$("#ajax_three_cityid").hide();
			$("#three_cityid").attr('date','1'); 
		 }
		
	})
}
//发布问题选择问题类型
function select_fy_hy(id){
	$("#hytwo").val('0');
	var url=weburl+"/index.php?m=ajax&c=ajax_fy_hy";
	$.post(url,{id:id},function(data){
		$("#hytwo").html(data);
		
	})
}
function select_fy_public(id){
	$("#hytwo").val('0');
	var url=weburl+"/index.php?m=ajax&c=ajax_fy_public";
	$.post(url,{id:id},function(data){
		$("#hytwo").html(data);
		
	})
}
// 累计在线咨询数量
function getConsult_total(){
	if($("#r_consult_total").length > 0){
		$.post(weburl+'/index.php?m=ajax&c=consultTotal',{rand:Math.random()}, function(data){
			if(data>0){
				if(data > 0){
					var g = $("#r_consult_total .ad02"), i = g.children("div");
					if(data >= 99999){
						i.text(9);
					}else{
						var string = data.toString(), string_r = string.split("").reverse().join(""), len = string.length;
						for(var n = 0; n < len; n++){
							var s = string_r.substr(n, 1);
							var c = i.eq(4-n);
							changeNum(c, s)
						}
					}
				}
			}
		})
	}
}
function changeNum(obj, num){
	num = parseInt(num);
	var now = parseInt(obj.children('p').text());
	var next = now == num ? num : ++now;
	setTimeout(function(){
		obj.html('<p>'+next+'</p>');
		if(next < num){
			changeNum(obj, num);
		}
	},100)
}

//打赏
function showReward(touid,url,type){

 	$.post(url,{touid:touid,type:type}, function(data){
		var data=eval('('+data+')');
		if(data.state==9){
			$('#userphoto').html("<img src='"+data.userphoto+"'>");
			$('#username').html(data.username);
			$('#touid').val(touid);
			$('#rewardwrap').show();
		}else{
			layer.msg(data.msg, 2,data.state);return false;
		}
	})
}
//打赏付款
function payReward(type){
	var amountCus = $("#amountCus").val(); 
	var amount = 0; 
	if(amountCus && amountCus > 0){
		amount = amountCus; 
	}else{
		amount = $(".dashang_1 ul li.dashang_bc").attr("data-amount"); 
	} 
	var paytype = $(".paytype .pay_bc").attr("data-type");
	var aid=$("#aid").val();
	var touid=$("#touid").val();
	$.post(weburl+"/index.php?m=ajax&c=reward",{
		aid:aid,
		paytype:paytype,
		amount:amount,
		touid:touid,
		type:type
		}, function(data){
			if(data==0){
				layer.msg('提交失败，请稍候重试',2,8);return false;
			}else if(data==-1){
				layer.msg('参数错误',2,8);return false;
			}else{
				window.location.href=data;
			}
		}
	)
}
$(function(){
	$('.banner-top ').slide({mainCell:".wrap-top .slide-top", titCell:".hd ul", autoPlay:true, autoPage:"<li><a></a></li>",effect:"topLoop",scroll:1,vis:5,interTime:5000})
    $('.banner-lb ').slide({mainCell:".wrap-lb .slide-lb", titCell:".hd ul", autoPlay:true,effect:"top",vis:1,interTime:5000})
	$(".slidebox1").slide({titCell:".hd ul",mainCell:".bd .slideobj",effect:"leftLoop",autoPlay:true,autoPage:"<li></li>"});
	
	$('.banner ').slide({mainCell:".slide", titCell:".hd ul", autoPlay:true, autoPage:"<li><a></a></li>",scroll:1,effect:"leftLoop",vis:1,interTime:8600})
	$('.rank_jieda .ranklead ul li').hover(function(){
        var  u = $(this);
        var index = u.index();
        $('.ranklist').eq(index).show();
        $('.ranklist').eq(index).siblings(".ranklist").hide();
        u.addClass('an');
        u.siblings('li').removeClass('an');
    })
	$('.rank .ranklead ul li').hover(function(){
        var  u = $(this);
        var index = u.index();
        $('.ranklist').eq(index).show();
        $('.ranklist').eq(index).siblings(".ranklist").hide();
        u.addClass('an');
        u.siblings('li').removeClass('an');
    })
})

function checksite(cityid){
	
	var i=layer.load(1);
	$.post(weburl+'/index.php?m=ajax&c=checksite',{cityid:cityid},function(data){
		
		var data = eval('('+data+')');
		if(data.url){
			window.location.href=data.url;
		}else{
			window.location.href='';
		}

	})
}
function select_fynew_city_one(){
	$(".fynew_city_one").show();
}
function selpro(id,name){
	$(".fynew_city_one").hide();
	$(".proname").val(name);
	$(".shiname").val("城市");
	$(".search_ls").val("查找律师");
	$("#shen").val(id);
	$("#shi").val("");
	$("#sshi").val("");
 
	$.post(weburl+'/?m=ajax&c=ajax_fynew_city',{id:id},function(data){
		if(data){
			$('.fynew_city_two ul').html(data);
		}
	})
}

function select_fynew_city_two(){
	$(".fynew_city_two").show();
}
function selshi(id,name){
 	$(".fynew_city_two").hide();
  	if(name==""){
		$(".shiname").val("城市");
	}else{
 		$(".shiname").val(name);
	}
 	$("#shi").val(id);
}