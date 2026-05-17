	var xmlHttp;
	var addWendaQuestion;
	var AddWendaAnswer;
	var addNewAnswer;
	function GetXmlHttpObject(handler)
	{ 
		var objXmlHttp=null	
		if (navigator.userAgent.indexOf("MSIE")>=0)
		{ 
			var strName="Msxml2.XMLHTTP"
			if (navigator.appVersion.indexOf("MSIE 5.5")>=0)
			{
				strName="Microsoft.XMLHTTP"
			} 
			try
			{   
				objXmlHttp=new ActiveXObject(strName)
				objXmlHttp.onreadystatechange=handler 
				return objXmlHttp
			} 
			catch(e)
			{ 
				alert("Error. Scripting for ActiveX might be disabled") 
				return 
			} 
		}
		else
		{
			objXmlHttp=new XMLHttpRequest()
			objXmlHttp.onload=handler
			objXmlHttp.onerror=handler 
			return objXmlHttp
		}
	}


	/* 提问 */
	function AddWendaQuestion() 
	{
	
	    document.getElementById("sendWendaQuestion").disabled = true;
	    	
	    var Author = escape(document.getElementById("Author").value);
	 
	    var Content = escape(document.getElementById("wendaanswercontent").value);
	    	// 	alert("af");
			var title =     escape(document.getElementById("title").value);
					
			var tel =     escape(document.getElementById("tel").value);
		  var email =     escape(document.getElementById("email").value);
			var precontent=document.getElementById("wendaanswercontent").value;
			
			var group_id =  document.getElementById("group_id").value;
			//alert(group_id);
			if ( Content == "") 
			{
		    alert("请填写完整！");
				document.getElementById("sendWendaQuestion").disabled = false;
				return false;
			}
			if(precontent.length <5)
			{
				alert("问题描述内容最少5字,请调整后再发布!");
				document.getElementById("sendWendaQuestion").disabled = false;
				return false;
			}
	    addWendaQuestion = GetXmlHttpObject(sendWendaQuestion);
	    var WendaInfo = "title="+title+"&tel="+tel+"&author="+Author+"&content="+Content+"&group_id="+group_id+"&email="+email;
	   // alert(WendaInfo);
	    
	    //alert("http://"+window.location.host+root+"/index.php?m=Wenda&a=update");
	    
	    addWendaQuestion.open("POST","http://"+window.location.host+root+"/index.php?m=Wenda&a=updatequestion",false); 
	    addWendaQuestion.setRequestHeader("Content-Type","application/x-www-form-urlencoded") 
	    addWendaQuestion.send(WendaInfo); 
	} 

	function sendWendaQuestion() 
	{
	    if (addWendaQuestion.readyState==4 || addWendaQuestion.readyState=="complete") 
	    {
	       //alert(addWenda.responseText);
			   document.getElementById("sendWendaQuestion").disabled = false;
			   document.getElementById("Author").value = "";
			   document.getElementById("wendaanswercontent").value = "";
			   //showwenda(1);
			   alert("发布成功,问题需要管理员审核!");
	    } 
	}
	
		/* 提问 */
	function AddWendaAnswer() 
	{
	//	alert("1");
	    document.getElementById("sendWendaAnswer").disabled = true;
	    var Author = escape(document.getElementById("Author").value);
	  
				var id =     escape(document.getElementById("qid").value);
			//	alert(id);
			var recontent=document.getElementById("recontent").value;
			var guide=document.getElementById("guide").value;
			var approval=document.getElementById("approval").value;
			var cases=document.getElementById("cases").value;
			if ( escape(recontent) == "") 
			{
		    alert("请将问题答案填写完整！");
				document.getElementById("sendWendaAnswer").disabled = false;
				return false;
			}
			if(recontent.length <20)
			{
				alert("问题答案最少20字,请调整后再发布!");
				document.getElementById("sendWendaAnswer").disabled = false;
				return false;
			}
			
			if ( escape(guide) == "")
			{
		    alert("请将操作指引填写完整！");
				document.getElementById("sendWendaAnswer").disabled = false;
				return false;
			}
			if(guide.length <20)
			{
				alert("操作指引最少20字,请调整后再发布!");
				document.getElementById("sendWendaAnswer").disabled = false;
				return false;
			}
			
				if ( escape(approval)== "")
			{
		    alert("请将法律依据填写完整！");
				document.getElementById("sendWendaAnswer").disabled = false;
				return false;
			}
			if(approval.length <10)
			{
				alert("法律依据最少10字,请调整后再发布!");
				document.getElementById("sendWendaAnswer").disabled = false;
				return false;
			}
			
				if ( escape(cases) == "")
			{
		    alert("请将典型案例填写完整！");
				document.getElementById("sendWendaAnswer").disabled = false;
				return false;
			}
			if(cases.length <10)
			{
				alert("案例最少10字,请调整后再发布!");
				document.getElementById("sendWendaAnswer").disabled = false;
				return false;
			}
			
	    AddWendaAnswer = GetXmlHttpObject(sendWendaAnswer);
	    var WendaInfo = "id="+id+"&guide="+escape(guide)+"&approval="+escape(approval)+"&cases="+escape(cases)+"&author="+Author+"&recontent="+escape(recontent);
	  //  alert(WendaInfo);
	    
	   // alert("http://"+window.location.host+root+"/index.php?m=Wenda&a=updateanswer");
	    
	    AddWendaAnswer.open("POST","http://"+window.location.host+root+"/index.php?m=Wenda&a=updateanswer",false); 
	    AddWendaAnswer.setRequestHeader("Content-Type","application/x-www-form-urlencoded") 
	    AddWendaAnswer.send(WendaInfo); 
	} 
	
	function sendWendaAnswer() 
	{
	    if (AddWendaAnswer.readyState==4 || AddWendaAnswer.readyState=="complete") 
	    {
	       //alert(addWenda.responseText);
			   document.getElementById("sendWendaAnswer").disabled = false;
			
			   //showwenda(1);
			   alert("解答问题成功,您的答案需要管理员审核!");
			    window.location.href="index.php?s=wenda/answerlist";
	    } 
	}
	
	/* 显示答案 */
	function showanswer(qid,no)
	{   
		document.getElementById("list").innerHTML = "";
		var url = "http://"+window.location.host+root+"/index.php?m=Wendaanswer&a=index&qid="+qid+"&page="+no;
		
		xmlHttp=GetXmlHttpObject(showlist)
		xmlHttp.open("GET", url , true)
		xmlHttp.send(null)
	}
	function showlist()
	{
	
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") 
		{   
		  document.getElementById("list").innerHTML = ""
			xmlAuthor = xmlHttp.responseXML.getElementsByTagName("Author")
			xmlContent = xmlHttp.responseXML.getElementsByTagName("Content")
			xmlNoI = xmlHttp.responseXML.getElementsByTagName("NoI")
			xmlIP = xmlHttp.responseXML.getElementsByTagName("IP")
			xmlreContent = xmlHttp.responseXML.getElementsByTagName("reContent")
			//输出解答
			for (i=0;i<xmlContent.length;i++) 
			{  
			    var Content = xmlContent[i].firstChild.data;
	            var div = document.createElement("DIV");   
	            div.id = i; 
					if (Content == "没有解答") {
					    //alert("1111");
					    div.innerHTML = "<div style='padding:5px;color:#ff0000'>暂时还没有解答</div>"
					}
					else 
					{
				    var Author = xmlAuthor[i].firstChild.data;
				    var PostTime = xmlAuthor[i].getAttribute('PostTime');
				    var ID = xmlNoI[i].firstChild.data;
				    var IP = xmlIP[i].firstChild.data;
					  var reContent = xmlreContent[i].firstChild.data;
				    div.innerHTML = "<div class='plun' style='clear:both;'><div class='ptitle'><div class='pnoi'><b><font color='blue'>"+ID+"</font></b> 楼:</div><div class='pname'>"+Author+"</div><div class='pIP'>来自：<a href='http://www.ip138.com/ips8.asp?ip="+IP+"&action=2' target='_blank'>"+IP+"</a></div><div class='pltime'>发表于 "+PostTime+"</div></div><div class='pings'>"+Content+"</div><div class='repings'>"+reContent+"</div></div>"
				}
	      document.getElementById("list").appendChild(div);
			}
			 //输出分页信息
			P_Nums = xmlHttp.responseXML.getElementsByTagName("data")[0].getAttribute('P_Nums');
			var A_Nums = xmlHttp.responseXML.getElementsByTagName("data")[0].getAttribute('A_Nums');
			var aaa="[本问题共<font color='#cc0000'>"+A_Nums*1+"</font>条解答| 每页显示<font color='#cc0000'>6</font>条解答]";
		
			if (P_Nums>1) 
			{
		    	var page = xmlHttp.responseXML.getElementsByTagName("data")[0].getAttribute('page');
		    	var ID = xmlHttp.responseXML.getElementsByTagName("data")[0].getAttribute('ID');
				  var D_Nums = xmlHttp.responseXML.getElementsByTagName("data")[0].getAttribute('D_Nums');
			    var l1 = "<a class='total'>&nbsp;"+D_Nums+"&nbsp;</a><a class='pages'><span>"+page+"/"+P_Nums+"</span></a>"
				l1 = (page>1)?l1+"<a href='javascript:showanswer("+ID+",1)' class='redirect' title='第一页'><<&nbsp;</a>":l1;
				var l2 = "";
				for (var i =1;i<=P_Nums;i++) 
				{
				     l2 += (i == page)?"<a class='curpage'>"+i+"</a>":"<a href='javascript:showanswer("+ID+","+i+")' class='num'>"+i+"</a>"
				}
				l2 = (page == P_Nums)?l2:l2+"<a href='javascript:shoshowanswerwre("+ID+","+P_Nums+")' class='redirect' title='最后页'>>>&nbsp;</a>"
				document.getElementById("MultiPage").innerHTML = l1+l2;
			}
		}
		
	}
	/* 普通用户发表解答 */
	function AddNewAnswer() 
	{
	    document.getElementById("sendGuest").disabled = true;
	    var Author = escape(document.getElementById("Author").value);
	    var Content = escape(document.getElementById("wendaanswercontent").value);
		  var precontent = document.getElementById("wendaanswercontent").value;
		  var qid = document.getElementById("qid").value;
	    if (Author == "" || Content == "") 
	    {
		    alert("请将解答内容填写完整！");
				document.getElementById("sendGuest").disabled = false;
				return false;
			}
	    addNewAnswer = GetXmlHttpObject(sendGuest);
	    var GuestInfo = "author="+Author+"&qid="+qid+"&content="+Content;
	    //alert(GuestInfo);
	    //alert(root);
	    //alert("http://"+window.location.host+root+"/index.php?m=Wendaanswer&a=update");
	    addNewAnswer.open("POST","http://"+window.location.host+root+"/index.php?m=Wendaanswer&a=update",false); 
	    addNewAnswer.setRequestHeader("Content-Type","application/x-www-form-urlencoded") 
	    addNewAnswer.send(GuestInfo); 
	} 
	function sendGuest() 
	{
	    if (addNewAnswer.readyState==4 || addNewAnswer.readyState=="complete") 
	    {
	       alert(addNewAnswer.responseText);
		     document.getElementById("sendGuest").disabled = false;
		   
		     document.getElementById("wendaanswercontent").value = "";
		    // showanswer(document.getElementById("qid").value,1);
		} 
	}

