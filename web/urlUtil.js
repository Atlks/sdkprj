// JavaScript Document

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
urlUtil.pagename=function(){
	//var url=window.location;
	var url=window.location.href;
var splash=url.lastIndexOf("/");
var dot=url.lastIndexOf(".");
var mainame=url.substring (splash+1,dot);
console.log("---mainame:"+mainame);
return mainame;
	
}
