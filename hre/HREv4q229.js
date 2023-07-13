// JavaScript Document
//history 
//v4  add  callback_checkJavaEx
function callback_checkJavaEx(data)
{
	processJavaEX(data);
	
}
var HRE={};

HRE.exe=function(param,callback)
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
		alert(apiurl);
		apiurl2= start_with (apiurl,"/")?apiurl:"/"+apiurl;
		var urlP2= $approot+apiurl2+"?iocx="+$iocx_iner;
		console.log("--web ajax url:"+urlP2);
		$.ajax(
						{
							type: "get",
							url:urlP2,
							data:param,
							dataType: "text",
							success: function(data) {
							  //  $("#divShow").html(data);
							  data=$.trim(data);
							  try{
							  callback_checkJavaEx(data);
							  }catch(e)
							  {
								  if($ex_show_err_str)
								//  showErr(e);
								alert(data);
								  throw e;
							  }
							  callback(data);
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

function inDesktopMode()
{
	return 	window.location.host=="";
}