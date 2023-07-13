
function getTimestamp()
{
	var timestamp = (new Date()).valueOf();
	return 	timestamp;
}


	exports.getTimestamp = getTimestamp;
	exports.now_str__format_local = now_str__format_local;
	exports.now_str__format_local_filename = now_str__format_local_filename;
exports.getTimestamp=getTimestamp;




function getTimestamp()
{
	var timestamp = (new Date()).valueOf();
	return 	timestamp;
}
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

Date.prototype.format_local = function(format)
{
	var o =
	{
	"M+" : this.getMonth()+1, //month
	"d+" : this.getDate(), //day
	"h+" : this.getHours(), //hour
	"m+" : this.getMinutes(), //minute
	"s+" : this.getSeconds(), //second
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

function fmtDate_local(timestamp)
{
	alert(timestamp);
	if( timestamp==null)
	return "";
	if(timestamp!=null)
	if( typeof timestamp =="object")
	  timestamp=timestamp.time;
	var testDate = new Date( timestamp );
	var testStr = testDate.format_local("yyyy-MM-dd");
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
var testStr = new Date().format("yyyy-MM-dd hh:mm:ss").toLocaleString();
return testStr;	
}

function now_str__format_local()
{
var testStr = new Date().format_local("yyyy-MM-dd hh:mm:ss");
return testStr;	
}

function now_str__format_local_filename()
{
	var testStr = new Date().format_local("yyyy-MM-dd.hhmmss");
	return testStr;
}

function today()
{
var testStr = new Date().format("yyyy-MM-dd");
return testStr;	
}
function today_local()
{
var testStr = new Date().format_local("yyyy-MM-dd");
return testStr;	
}


function todayx()
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