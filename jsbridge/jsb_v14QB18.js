// JavaScript Document
//history 
//v4  add  callback_checkJavaEx
//v13  add  this.backend_url=null;
//v14  inner ex check && ex captor..
function callback_checkJavaEx(data)
{
	//throw e.msg
	processJavaEx_V2q315(data);
	
}
function AtiJsBridgV14(){
	
	this.method="get";
	this.backend_url=null;
	this.exCaptors=[];
	this.exProcessor=null;
	
	this.iniAsDslAjaxJsbridgeServletV3=function()
	{
	this.backend_url ="/DslAjaxJsbridgeServletV3";	
	}
	}
	
	
AtiJsBridgV14.prototype.exe=function(param,callback7,otherParam)
{
	
	try{
	try{
		param.rdmStr=Math.random();
	}catch(e){
		
		param=param+"&rdmStr2="+Math.random();
	}
//if(	isExitsFunction("submit_befor_check"))
//	submit_befor_check();
	//$iocx="aa";
	$iocx_iner="";
	if(isExitsVariable("$iocx"))
		$iocx_iner=$iocx;
	//jQuery.get("dwr.php?param="+param, [data], [callback])
	//com.attilax/dwr.php
	if(window.location.host!="")  //web envi
	{
	//	alert(apiurl);
	//	apiurl2= start_with (apiurl,"/")?apiurl:"/"+apiurl;
		if($approot=="/")
			$approot2="";
		else
			$approot2=$approot;
	//	apiurl2="/wrmiServlet";
	
	//	if( typeof(hre_web_url)=="undefined")
	if(this.backend_url==null)
		this.backend_url="/DslAjaxJsbridgeServletV2";
	//	alert(hre_web_url);
		var urlP2= $approot2+this.backend_url+"?iocx="+$iocx_iner+"&$rdm="+Math.random();
		console.log("--AtiJsBridgV14 ajax url:"+urlP2);
	 var exProcessor1=this.exProcessor;
		$.ajax({
							type:  this.method,
							url:urlP2,
							data:param,
							dataType: "text",
							error: function (xhr) { 
							
							alert('动态页错了\n\n'+JSON.stringify(arguments));
							 },
							success: function(data) {
							  //  $("#divShow").html(data);
									  data=$.trim(data);
									  if(exProcessor1!=null)
									  {
										   if(exProcessor1.exeExCapt_e(data))
												return;	
									  }						 
									  callback7(data,otherParam);
								 } 
						 
		
		 });
	}
	 //-------------------
	// alert("window.location.host:"+window.location.host);
	if(	window.location.host=="")  //cs envi
	{
	//	alert(sendNSCommand);
		//var json=urlParams2json(param);
		//alert(sendNSCommand);
		sendNSCommand(param,"hre");
//		alert("sendNSCommand ok");
		
	}
	
	}catch(e)
	{
	showErr(e);	
	}
	
	
}

/**
error
类型：Function
默认值: 自动判断 (xml 或 html)。请求失败时调用此函数。
有以下三个参数：XMLHttpRequest 对象、错误信息、（可选）捕获的异常对象。
如果发生了错误，错误信息（第二个参数）除了得到 null 之外，还可能是 "timeout", "error", "notmodified" 和 "parsererror"。
这是一个 Ajax 事件。
*/

function inDesktopMode()
{
	return 	window.location.host=="";
}