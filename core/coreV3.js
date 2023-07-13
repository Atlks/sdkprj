// JavaScript Document
// jqx


// JavaScript Document


String.prototype.startWith = function(compareStr){
return this.indexOf(compareStr) == 0;
}


 String.prototype.endWith=function(str){  
            if(str==null||str==""||this.length==0||str.length>this.length)  
              return false;  
            if(this.substring(this.length-str.length)==str)  
              return true;  
            else  
              return false;  
            return true;  
        }  
		
		//-----------------------cmsx  
		
		
		// JavaScript Document
// JavaScript Document


function  get_post_intro_success (d){
                    var txt = MI.string.html(String(d)),
                        txt_arr = txt.split('\n'),
                        txt_arr_new =[];//txt.replace(/\n/g, '<br>');
                    for (var i=0,j=txt_arr.length; i<j; i++){
                        (txt_arr[i] != '') && txt_arr_new.push(txt_arr[i])
                    }
                    $('.activeview .movie_page .movie_detail').html(txt_arr_new.join('<br>'));
                  }
//｛“category”:5}
function get_post_intro(txt_file)
{
	var mp="$method=aaaCms.CmsImpLocalFileVer.get_post_intro&$callback=get_post_intro_success&param="+txt_file;
	 //	alert(mp);
		HRE.exe(mp,get_post_intro_success);	
	
}
//function get_posts_callback(data)
//{
// //alert(data);
//	data=str2json(data);
//	try{	
//		 arr=data;
//	//	 gotoPageEvent(1);
//		  
//	  
//	  }catch(e)
//	{
//		showErr(e);	
//	}
//}
function get_posts(paramJsonMap)
{
try{	

		//1:爱情类,2:动画类,3:动作类,4:港台国产,5:剧情类,6:科幻类,7:恐怖类,8:悬疑类,9:战争类,10:喜剧类
	var cate_map={grid0:6,grid1:"爱情类",grid2:"动画类",grid3:"动作类",grid4:"港台国产",grid5:"剧情类",grid6:"科幻类",grid7:"恐怖类",grid8:"悬疑类",grid9:"战争类",grid10:"喜剧类"};
	var cate_cn=cate_map["grid"+paramJsonMap.cate];
	cate_cn=paramJsonMap.cate;
	  	mid=encodeURIComponent( JSON.stringify(paramJsonMap)  );
				
				var meth="aaaDbManager.SqlExecutor.exe";
					meth=encodeURIComponent(meth);
				var mp="$method="+meth+"&$callback=get_posts_callback&sql="+get_posts_sql+"&rdm="+Math.random()+"&param1="+get_posts_sql;
				console.log(mp);
			//	alert("get post mp:"+mp);
				HRE.exe(mp,get_posts_callback);	
}catch(e)
{
	showErr(e);	
}
}


function get_post( id)
{
	
	try{
		var mid= id;
	 
				mid=encodeURIComponent(mid);
				
				var meth="aaaDbManager.SqlExecutor.exe";
					meth=encodeURIComponent(meth);
					get_post_sql=get_post_sql.replace("@id@",id);
				var mp="$method="+meth+"&$callback=get_post_callback&sql="+get_post_sql;
			//	alert("get post mp:"+mp);
				HRE.exe(mp,get_post_callback);	
				return;
			 
	
	
	}catch(e)
	{
		showErr(e);	
	}
}


function query_posts( keyword)
{
	try{
//	alert(keyword);
	var xhr=threadLocalParamMap.xhr;
var fn=threadLocalParamMap.fn;
var err=threadLocalParamMap.err;
//var value=threadLocalParamMap.value;

	if(	window.location.host=="")  //cs envi
			{
			//	mid=encodeURIComponent(mid);
				var mp="$method=aaaCms.CmsImpLocalFileVer.searchV2&$callback=get_posts_callback&param="+keyword;
			//	alert("get post mp:"+mp);
				HRE.exe(mp,get_posts_callback);	
				return;
			}
			else
	 xhr.req({http_param: "select   * from gv_material where material_keyword like '"+keyword+"%'  limit 30 "}, fn, err);
	 
	}catch(e)
	{
	showErr(e);	
	}
}
		
		//-----------------pagging
		
		
		// JavaScript Document
