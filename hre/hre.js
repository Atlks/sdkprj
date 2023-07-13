// JavaScript Document
// JavaScript Document

var HRE={};

HRE.exe=function(param,callback)
{
	
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
	if(window.location.host!="")  //web envi
	$.ajax(
                    {
                        type: "get",
                        url: $approot+"/com.attilax/hre/hre.jsp?iocx="+$iocx_iner,
                        data:param,
                        dataType: "text",
                        success: function(data) {
                          //  $("#divShow").html(data);
						  data=$.trim(data);
						  callback(data);
                     }
					 
	
	 });
	 //-------------------
	// alert("window.location.host:"+window.location.host);
	if(	window.location.host=="")  //cs envi
	{
	//	alert(sendNSCommand);
		//var json=urlParams2json(param);
		//alert(sendNSCommand);
		sendNSCommand(param,"hre3");
//		alert("sendNSCommand ok");
		
	}
	
	
}

function inDesktopMode()
{
	return 	window.location.host=="";
}