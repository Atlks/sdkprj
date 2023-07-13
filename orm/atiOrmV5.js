// JavaScript Document
/**
v5 add this.jsbrj; can inject
this.iniparam="";


iniQbj dif ver can use

*/
function atiOrmV5()
{
	this.merge_after_goto_url;
		this.retOkMsg;
	this.disableDefRetOkMsg=false;
	this.formid;
	this.isDirectToLookPage=false;
	this.callbackFun;
	this.postMethod="get";
	this.objtype="sql";    //should be sql,,cause query is 80% condition.
	this.obj;
	this.msg_ok="ok";
	this.msg_err="未知错误，请联系管理员";
	this.login_url="";
	this.metaParam;
	this.notloginEventHandler;
	this.jsbrj;
	this.iniparam="";
}
//todox  q41 jqUtil.json2form  
 

//atiOrmV5.prototype
atiOrmV5.prototype.t= function(data)
{
	alert(this.merge_after_goto_url);
}
atiOrmV5.prototype.insert_callback= function(data)
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
	 //  if(!this.disableDefRetOkMsg)
	//	   alert("保存成功，返回结果:"+data);
	   if(this.retOkMsg)
		 alert(this.retOkMsg);
		 if(!disableDefRetOkMsg)
				 if(this.msg_ok)
					 alert(this.msg_ok);
		if(data==0)
		alert(this.msg_err);

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

atiOrmV5.prototype.default_callback= function(data)
{
 jo=str2json(data);
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
				  	logx("not login");
					if(this.notloginEventHandler)
					{
							  this.notloginEventHandler(data);
							  return;
					}
				  if(confirm("没有登录,请先登录。。"))
				  {					
					 window.location=this.login_url;
					 return;
				  }
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
	 

//------------goto 
	   
	
	
}
atiOrmV5.prototype.merge_callback= function(data)
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
   

atiOrmV5.prototype.merge=function(metaData,merge_callback_fun)
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
	  mp=mp+"&$tb=@tb@&$tbtype=@tbtype@&$method=com.attilax.orm.atiOrmV5.exe&$callback=page_load_callback&$mod=userMod&$view_store_path=com/attilax/order&$op=merge&"+metaData+"&$fldAppFun="+encodeURIComponent(fldAppFun);
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
  
  atiOrmV5.prototype.save=function(metaData,callback_fun)
  {
  	this.insert(metaData,callback_fun);
  }
  atiOrmV5.prototype.insert=function(metaData,callback_fun)
  {
	  this.objtype="table";
	 
	 this.callbackFun=callback_fun;
	     	var mp=$("form").serialize();
			if(this.formid!=null)
				mp=$("#"+this.formid).serialize();
			var fldAppFun=dslUtil.getFldAppFun(  mp);
		 
			
	  mp=mp+"&$tb=@tb@&$tbtype=@tbtype@&$method=com.attilax.dataService.DataService.exe&$callback=page_load_callback&$mod=userMod&$view_store_path=com/attilax/order&$op=i&"+metaData+"&$fldAppFun="+encodeURIComponent(fldAppFun);
		 //	alert("get post mp:"+mp);
		 	mp=mp.replace("@tbtype@",this.objtype).replace("@tb@",this.obj);
		 var ajb=new AtiJsBridge();
		 ajb.method=this.postMethod;
		 
		 try{
			// if( arguments.length==1)
				ajb.exe(mp,this.insert_callback.bind(this));	
			 
		 }catch(e)
		 {
			 showErr(e);
		 }
		 
  }
    atiOrmV5.prototype.update=function(metaData,callback_fun)
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
  
   atiOrmV5.prototype.del=function(metaData,callback_fun)
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
  atiOrmV5.prototype.iniQbj=function()
  {
	  this.iniparam="meth=com.attilax.db.DbServiceV4qb9.executeQuery";
	      var jsb=new AtiJsBridgV13();
		jsb.backend_url="/DslAjaxJsbridge_HttpparamMode_servlet";
			this.jsbrj=jsb;
	 
  }

 
atiOrmV5.prototype.query=function(metaData,merge_callback_fun)
  {
	 
	          	var mp=$("form").serialize();
			var fldAppFun=dslUtil.getFldAppFun(  mp);
		 var code="new(com.attilax.orm.AtiOrmV2).queryAsRzt(\"$sql$\")";
		 code=code.replace("$sql$",this.obj);
		 code=encodeURIComponent(code);
	//	if(this.objtype)
//	alert(code);	
	//  mp=mp+"&$code="+code;
//	  mp=mp.replace("@tab@",this.obj);
	 mp=mp+"&p1="+ encodeURIComponent(this.obj);
	  mp=mp+"&"+this.metaParam;
	  mp=mp+"&"+this.iniparam;
		 //	alert("get post mp:"+mp);
		 var ajb=this.jsbrj;
		// ajb.method="post";
		 try{
		 
				ajb.exe(mp,this.default_callback.bind(this));	
			 
		 }catch(e)
		 {
			 showErr(e);
		 }
		 
  }