//----------------not with ui ..should overrid yha ..
//------------js function overrid by  js file order ..
// JavaScript Document
//todox  ini pageInfoStyle pagesize and bind SelectPageevent===query..
var onSelectPage= function(pageNumber, pageSize){
//$('#content').panel('refresh', 'show_content.php?page='+pageNumber);
  query();
}

//=========================================
  
//function pageIni(info)
//{
////{
////    total:2000,
////    pageSize:10
////    }	
//var total=info.total;
//var pageSize=info.pageSize;
//$("#totalPages").html(total/pageSize);
//$("#totalRows").html(total);
////if(info.pageNumber==null)
////if($("#page").val()=="")
////	$("#page").val(1);
//}
// setPageInfo({"total":data.total,"pageSize":7});

var pageCtrlId="page_page";
function setPageInfo(info)
{
//{pageSize
//    total:2000,
//   
//    }	
var total=info.total;
 var pageSize=$("#pagesize").val();
$("#totalPages").html(Math.ceil(total/pageSize));

//fix page err
try{
var curPage= parseInt(  $("#"+pageCtrlId).val(),10);
var  totalPageShow= parseInt($("#totalPages").text(),10);
if(curPage>totalPageShow)
{
	//setNextPageInfoNPaging(1);
}
}catch(e){}


$("#totalRows").html(total);
//if(info.pageNumber==null)
 setBtnDisabled()
}

function resetPageTo1()
{
	 $("#"+pageCtrlId).val(1);
	 	$("#page_page_lab").html(1);
}

   function setBtnDisabled()
   {
	var curPage= parseInt(  $("#"+pageCtrlId).val(),10);
	$("#nextLastPageBtnArea").show();
		$("#firstPrePageBtnArea").show();
	if(curPage==1)
	{
		$("#firstPageBtn").attr("disabled",true);
		 $("#prePageBtn").attr("disabled",true);
		 	$("#firstPageBtn,#prePageBtn").addClass('disable');
			$("#firstPrePageBtnArea").hide();
	}   
	if(curPage==$("#totalPages").text())
	{
		$("#nextLastPageBtnArea").hide();
	//	$("#firstPrePageBtnArea").hide();
	}
   }

function nextPage()
{
	var curPage= parseInt(  $("#"+pageCtrlId).val(),10);
	var nextPage=curPage+1;
		setNextPageInfoNPaging(nextPage);
	setBtnDisabled()
}
function firstPage()
{
	var curPage= parseInt(  $("#"+pageCtrlId).val(),10);
	var nextPage=1;
		setNextPageInfoNPaging(nextPage);
		setBtnDisabled()
	
}
function lastPage()
{
	var curPage= parseInt(  $("#"+pageCtrlId).val(),10);
	var nextPage=$("#totalPages").text();
	setNextPageInfoNPaging(nextPage);
	setBtnDisabled()
	
}

function prePage()
{
	var curPage= parseInt(  $("#"+pageCtrlId).val(),10);
	var nextPage=curPage-1;
	setNextPageInfoNPaging(nextPage);
	setBtnDisabled()
	 
	
}



function 	setNextPageInfoNPaging(nextPage)
{
		$("#"+pageCtrlId).val(nextPage);
		$("#page_page_lab").html(nextPage);
	var pagesize=$("#pagesize").val();
	onSelectPage(nextPage,pagesize);
}
function page_go()
{
var goPage;
try{
goPage= parseInt(  	$("#pageItem").val(),10);
}catch(e)
{alert(e);return;
}
//var curPage= parseInt(  $("#"+pageCtrlId).val(),10);
if(goPage=="")
{alert("页码不能为空");return;
}
if(goPage<=0)
{
	alert("页码不能小于0");return;
}
var  total= parseInt($("#totalPages").text(),10);
if(goPage>total)
{alert("跳转页数不能大于总页数，请重新输入");return;}
setNextPageInfoNPaging(goPage);
	setBtnDisabled();

}


//----page gui

 
//	var o={	pagesize:10,page:page_val,keyword:””,rows:arr};
//pagesize:10,page:1,keyword:”kwxxx”,cate_id:7

//event get_posts  list>>bind2ui
//
function listPaf2(params)
{
	var curPage= parseInt(  $("#page_ui").text(),10);
	var page_val=curPage+1;
	params.page=page_val;
     get_posts(params);
	 $("#page_ui").text(page_val);
}

function next_click()
{
	 
	//arr
	 //page from ui get
	 var arr=[];
	var o={	pagesize:3,keyword:"",rows:arr,bind_handler:bindPa};
	//page gui
	 listPaf2(o);
	

}

