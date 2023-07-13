// JavaScript Document
function processEX(data)
{
	
	if(typeof data=="string")
	{
		try{
		  data = eval(  "(" + data + ")"   );
		}catch(e)
		{
		
		 
			throw "data is not json fmt:"+data;	
		 	//return e;	
		}
		  
		  
	}
		 
  if(data["@type"]!=null && data["@type"]=="java.lang.RuntimeException")
  {
	  if(data.message!=null)
	 	 logx(data.message);
 	throw data.message;
  }
    if(data["@type"]!=null && data["@type"]=="java.lang.Exception")
  {
	  if(data.message!=null)
	 	 logx(data.message);
 	throw data.message;
  }
  if(data["stackTrace"]!=null)
   {
	  if(data.message!=null)
	  	logx(data.message);
 	 throw data.message;
  }
  
  if(data["xdebug_message"]!=null)  
   {
	//  if(data.xdebug_message!=null)
	  	logx(data.xdebug_message);
 	 throw data.xdebug_message;
  }
  else
 	return false;	
}


function processJavaEx_V2q315(data)
{
	
	if(typeof data=="string")
	{
		try{
		  data = eval(  "(" + data + ")"   );
		}catch(e)
		{
		
		//	alert(e);	
			//yaosh puton str zeu return;
			if(e instanceof ReferenceError)
				return; 
				
				
		//	return e;	
		}
		  
		  
	}
		 
  if(data["@type"]!=null && data["@type"]=="java.lang.RuntimeException")
  {
	  if(data.message!=null)
	 	 logx(data.message);
 	throw data.message;
  }
    if(data["@type"]!=null && data["@type"]=="java.lang.Exception")
  {
	  if(data.message!=null)
	 	 logx(data.message);
 	throw data.message;
  }
  if(data["stackTrace"]!=null)
   {
	  if(data.message!=null)
	  	logx(data.message);
 	 throw data;
  }
  
  if(data["xdebug_message"]!=null)  
   {
	//  if(data.xdebug_message!=null)
	  	logx(data.xdebug_message);
 	 throw data.xdebug_message;
  }
  else
 	return false;	
}



function catchEx(e,exname)
{
	if(e["@type"]==exname)
		return true;
	else 
		return false;
}