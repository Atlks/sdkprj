// JavaScript Document

function atiOrm()
{
	this.merge_after_goto_url;
		this.retOkMsg;
	this.disableDefRetOkMsg=false;
	this.formid;
	this.isDirectToLookPage=false;
	this.callbackFun;
	this.postMethod="get";
	this.objtype="sql";
	this.obj;
}
//todox  q41 jqUtil.json2form  
atiOrm.prototype.bind2form= function(data)
{
	 jo=str2json(data);
	  jo=jo[0];
	  for (prop in jo)
	  {
		  var o=$("#"+prop);
		  if(o[0]==undefined)
			  continue;
		  
		  if( o[0].tagName =="SPAN")
			$("#"+prop).text( jo[prop]);
		 if( o[0].tagName=="INPUT" || o[0].tagName=="TEXTAREA")
			 o.val(jo[prop]);
		   if( o[0].tagName =="DIV")
			$("#"+prop).text( jo[prop]);
		 
		  
		 
	  }
	
}

//atiOrm.prototype
atiOrm.prototype.t= function(data)
{
	alert(this.merge_after_goto_url);
}


atiOrm.prototype.default_callback= function(data)
{
//	 jo=str2json(data);
	   logx(data);
//--------------------------------ex 	   
	   try{
	 	  processJavaEx_V2q315(data);
	   }catch(e)
	   {
		//   alert(data);
		 //  showErr(data);
			if(catchEx(e,"com.attilax.user.NotLoginEx"))
			  {
				  alert("没人登录,请先登录。。");
					logx("not login");
					return;
					//window.location="../user/login.html";
			  }
			  alert("--e:  " +data);
			  return;
//			  else{
			//	  logx("logined"); alert("login");
				//  }
	   }	

//-------------------------cuztom callback
	   this.callbackFun(data);
	
	//---------------tip rzt
	   if(!this.disableDefRetOkMsg)
		   alert("保存成功，返回结果:"+data);
	   if(this.retOkMsg)
		 alert(this.retOkMsg);

//------------goto 
		if(this.isDirectToLookPage)
		{
	  if(data==1)
			if(confirm("转到查看页面??"))
			{
				window.location=this.merge_after_goto_url;	
			}
		}
	
	
}
atiOrm.prototype.merge_callback= function(data)
{
	 jo=str2json(data);
	   logx(data);
	   
	   try{
	 	  processJavaEx_V2q315(data);
	   }catch(e)
	   {
		//   alert(data);
		 //  showErr(data);
			if(catchEx(e,"com.attilax.user.NotLoginEx"))
			  {
				  alert("not login");
					logx("not login");
					return;
					//window.location="../user/login.html";
			  }
			  alert("--e:  " +data);
			  return;
//			  else{
			//	  logx("logined"); alert("login");
				//  }
	   }	
	 alert(this.retOkMsg);
	   if(!this.disableDefRetOkMsg)
	   alert("保存成功，返回结果:"+data);
	    if(data==1)
			if(confirm("转到查看页面??"))
			{
				window.location=this.merge_after_goto_url;	
			}
	
	
}
   