function firstPageEvent()
{
	
}
function lastPageEvent()
{
	
}
function prePageEvent()
{
	
}
function gotoPageEvent(page)
{
	 //
	 clr_list_area();
	//arr
	 //page from ui get,
	 $("#page_ui").text(0);
	var o={	pagesize:3,keyword:"",rows:arr,bind_handler:bindPa,page:1};
	//page gui
	 listPaf2(o);
	

}

function scrollSpyEnterEvent()
{
 
    console.log('进入视口');
	$.AMUI.progress.start();
	next_click();
	window.setTimeout(function(){
		$.AMUI.progress.done();
		},2000);
	
 
}

function scrollSpyLeaveEvent()
{ console.log('离开视口');
}

function setPageSpy()
{
$(function() {
  $('#scrool_spy').on('inview.scrollspy.amui',scrollSpyEnterEvent).on('outview.scrollspy.amui',scrollSpyLeaveEvent);
  console.log("  ini ok");
  
/*$('#next_btn').scrollspy({
alert//("in view2");
//	next_click();
});*/
 
});	
	
}




//-----------------yaml


function yaml2json(catesQ319)
{
var map={};
var a=	catesQ319.split(",");
for(i=0;i<a.length;i++)
{
  var itemx=a[i];
  var a2=itemx.split(":");
  map[i]=a2[1];
  	
}
	return map;
}

//q42
function yaml2jsonV2(catesQ319)
{
var map={};
var a=	catesQ319.split(",");
for(i=0;i<a.length;i++)
{
  var itemx=a[i];
  var a2=itemx.split(":");
  map[a2[0]]=a2[1];
  	
}
	return map;
}
//-------------------------------time

 
Date.prototype.format = function(format)
{
	var o =
	{
	"M+" : this.getUTCMonth()+1, //month
	"d+" : this.getUTCDate(), //day
	"h+" : this.getUTCHours(), //hour
	"m+" : this.getUTCMinutes(), //minute
	"s+" : this.getUTCSeconds(), //second
	"q+" : Math.floor((this.getUTCMonth()+3)/3), //quarter
	"S" : this.getMilliseconds() //millisecond
	}
	
	if(/(y+)/.test(format))
	{
	format = format.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));
	}
	
	for(var k in o)
	{
	if(new RegExp("("+ k +")").test(format))
	{
	format = format.replace(RegExp.$1, RegExp.$1.length==1 ? o[k] : ("00"+ o[k]).substr((""+ o[k]).length));
	}
	}
	return format;
}

var testDate = new Date( 1320336000000 );//这里必须是整数，毫秒
var testStr = testDate.format("yyyy年MM月dd日hh小时mm分ss秒");
var testStr2 = testDate.format("hh:mm:ss");


function fmtDate_noyear(datestr)
{
  	if(datestr)
return	datestr.substring(5);
else
return "";
}
function fmtDate(timestamp)
{
	if( timestamp==null)
	return "";
	if(timestamp!=null)
	if( typeof timestamp =="object")
	  timestamp=timestamp.time;
	var testDate = new Date( timestamp );
	var testStr = testDate.format("yyyy-MM-dd");
	return testStr;
}
 //alert(testStr + " " + testStr2); 
 //avaScript 获取当前时间戳：
//第一种方法：
//复制代码 代码如下:
//
//var timestamp = Date.parse(new Date());
//
//结果：1280977330000
//第二种方法：
//复制代码 代码如下:
//
//var timestamp = (new Date()).valueOf();
//
//结果：1280977330748
//
//以上代码将获取从 1970年1月1日午夜开始的毫秒数。二者的区别是，第一种方法的毫秒位上为全零，即只是精确到秒的毫秒数 
function secs2str(sec)
{
	var timestamp = Date.parse(new Date(0)); 
	// alert(timestamp);
	 timestamp=timestamp+sec*1000;
	var testDate = new Date( timestamp );
	var testStr2 = testDate.format("hh:mm:ss");
	return testStr2;
	
}
//alert(secs2str(89));

