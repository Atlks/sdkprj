// JavaScript Document

function getJsonLength(jsonData){ var jsonLength = 0; for(var item in jsonData){ jsonLength++; } return jsonLength; }

/*
2. 浏览器支持的转换方式(Firefox，chrome，opera，safari，ie9，ie8)等浏览器：

JSON.parse(jsonstr); //可以将json字符串转换成json对象 
JSON.stringify(jsonobj); //可以将json对象转换成json对符串 
var cmd='   ';
	cmd+='  $("input[name=\'title\']").val("@title@"); $("input[name=\'need_num\']").val("@need_num@"); ';
	cmd+='  $("input[name=\'category_url\']").val("@category_url@"); $("input[name=\'price\']").val("1"); ';
	cmd+='  $("#id_description").val("@id_description@"); $("input[name=\'need_num\']").val("@need_num@"); ';
*/



function artTxt2obj(s)
{
var a=s.split("\r\n");
var o={};
var cache="";
var k="";
for(var i=0;i<a.length;i++)
{
	
	var line=a[i];
	if(line.indexOf("#")==0)
	continue;
//	var a1=line.split(":");
	var idx=line.indexOf(":");
	if(i==0)
	{
		 k=line.substr(0,idx);
		 cache=line.substr(idx+1);
		continue;	
	}
	
	if( line.indexOf(":")>0)  //caontains
	{
		
		if(k.length>0) 
				o[k]=cache;	//finish last pre yg ..
			
				 k=line.substr(0,idx);
				 cache=line.substr(idx+1);
				continue;
	 
	//	  k=line.substr(0,idx);
		//var v=line.substr(idx+1);
		//o[k]=v;
	//	cache=line.substr(idx+1);
		
	}else
	{
		cache=cache+line+"\r\n";
	}
	
}
	if(k.length>0) 
o[k]=cache;  //last item.
//alert(JSON.stringify(o));
return o;
}
function SmpTxt2json(s)
{
	var o={};
var a=s.split(",");
for(var i=0;i<a.length;i++)
{
	var a2=a[i].split(":");
	o[a2[0]]=a2[1];
	
}
return o;
	
}
function fmtObj(cmd,mapper,o){
var maper_obj=	SmpTxt2json( mapper );
	for(var itemx in o)
	{
		var key_in_str=maper_obj[itemx];
		cmd=cmd.replace("@"+key_in_str+"@",o[itemx]);
	}
	return cmd;
}
/*
 var s="###注释\r\n标题:tti标题标题标题标题标题\r\n人数:5\r\n月薪:2000-3000\r\n内容:\r\n内容内容内111\r\n容内容内容内容222\r\n";
var mapper="标题:title,人数:need_num,月薪:2000-3000,内容:id_description";
var cmd='   ';
	cmd+='  $("input[name=\'title\']").val("@title@"); $("input[name=\'need_num\']").val("@need_num@"); ';
	cmd+='  $("input[name=\'category_url\']").val("@category_url@"); $("input[name=\'price\']").val("1"); ';
	cmd+='  $("#id_description").val("@id_description@");   ';
var o=artTxt2obj(s);
  cmd=(fmtObj(cmd,mapper,o));
 cmd= cmd.replace("\r\n","\\r\\n");   // \\r\\n
  console.log(cmd);
  str.replace(new RegExp(replaceStr,'gm'),'')
  */
 // alert("aa".replace(new RegExp("a",'gm'),"b"));