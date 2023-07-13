// JavaScript Document


var dwrC={};
dwrC.exec=function(param,callback,approot)
{
	
	try{
		param.rdmStr=Math.random();
	}catch(e){
		
		param=param+"&rdmStr2="+Math.random();
	}
if(	isExitsFunction("submit_befor_check"))
	submit_befor_check();
	//$iocx="aa";
	$iocx_iner="";
	if(isExitsVariable("$iocx"))
		$iocx_iner=$iocx;
	//jQuery.get("dwr.php?param="+param, [data], [callback])
	if(window.location.host!="")  //web envi
	$.ajax(
                    {
                        type: "get",
                        url: approot+"/com.attilax/dwr.php?iocx="+$iocx_iner,
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
		
		var json=urlParams2json(param);
		sendNSCommand(json.method,param,callback);
//		alert("sendNSCommand ok");
		
	}
	
	
}

// submit as form
//when fil is much ..easy.
//
 function submitx($appRoot)
 {
	// alert($appRoot);
	 
	var mp=$("form").serialize();
//	alert(mp);
//	mp.id=85495; frm cookie   
//	mp.method="app-shop";
//	mp.param=
//p89
	if( isExitsVariable( "pluginsAti"))
	{
		//for ajax ,must trans in param
		do_action("submit_before_check",mp,submitx2);
	}else
	submitx2();
		
 
	
 }
  function submitx2(data)
  {
	  try{
	  var mp=$("form").serialize();
	  dwrC.exec(mp,function(data){
		
			submit_finish_event(data);
		 	
		},$appRoot);
	 }catch(e)
	 {
		 showErr(e);
	 }
  }
 //when fld is few .better
  function submit_as_param(mp)
 {
	// alert($appRoot);
	 try{
//	var mp=$("form").serialize();
//	alert(mp);
//	mp.id=85495; frm cookie   
//	mp.method="app-shop";
//	mp.param=
	dwrC.exec(mp,function(data){
		
			submit_finish_event(data);
		 	
		},$appRoot);
	 }catch(e)
	 {
		 showErr(e);
	 }
 }