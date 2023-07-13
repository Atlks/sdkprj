// JavaScript Document
//history 
//v4  add  callback_checkJavaEx
function callback_checkJavaEx(data)
{
	//throw e.msg
	processJavaEx_V2q315(data);
	
}
function AtiJsBridge(){
	
	this.method="get";
	}
AtiJsBridge.prototype.exe=function(param,callback,otherParam)
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
	
		if( typeof(hre_web_url)=="undefined")
		hre_web_url="/wrmiServlet";
		var urlP2= $approot2+hre_web_url+"?iocx="+$iocx_iner+"&$rdm="+Math.random();
		console.log("--AtiJsBridge ajax url:"+urlP2);
		$.ajax(
						{
							type:  this.method,
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
								  	if(typeof($ex_show_err_str)=="undefined")
										$ex_show_err_str=false;
								  if($ex_show_err_str)
								//  showErr(e);
									 
								//	  alert(data);
								  logx("--AtiJsBridge rzt:"+data);//v5
								//  throw e;
							  }
							  callback(data,otherParam);
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