// JavaScript Document
function JavaEx()
{
this.typex="";
this.message="";	
	
}

function catchEx(e,exname)
{
	if(e["@type"]==exname)
		return true;
	else 
		return false;
}
function processJavaEXob7(data)
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
			if( e instanceof SyntaxError)

return;
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
		var ce = new JavaEx();

ce.typex=data.typex;

ce.message= data.message;

   throw ce;
 	// throw data.message;
  }
  else
 	return false;	
}