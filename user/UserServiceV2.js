// JavaScript Document
 
  
function UserServiceV2()
{
	//this.loginPage="";
}
//UserServiceV2.prototype.loginPage="";
var loginPageP318="";
UserServiceV2.prototype.page_load_callbackQ318= function (data)
  {
	  var self=arguments.callee;
	  logx("not login"+self.loginPage);
	  jo=str2json(data);
	   logx(data);
	   
	   try{
	 	  processJavaEx_V2q315(data);
	   }catch(e)
	   {
				if(catchEx(e,"com.attilax.user.NotLoginEx"))
			  {
				  alert("not login");
					logx("not login"+loginPageP318);
					window.location= loginPageP318;
			  }
			  else{
				  logx("logined"); alert("login");
				  }
	   }
	   
	//  for (prop in jo)
//	  {
//		  $("#"+prop).text( jo[prop]);
//	  }
	
	 // if(jo["@type"]=="")
		
//alert(data);

  } 
UserServiceV2.prototype.ifNotLoginGotoLoginPage=function(loginPage)
{
	this.loginPage=loginPage;
	loginPageP318=loginPage;
	 	var mp="";//$("#formx").serialize();
	  mp=mp+"&$method=com.attilax.user.UserServiceV2.getCurUserinfo&$callback=page_load_callback&$mod=userMod&$tabletype=view&$table=orderView&$view_store_path=com/attilax/order&utype=mer";
		 //	alert("get post mp:"+mp);
		 try{
	HRE.exe(mp,this.page_load_callbackQ318);	
		 }catch(e)
		 {
			 alert(e);
		 }
	
}


UserServiceV2.prototype.loginout=function()
{
	
	
}