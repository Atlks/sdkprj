// JavaScript Document


  window.onerror=function(errorMessage, scriptURI, lineNumber, columnNumber, error)
  { 
 
	  //ip6  cp hto only 4g param   ma zuihou yig...first param is object
	//  alert( JSON.stringify(arguments));
	//  alert(error);
	 //	 alert( JSON.stringify(errorMessage));
	try{
	 var errmsg=JSON.stringify(arguments);
	 console.log("--win.onerror::"+errmsg);
	 errmsg=encodeURIComponent(errmsg);
	  var  mp="$method=com.attilax.log.FileLogService.log&$callback=page_load_callback&$mod=userMod&$tabletype=view&$table=orderView&$view_store_path=com/attilax/order&$op=insert&param="+errmsg;
		 //	alert("get post mp:"+mp);
	 var jsb=new AtiJsBridge();
	jsb.exe(mp,function(data)
		{
			console.log("--win.onerror rzt:"+data);
		}
	);	
	}catch(e)
	
	{  // trycatch  beir recyele err.
	    console.log(e);	
	}
	 
 
  }