function getTimestamp()
{
	var timestamp = (new Date()).valueOf(); 
	return 	timestamp;
}
function now_str()
{
var testStr = new Date().format("yyyy-MM-dd hh:mm:ss");
return testStr;	
}
function today()
{
var testStr = new Date().format("yyyy-MM-dd");
return testStr;	
}


   function getLocalTime(nS) {     
       return new Date(parseInt(nS) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");      
    }     
 //   alert(getLocalTime(1177824835));     
 function   formatDate_4java(now)   {     
              var   year=now.year-100;     
              var   month=now.month+1;     
              var   date=now.date;     
              var   hour=now.hours;     
              var   minute=now.minutes;     
              var   second=now.minutes;     
              return   "20"+year+"-"+month+"-"+date+"   "+hour+":"+minute+":"+second;     
 }     
 //_4java_notime
 function   formatDateV2(now)   {     
              var   year=now.year-100;     
              var   month=now.month+1;     
              var   date=now.date;     
              var   hour=now.hours;     
              var   minute=now.minutes;     
              var   second=now.minutes;     
              return   "20"+year+"-"+month+"-"+date+"";     
 }    

//------------------------------------dslUtil

        var dslUtil={};

dslUtil.getFldAppFun=function(url)
{
	var json={};
	var keys=urlUtil.getKeys(url);
	for(var i=0;i<keys.length;i++ )
{
	var key=keys[i];
	key=decodeURIComponent(key);
var	key_for_jq=escapeJquery(key);
	//alert(key_for_jq);
	var fun=$("#"+key_for_jq).attr("fun");
	if(fun)
		json[key]=fun;
    
}
return  JSON.stringify(json);
	
};



//----------------------------------urlUtil


var urlUtil={};
urlUtil.getKeys=function (url)
{
	var r=new Array();
var a=url.split("&");
for(var i=0;i<a.length;i++ )
{
	//e is index
	if(a[i])
	{
		var x=a[i];
		var a2=a[i].split("=");
		r.push(a2[0]);	
	}
}
	return r;
}

//----------------------------import 


var ImportMap={};


function loadCss(file){

if(ImportMap[file])
		return;
	ImportMap[file]=1;


 var cssTag = document.getElementById('loadCss'+file);
  var head = document.getElementsByTagName('head').item(0);
 if(cssTag) head.removeChild(cssTag);


 var   css = document.createElement('link');
    css.href =import_base+file;
    css.rel = 'stylesheet';
    css.type = 'text/css';
    css.id = 'loadCss'+file;
    head.appendChild(css);
}


function importx(jsSrc)
{

if(jsSrc.endWith(".css"))
{
loadCss(jsSrc);
	return;
}

	if(ImportMap[jsSrc])
		return;
	ImportMap[jsSrc]=1;
	 var oHead = document.getElementsByTagName('HEAD').item(0); 

    var oScript= document.createElement("script"); 

    oScript.type = "text/javascript"; 

	
    oScript.src=import_base+jsSrc; 
	if(jsSrc.startWith("./"))  //q47
		oScript.src=jsSrc; 

    oHead.appendChild( oScript); 
	
}


function escapeJquery(srcString)
{
	// 转义之后的结果
	var escapseResult = srcString;

	// javascript正则表达式中的特殊字符
	var jsSpecialChars = ["\\", "^", "$", "*", "?", ".", "+", "(", ")", "[",
			"]", "|", "{", "}"];

	// jquery中的特殊字符,不是正则表达式中的特殊字符
	var jquerySpecialChars = ["~", "`", "@", "#", "%", "&", "=", "'", "\"",
			":", ";", "<", ">", ",", "/"];

	for (var i = 0; i < jsSpecialChars.length; i++) {
		escapseResult = escapseResult.replace(new RegExp("\\"
								+ jsSpecialChars[i], "g"), "\\"
						+ jsSpecialChars[i]);
	}
//alert("--"+escapseResult);
	for (var i = 0; i < jquerySpecialChars.length; i++) {
		escapseResult = escapseResult.replace(new RegExp(jquerySpecialChars[i],
						"g"), "\\" + jquerySpecialChars[i]);
	}


//if(escapseResult.substr(0,1)=="\\")
//	return "\\"+escapseResult;
//	else
	return escapseResult;
}


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


// JavaScript Document

function str_repeat(string,repeat)

{
	s="";
	for(i=0;i<repeat;i++)
	{
		s+=string;
	}
	return s;
}
STR_PAD_LEFT="left";
function str_pad(string,length,pad_string,pad_type)
{
	var rept=length-string.length;
	var pads=str_repeat(pad_string,rept);
	return pads+string;
	
}
String.prototype.startWith = function(compareStr){
return this.indexOf(compareStr) == 0;
}
function start_with(string,substrx)
{
	return string.indexOf(substrx) == 0; 
	
}


 String.prototype.endWith=function(str){  
            if(str==null||str==""||this.length==0||str.length>this.length)  
              return false;  
            if(this.substring(this.length-str.length)==str)  
              return true;  
            else  
              return false;  
            return true;  
        }  


        var urlUtil={};
urlUtil.getKeys=function (url)
{
	var r=new Array();
var a=url.split("&");
for(var i=0;i<a.length;i++ )
{
	//e is index
	if(a[i])
	{
		var x=a[i];
		var a2=a[i].split("=");
		r.push(a2[0]);	
	}
}
	return r;
}


// JavaScript Document
//history 
//v4  add  callback_checkJavaEx
function callback_checkJavaEx(data)
{
	//throw e.msg
	processJavaEx_V2q315(data);
	
}
function AtiJsBridge(){
	
	this.method="get";
	}
AtiJsBridge.prototype.exe=function(param,callback,otherParam)
{
	
	try{
	try{
		param.rdmStr=Math.random();
	}catch(e){
		
		param=param+"&rdmStr2="+Math.random();
	}
//if(	isExitsFunction("submit_befor_check"))
//	submit_befor_check();
	//$iocx="aa";
	$iocx_iner="";
	if(isExitsVariable("$iocx"))
		$iocx_iner=$iocx;
	//jQuery.get("dwr.php?param="+param, [data], [callback])
	//com.attilax/dwr.php
	if(window.location.host!="")  //web envi
	{
	//	alert(apiurl);
	//	apiurl2= start_with (apiurl,"/")?apiurl:"/"+apiurl;
		if($approot=="/")
			$approot2="";
		else
			$approot2=$approot;
	//	apiurl2="/wrmiServlet";
	
		if( typeof(hre_web_url)=="undefined")
		hre_web_url="/wrmiServlet";
		var urlP2= $approot2+hre_web_url+"?iocx="+$iocx_iner;
		console.log("--web ajax url:"+urlP2);
		$.ajax(
						{
							type:  this.method,
							url:urlP2,
							data:param,
							dataType: "text",
							success: function(data) {
							  //  $("#divShow").html(data);
							  data=$.trim(data);
							  try{
								  callback_checkJavaEx(data);
							  }catch(e)
							  {
								  	if(typeof($ex_show_err_str)=="undefined")
										$ex_show_err_str=false;
								  if($ex_show_err_str)
								//  showErr(e);
									 
								//	  alert(data);
								  logx(data);//v5
								//  throw e;
							  }
							  callback(data,otherParam);
						 }
						 
		
		 });
	}
	 //-------------------
	// alert("window.location.host:"+window.location.host);
	if(	window.location.host=="")  //cs envi
	{
	//	alert(sendNSCommand);
		//var json=urlParams2json(param);
		//alert(sendNSCommand);
		sendNSCommand(param,"hre");
//		alert("sendNSCommand ok");
		
	}
	
	}catch(e)
	{
	showErr(e);	
	}
	
	
}

function inDesktopMode()
{
	return 	window.location.host=="";
}


// JavaScript Document

function dataServiceV4()
{
	this.merge_after_goto_url;
		this.retOkMsg;
	this.disableDefRetOkMsg=false;
	this.formid;
	this.isDirectToLookPage=false;
	this.callbackFun;
	this.postMethod="get";
}
//todox  q41 jqUtil.json2form  
dataServiceV4.prototype.bind2form= function(data)
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

//dataServiceV4.prototype
dataServiceV4.prototype.t= function(data)
{
	alert(this.merge_after_goto_url);
}


dataServiceV4.prototype.default_callback= function(data)
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
dataServiceV4.prototype.merge_callback= function(data)
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
   

dataServiceV4.prototype.merge=function(metaData,merge_callback_fun)
  {
	// this.
	     	var mp=$("form").serialize();
			if(this.formid!=null)
				mp=$("#"+this.formid).serialize();
			var fldAppFun=dslUtil.getFldAppFun(  mp);
		 
			
	  mp=mp+"&$method=com.attilax.dataService.DataService.exe&$callback=page_load_callback&$mod=userMod&$view_store_path=com/attilax/order&$op=merge&"+metaData+"&$fldAppFun="+encodeURIComponent(fldAppFun);
		 //	alert("get post mp:"+mp);
		 var ajb=new AtiJsBridge();
		 ajb.method="post";
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
  
  
  dataServiceV4.prototype.insert=function(metaData,callback_fun)
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
    dataServiceV4.prototype.update=function(metaData,callback_fun)
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
  
   dataServiceV4.prototype.del=function(metaData,callback_fun)
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
  
dataServiceV4.prototype.query=function(metaData,merge_callback_fun)
  {
	 
	     	var mp=$("form").serialize();
			var fldAppFun=dslUtil.getFldAppFun(  mp);
		 
			
	  mp=mp+"&$method=com.attilax.dataService.DataService.exe&$callback=page_load_callback&$mod=userMod&$view_store_path=com/attilax/order&$op=q&"+metaData+"&$fldAppFun="+encodeURIComponent(fldAppFun);
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

  // JavaScript Document
function AtiUploadV3(obj_selector)
{
	this.obj_selector=obj_selector;
	this.up_url;
	this.upload_finish_handler;
}
AtiUploadV3.prototype. upload=function()
{
	var self=this;
	try{
	　$("#process_div").progressBar(99);
	}catch(e){
	console.log(e);	
	}
	var fd = new FormData();
//	fd.append("upload", 1);
	fd.append("upfile", $(this.obj_selector).get(0).files[0]);
	$.ajax({
		url: this.up_url,
		type: "POST",
		processData: false,
		contentType: false,
		data: fd,
		success: function(d) {
			console.log(d);
			console.log("----fini");
		//	$("#file_val").val(d);
			// writeCookie("file_url_frmJS",$("#file_val").val(),10);
			
			 self.upload_finish_handler(d);
			 upload_finish();
		}
	});	
}

function upload_finish()
{
window.setTimeout(function()
{
	 try{
	　$("#process_div").fadeOut();
	}catch(e){
	console.log(e);	
	}	
},800);

			
}

 
// for img pre view
function getPicSrc4createObjectURL(fileControlId) {
	
file=	$("#"+fileControlId)[0].files[0];
	var url = null ; 
	if (window.createObjectURL!=undefined) { // basic
		url = window.createObjectURL(file) ;
	} else if (window.URL!=undefined) { // mozilla(firefox)
		url = window.URL.createObjectURL(file) ;
	} else if (window.webkitURL!=undefined) { // webkit or chrome
		url = window.webkitURL.createObjectURL(file) ;
	}
	return url ;
}


// JavaScript Document

function AForm(form_obj_cssSelector)
{
	this.cssSelector=form_obj_cssSelector;
	if( !form_obj_cssSelector)
		this.cssSelector="body";
		
		this.mapper;
		this.mapper_reverse;
		this.base="";
}
AForm.prototype.reverseMapper=function()
{
	this.mapper_reverse={};
	  for (prop in this.mapper)
	  {
		  var key=this.mapper[prop];
			this. mapper_reverse[ key  ]= prop;
	  }
	
}
AForm.prototype.bind=function(obj_json)
{
	
	try{
		if( typeof(obj_json)==String)
	 jo=str2json(obj_json);
	 	else
		var jo=obj_json;
	}catch(e){  console.log(e);}
	
	if(this.mapper)
	{
		 this.reverseMapper();
	//fill ui porop
		  for (prop in this.mapper_reverse)
		  {
			  //cardno
			  var ui_key=this.mapper_reverse[prop];
			  jo[ui_key]=jo[prop];
		  }
		
	}
	 // jo=jo[0];
	  for (prop in jo)
	  {
		  var o=$("#"+prop);
		  if(o[0]==undefined)
		  {
			  o=$("input[name='"+prop+"']");
			   if(o[0]==undefined)
			 	 continue;
		  }
		  
		  if( o[0].tagName =="SPAN")
			$("#"+prop).text( jo[prop]);
		 if( o[0].tagName=="INPUT" || o[0].tagName=="TEXTAREA")
			 o.val(jo[prop]);
		   if( o[0].tagName =="DIV")
			$("#"+prop).text( jo[prop]);
		 if( o[0].tagName =="IMG")
			$("#"+prop).attr("src", this.base+ jo[prop]);
		 
		  
		 
	  }
	  /*
	$(this.cssSelector +" input").each(function(index, element) {
		try{
				var cName= $(element).attr("name");
     		   $(element).val( obj_json[ cName ] );
		}catch(e)
		{
		}
    });
	*/
}

AForm.prototype.bind2form= function(data)
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