function guanlianfagui(typeid,qid,no) 
	{
	   //	alert(typeid);
	   //	alert(qid);
	   	/*
		document.getElementById("right_con").innerHTML = "";
		var url = "http://"+window.location.host+root+"/index.php?s=Wendalinkarticle&typeid="+typeid+"&qid="+qid+"&page="+no;
		
		xmlHttp=GetXmlHttpObject(showlist)
		xmlHttp.open("GET", url , true)
		xmlHttp.send(null)
		*/
		/*
		$('.box-fg').fadeIn();
		$('.pul-close').click(function(){
			$('.box-fg').fadeOut();
		});
	*/
	}


	function showarticlelist()
	{
	
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") 
		{   
		  document.getElementById("list").innerHTML = ""
			xmlAuthor = xmlHttp.responseXML.getElementsByTagName("Author")
			xmlContent = xmlHttp.responseXML.getElementsByTagName("Content")
			xmlNoI = xmlHttp.responseXML.getElementsByTagName("NoI")
			xmlIP = xmlHttp.responseXML.getElementsByTagName("IP")
			xmlreContent = xmlHttp.responseXML.getElementsByTagName("reContent")
			//输出解答
			for (i=0;i<xmlContent.length;i++) 
			{  
			    var Content = xmlContent[i].firstChild.data;
	            var div = document.createElement("DIV");   
	            div.id = i; 
					if (Content == "没有解答") {
					    //alert("1111");
					    div.innerHTML = "<div style='padding:5px;color:#ff0000'>暂时还没有解答</div>"
					}
					else 
					{
				    var Author = xmlAuthor[i].firstChild.data;
				    var PostTime = xmlAuthor[i].getAttribute('PostTime');
				    var ID = xmlNoI[i].firstChild.data;
				    var IP = xmlIP[i].firstChild.data;
					  var reContent = xmlreContent[i].firstChild.data;
				    div.innerHTML = "<div class='plun' style='clear:both;'><div class='ptitle'><div class='pnoi'><b><font color='blue'>"+ID+"</font></b> 楼:</div><div class='pname'>"+Author+"</div><div class='pIP'>来自：<a href='http://www.ip138.com/ips8.asp?ip="+IP+"&action=2' target='_blank'>"+IP+"</a></div><div class='pltime'>发表于 "+PostTime+"</div></div><div class='pings'>"+Content+"</div><div class='repings'>"+reContent+"</div></div>"
				}
	      document.getElementById("list").appendChild(div);
			}
			 //输出分页信息
			P_Nums = xmlHttp.responseXML.getElementsByTagName("data")[0].getAttribute('P_Nums');
			var A_Nums = xmlHttp.responseXML.getElementsByTagName("data")[0].getAttribute('A_Nums');
			var aaa="[本问题共<font color='#cc0000'>"+A_Nums*1+"</font>条解答| 每页显示<font color='#cc0000'>6</font>条解答]";
		
			if (P_Nums>1) 
			{
		    	var page = xmlHttp.responseXML.getElementsByTagName("data")[0].getAttribute('page');
		    	var ID = xmlHttp.responseXML.getElementsByTagName("data")[0].getAttribute('ID');
				  var D_Nums = xmlHttp.responseXML.getElementsByTagName("data")[0].getAttribute('D_Nums');
			    var l1 = "<a class='total'>&nbsp;"+D_Nums+"&nbsp;</a><a class='pages'><span>"+page+"/"+P_Nums+"</span></a>"
				l1 = (page>1)?l1+"<a href='javascript:showanswer("+ID+",1)' class='redirect' title='第一页'><<&nbsp;</a>":l1;
				var l2 = "";
				for (var i =1;i<=P_Nums;i++) 
				{
				     l2 += (i == page)?"<a class='curpage'>"+i+"</a>":"<a href='javascript:showanswer("+ID+","+i+")' class='num'>"+i+"</a>"
				}
				l2 = (page == P_Nums)?l2:l2+"<a href='javascript:shoshowanswerwre("+ID+","+P_Nums+")' class='redirect' title='最后页'>>>&nbsp;</a>"
				document.getElementById("MultiPage").innerHTML = l1+l2;
			}
		}
		
	}
  function guanliananli() 
	{
	   	alert("a");
	
		$('.box-al').fadeIn();
		$('.pul-close').click(function(){
			$('.box-al').fadeOut();
		});
	
	}