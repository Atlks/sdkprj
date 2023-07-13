// JavaScript Document

function dataService()
{
	this.merge_after_goto_url;
		this.retOkMsg;
	this.disableDefRetOkMsg=false;
}


//dataService.prototype
dataService.prototype.t= function(data)
{
	alert(this.merge_after_goto_url);
}
dataService.prototype.merge_callback= function(data)
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
   

dataService.prototype.merge=function(metaData,merge_callback_fun)
  {
	 
	     	var mp=$("form").serialize();
			var fldAppFun=dslUtil.getFldAppFun(  mp);
		 
			
	  mp=mp+"&$method=com.attilax.urldsl.UrlDsl2SqlStoreService.exe&$callback=page_load_callback&$mod=userMod&$view_store_path=com/attilax/order&$op=insert&"+metaData+"&$fldAppFun="+encodeURIComponent(fldAppFun);
		 //	alert("get post mp:"+mp);
		 var ajb=new AtiJsBridge();
		 ajb.method="post";
		 try{
			 if( arguments.length==1)
				ajb.exe(mp,this.merge_callback.bind(this));	
			else
				ajb.exe(mp,this.merge_callback_fun.bind(this));	
		 }catch(e)
		 {
			 showErr(e);
		 }
		 
  }