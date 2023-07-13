// JavaScript Document

function goto(url)
{
//alert('you display pix:\n' + screen.width + '×' + screen.height + ' px')
//document.getElementById("btn").
//alert("p2.html?"+Math.random());
window.location=url+"?"+Math.random();
}

var coreO8={};
////todox static method,,dyna meth as prototype.xxx
  coreO8.info=function(e){
							try{
								console.info(e.message);
							}catch(e){}
							//alert(e.message);
						};
function logx(msg) {
  try {
	   console.info("----------from  logx");
    console.info("--"+msg);
  } catch (e) {
    // not support console method (ex: IE)
  }
}						
function processJavaEX(data)
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




function showErr(e)
{
		if(typeof e=="string")
		{
			alert(e);
			return
		}
	alert("msg:"+e.message+"\n"+"  lineNumber:"+e.lineNumber+ "\n err_number:"+e.number+"\n  "+"  desc:"+e.description +"\n columnNumber:"+e.columnNumber
 +"\n fileName:"+e.fileName+"\n stack:"+e.stack);
}



//  
function isExitsFunction(funcName) {
    try {
        if (typeof(eval(funcName)) == "function") {
            return true;
        }
    } catch(e) {}
    return false;
}
// 
function isExitsVariable(variableName) {
    try {
        if (typeof(eval(variableName)) == "undefined") {
            // alert("value is undefined"); 
            return false;
        } else {
           // alert("value is true"); 
            return true;
        }
    } catch(e) {
	//	alert(e);
		}
    return false;
}

function str2json(str)
{
	try{
var obj = eval('(' + str + ')');
return obj;
	}catch(e)
	{
		logx("parse json err:"+str);
		throw e;
	}
}


function txt2json(txt)
{
return str2json(txt);	
}

function processEX($submit_rzt)
{
	try{
		processJavaEX($submit_rzt);	
	//	alert("ok");		
	
	}catch(e)	
	{
	//	alert("login_err ");
		 
		throw e;
		
	}
	try{
	 	o=str2json($submit_rzt);  //other ex	
	}catch(e)
	{
			//if(e instanceof ReferenceError)
//			{
//				 showErr(e);
//			}
	//	alert($submit_rzt);
		logx("rez is str:"+$submit_rzt);
		throw e;
	}
}


function GetRandomNum(Min,Max)
{   
var Range = Max - Min;   
var Rand = Math.random();   
return(Min + Math.round(Rand * Range));   
}   

function clr_txt_when(str,obj_raw)
{
	if(obj_raw.value==str)
		obj_raw.value="";
		
		
	
	
}


function restore_txt_when_empty(obj,str)
{
if(obj.value=="")
	obj.value=str;
}


function getUuid() {
		var vNow = new Date();
		var sNow = "";
		sNow += String(vNow.getFullYear());
		sNow += String(vNow.getMonth() + 1);
		sNow += String(vNow.getDate());
		sNow+="_";
		sNow += String(vNow.getHours());
		sNow += String(vNow.getMinutes());
		sNow += String(vNow.getSeconds());
		sNow += String(vNow.getMilliseconds());
	return sNow;
}

String.prototype.trim=function() {  
    return this.replace(/(^\s*)|(\s*$)/g,'');  
}; 