function setTab(name,cursel,css,num){
	for(i=1;i<=num;i++){
	  var menu=document.getElementById(name+i);
	  var con=document.getElementById("con_"+name+"_"+i);
	  menu.className=i==cursel?css:"";
	  con.style.display=i==cursel?"block":"none";
	}
}

function fwlumpshow(cursel,num){
	for(i=1;i<=num;i++){
	  var con=document.getElementById("f"+i);
	  con.style.display=i==cursel?"block":"none";
	}
}

function setlump(name,cursor,n,url,moreid,classon,classout){
	var i;
	for(i=1;i <= n;i++){
		var onlump=name+i;
	    var oncontent="con_"+name+"_"+i;
		GETIDOBJ(moreid).href=url;
		GETIDOBJ(onlump).className=i==cursor?classon:classout;
		GETIDOBJ(oncontent).style.display=i==cursor?"block":"none";
	}
}

function SearchCheck(){
	var kwds = document.getElementById("search-input").value;
	var emsg = "";
	if(kwds == "" || kwds == "请输入关键字"){emsg += "请输入搜索关键词！";}
	if(emsg != "" ) {
		alert(emsg);
		return false;
	}else {
		return true;
	}
}

function SearchexpertCheck(){
	/*var kwds = document.getElementById("expertinput").value;
	var emsg = "";
	if(kwds == "" || kwds == "请输入关键字"){emsg += "请输入搜索关键词！";}
	if(emsg != "" ) {
		alert(emsg);
		return false;
	}else {
		return true;
	}*/
}

function headlgnFormCheckInput() {
	var username = document.getElementById("vipusername").value;
	var password = document.getElementById("vippassword").value;
	//var yzpassword = document.getElementById("regyzpassword").value;
	//var checkcode = document.getElementById("regcheckcode").value;
	var emsg = "";
	if(username == ""){emsg += "1.用户名没有填写！ \n";}
	if(password == ""){emsg += "2.密码没有填写！ \n";}
	//if(password != yzpassword){emsg += "两次输入密码不同！ \n";}
	//if(checkcode == ""){emsg += "验证码没有填写！ \n";}
	if(emsg != "" ) {
		alert(emsg);
		return false;
	}else {
		return true;
	}
}

/*
function：划门显示
parameter：
name 划门表示名
cursel 选中项id
n 划门元素个数
author:
example:
*/

function setstage(name,cursor,n,url,moreid,classon,classout){
	var i;
	for(i=1;i <= n;i++){
		var onlump=name+i;
	    var oncontent="con_"+name+"_"+i;
		GETIDOBJ(moreid).href=url;
		GETIDOBJ(onlump).className=i==cursor?classon:classout;
		GETIDOBJ(oncontent).style.display=i==cursor?"block":"none";
		GETIDOBJ(oncontent).css("background-color","#FFF5B5");
	}
}
function setcitylump(name,cursor,n,linename,cursorname,classon,classout){
	var i;
	for(i=1;i <= n;i++){
		var onlump=name+i;
		GETIDOBJ(onlump).className=i==cursor?classon:classout;
	}
	setflashline("flashcontent",linename,cursorname);
}


function setconsult(name,cursor,n,linkurl,moreid,classon,classout){
	var i;
	for(i=1;i <= n;i++){
		var onlump=name+i;
	  var oncontent="con_"+name+"_"+i;
		GETIDOBJ(moreid).href=linkurl;
		GETIDOBJ(onlump).className=i==cursor?classon:classout;
		GETIDOBJ(oncontent).style.display=i==cursor?"block":"none";
	}
}

function killErr(){	return true;}
window.onerror=killErr;

/*
function：设置png透明
parameter：
weburl 网址
webname 网站名称
author:
example:<IMG src="b_a1.png" onload="setPng(this, 98, 73);" align=absMiddle>
*/
function setPng(img, w, h)
{
	ua = window.navigator.userAgent.toLowerCase();
	if(!/msie/.test(ua))
		return;
	imgStyle = "display:inline-block;" + img.style.cssText;
	strNewHTML = "<span style=\"width:" + w + "px; height:" + h + "px;" + imgStyle + ";" + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + img.src + "', sizingMethod='scale');\"></span>";
	img.outerHTML = strNewHTML;
}

function ProcessUploadPicUrl(url,name,size,v){
	GETIDOBJ(v).value=url;
}

function selectopenurl(url){
	window.open(url,'','');
}