atiOrm.prototype.merge=function(metaData,merge_callback_fun)
  {
	// this.
	       if(!metaData)
	      		 	metaData="";
	     	var mp=$("form").serialize();
			if(this.formid!=null)
				mp=$("#"+this.formid).serialize();
			var fldAppFun=dslUtil.getFldAppFun(  mp);
			if(!mp)
				mp="adaljfdlasjfdla=aa";
		 
			this.objtype="table";
	  mp=mp+"&$tb=@tb@&$tbtype=@tbtype@&$method=com.attilax.dataService.DataService.exe&$callback=page_load_callback&$mod=userMod&$view_store_path=com/attilax/order&$op=merge&"+metaData+"&$fldAppFun="+encodeURIComponent(fldAppFun);
			mp=mp.replace("@tbtype@",this.objtype).replace("@tb@",this.obj);
		 //	alert("get post mp:"+mp);
		 var ajb=new AtiJsBridge();
		 ajb.method="post";
		 try{
			 if( arguments.length==1 || arguments.length==0)
				ajb.exe(mp,this.merge_callback.bind(this));	
			else
				ajb.exe(mp,merge_callback_fun.bind(this));	
		 }catch(e)
		 {
			 showErr(e);
		 }
		 
  }
  
  atiOrm.prototype.save=function(metaData,callback_fun)
  {
  	this.insert(metaData,callback_fun);
  }
  atiOrm.prototype.insert=function(metaData,callback_fun)
  {
	 
	 this.callbackFun=callback_fun;
	     	var mp=$("form").serialize();
			if(this.formid!=null)
				mp=$("#"+this.formid).serialize();
			var fldAppFun=dslUtil.getFldAppFun(  mp);
		 
			
	  mp=mp+"&$method=com.attilax.dataService.DataService.exe&$callback=page_load_callback&$mod=userMod&$view_store_path=com/attilax/order&$op=i&"+metaData+"&$fldAppFun="+encodeURIComponent(fldAppFun);
		 //	alert("get post mp:"+mp);
		 var ajb=new AtiJsBridge();
		 ajb.method=this.postMethod;
		 
		 try{
			// if( arguments.length==1)
				ajb.exe(mp,this.default_callback.bind(this));	
			 
		 }catch(e)
		 {
			 showErr(e);
		 }
		 
  }
    atiOrm.prototype.update=function(metaData,callback_fun)
  {
	 
	 this.callbackFun=callback_fun;
	     	var mp=$("form").serialize();
			if(this.formid!=null)
				mp=$("#"+this.formid).serialize();
			var fldAppFun=dslUtil.getFldAppFun(  mp);
		 
			
	  mp=mp+"&$method=com.attilax.dataService.DataService.exe&$callback=page_load_callback&$mod=userMod&$view_store_path=com/attilax/order&$op=u&"+metaData+"&$fldAppFun="+encodeURIComponent(fldAppFun);
		 //	alert("get post mp:"+mp);
		 var ajb=new AtiJsBridge();
		 ajb.method=this.postMethod;
		 
		 try{
			// if( arguments.length==1)
				ajb.exe(mp,this.default_callback.bind(this));	
			 
		 }catch(e)
		 {
			 showErr(e);
		 }
		 
  }
  
   atiOrm.prototype.del=function(metaData,callback_fun)
  {
	 
	 this.callbackFun=callback_fun;
	     	var mp=$("form").serialize();
			if(this.formid!=null)
				mp=$("#"+this.formid).serialize();
			var fldAppFun=dslUtil.getFldAppFun(  mp);
		 
			
	  mp=mp+"&$method=com.attilax.dataService.DataService.exe&$callback=page_load_callback&$mod=userMod&$view_store_path=com/attilax/order&$op=d&"+metaData+"&$fldAppFun="+encodeURIComponent(fldAppFun);
		 //	alert("get post mp:"+mp);
		 var ajb=new AtiJsBridge();
		 ajb.method=this.postMethod;
		 
		 try{
			// if( arguments.length==1)
				ajb.exe(mp,this.default_callback.bind(this));	
			 
		 }catch(e)
		 {
			 showErr(e);
		 }
		 
  }
  
atiOrm.prototype.query=function(metaData,merge_callback_fun)
  {
	 
	     	var mp=$("form").serialize();
			var fldAppFun=dslUtil.getFldAppFun(  mp);
		 
	//	if(this.objtype)	
	  mp=mp+"&$tbtype="+this.objtype+"&$tb=@tab@&$method=com.attilax.dataService.DataService.exe&$callback=page_load_callback&$mod=userMod&$view_store_path=com/attilax/order&$op=q&"+metaData+"&$fldAppFun="+encodeURIComponent(fldAppFun);
	  mp=mp.replace("@tab@",this.obj);
		 //	alert("get post mp:"+mp);
		 var ajb=new AtiJsBridge();
		// ajb.method="post";
		 try{
			 if( arguments.length==1)
				ajb.exe(mp,this.merge_callback.bind(this));	
			else
				ajb.exe(mp,merge_callback_fun.bind(this));	
		 }catch(e)
		 {
			 showErr(e);
		 }
		 
  }