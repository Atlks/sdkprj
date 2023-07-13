// JavaScript Document
function JavaEx()
{
this.typex="";
this.message="";	
	
}

//com.attilax.user.ex.UserExistEx
   
function ExProcessor(e_frm_java)
{
	this.e=e_frm_java;
	this.exCaptors=[];
	this.addExCaptor=function(ex,clbk){
		var ExCaptor={};
		ExCaptor.ex=ex;
		ExCaptor.clbk=clbk;
	    this.exCaptors.push( ExCaptor);
		//if(catchEx(e,"com.attilax.secury.LoginException"))
		
		
	}
	this.exeExCapt=function()
	{
	 
	   try{
			 convert2jsEx(e_frm_java)
			 }catch(e)
		 {
			 
			 	for(var i=0;i<this.exCaptors.length;i++) 
				{
					var ec=this.exCaptors[i];
					if(ec.ex==e["@type"])
					{
						ec.clbk(e);	
					}
				}
						  
		 }
	
			
	}
	
	this.exeExCapt_e=function(e)
	{
	 	this.e=e;
	   try{
			 convert2jsEx(e)
			 }catch(e)
		 {
			 
			 	for(var i=0;i<this.exCaptors.length;i++) 
				{
					var ec=this.exCaptors[i];
					if(ec.ex==e["@type"])
					{
						  ec.clbk(e);	
						  return true;
					}
				}
						  
		 }
	
			
	}
	
}
	
		
	

	
function catchEx(e,exname)
{
	if(e["@type"]==exname)
		return true;
	else 
		return false;
}

 function convert2jsEx(data)
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
 	throw data.cause;
  }
 else   if(data["@type"]!=null && data["@type"]=="java.lang.Exception")
  {
	throw data.cause;
  }
  else if(data["stackTrace"]!=null)
   {
	 
 	 throw data;
  }  
 else  if(data["xdebug_message"]!=null)  
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