/********漂浮和对联***************/
//核心代码
function GETIDOBJ(element){
	if(arguments.length>1){
	for(var i=0,elements=[],length=arguments.length;i<length;i++)
		elements.push(GETIDOBJ(arguments[i]));
		return elements;
	}
	if(typeof element=="string")
	return document.getElementById(element);
	else
	return element;
}
Function.prototype.bind=function(object){
var method=this;
return function(){
method.apply(object,arguments);
}
}
var Class={
create:function(){
return function(){
this.initialize.apply(this,arguments);
}
}
}
Object.extend=function(destination,resource){
for(var property in resource){
destination[property]=resource[property];
}
return destination;
}
function Closeo(o){
	GETIDOBJ(o).style.display="none";
}
//对联广告类
var float_ad=Class.create();
float_ad.prototype={
    initialize:function(id,content,top,left,width){
        document.write('<div id='+id+' style="position:absolute; z_index:10000;">'+content+'<div onclick="Closeo(\''+id+'\');" style="cursor:hand;">【关闭】</div></div>');
        this.id=GETIDOBJ(id);
        this.top=top;
        if(!!left){
            this.id.style.left="8px";
        }else{
            this.id.style.left=(document.documentElement.clientWidth-width-8)+"px";
            window.onresize=function(){
                this.id.style.left=(document.documentElement.clientWidth-width-8)+"px";
            }.bind(this);
        }
        this.id.style.top=top+"px";

        this.interId=setInterval(this.scroll.bind(this),20);
    },
    scroll:function(){
    	  this.id.style.zIndex="10000";
        this.stmnStartPoint = parseInt(this.id.style.top, 10);
        this.stmnEndPoint =document.documentElement.scrollTop+ this.top;
        if(navigator.userAgent.indexOf("Chrome")>0){
            this.stmnEndPoint=document.body.scrollTop+this.top;
        }
        if ( this.stmnStartPoint != this.stmnEndPoint ) {
                this.stmnScrollAmount = Math.ceil( Math.abs( this.stmnEndPoint - this.stmnStartPoint ) / 15 );
                this.id.style.top = parseInt(this.id.style.top, 10) + ( ( this.stmnEndPoint<this.stmnStartPoint ) ? -this.stmnScrollAmount : this.stmnScrollAmount )+"px";
        }
    }
}
//漂浮广告类
var move_ad=Class.create();
move_ad.prototype={
    initialize:function(imgOption,initPosition,delay){
        this.imgOptions=Object.extend({url:"",link:"",width:120,height:120},imgOption||{});
        this.adPosition=Object.extend({left:40,top:120},initPosition||{});
        this.delay =delay;
        this.step = 1;
        this.herizonFlag=true;
        this.verticleFlag=true;
        this.id="ad_move_sg";
        var vHtmlString="<div id='"+this.id+"' style='position:absolute; left:"+this.adPosition.left+"px; top:"+this.adPosition.top+"px; width:"+this.imgOptions.width+"px;";
        vHtmlString+=" height:"+this.imgOptions.height+"px; z-index:100;'><a href='"+this.imgOptions.link+"' target='_blank'><img src='"+this.imgOptions.url+"' width="+this.imgOptions.width+" height="+this.imgOptions.height+" style='border:none;' /></a><div onclick='Closeo(\""+this.id+"\");' style='cursor:hand;'>【关闭】</div></div>";
        document.write(vHtmlString);
        this.id=GETIDOBJ(this.id);
        this.intervalId=setInterval(this.scroll.bind(this),this.delay);
        this.id.onmouseover=this.stop.bind(this);
        this.id.onmouseout=this.start.bind(this);
    },
    scroll:function(){
        var L=T=0;
        var B=document.documentElement.clientHeight-this.id.offsetHeight;
        var R=document.documentElement.clientWidth-this.id.offsetWidth;
        this.id.style.left=this.adPosition.left+document.documentElement.scrollLeft+"px";
        this.id.style.top=this.adPosition.top+document.documentElement.scrollTop+"px";
        this.adPosition.left =this.adPosition.left + this.step*(this.herizonFlag?1:-1);
        if (this.adPosition.left < L) { this.herizonFlag = true; this.adPosition.left = L;}
        if (this.adPosition.left > R){ this.herizonFlag = false; this.adPosition.left = R;}
        this.adPosition.top =this.adPosition.top + this.step*(this.verticleFlag?1:-1);
        if(this.adPosition.top <= T){ this.verticleFlag=true; this.adPosition.top=T;}
        if(this.adPosition.top >= B){ this.verticleFlag=false; this.adPosition.top=B; }
    },
    stop:function(){
        clearInterval(this.intervalId);
    },
    start:function(){
        this.intervalId=setInterval(this.scroll.bind(this),this.delay);
    }
}

/****----------------------******///////
