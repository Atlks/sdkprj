// JavaScript Document


function substr_byMoustache(s,first,second)
{
	var fstIdx= s.indexOf(first);
	var second_idx= s.indexOf(second);

	return s.substring(fstIdx+first.length,second_idx);

}


function substr_byMoustache_toEnd(s,first)
{
	var fstIdx= s.indexOf(first);
	//var second_idx= s.indexOf(second);

	return s.substring(fstIdx+first.length)

}

function substr_byPrefix(s,Prefix)
{
	var fstIdx= s.indexOf(Prefix);
	return s.substring( fstIdx+Prefix.length   );

}


s="<<<abc>>>";
s="";
curlpath="C:\\Program Files\\Git\\mingw64\\bin\\curl.exe"
//console.log( substr_byMoustache (s,"<<<",">>>"))
console.log( substr_byPrefix (curlpath,"C:\\Program Files\\Git\\"))

function removeToomanySpacechar(t,time)
{
	for(var i=0;i<time;i++)
	{
		t= t.replace("  "," ");
	}
	return t;

}



function replaceEnter2Empty(content)
{
	var string = content;
	try{
		string=string.replace(/\r\n/g," ")
		string=string.replace(/\n/g," ");
	}catch(e) {
		alert(e.message);
	}
	return string;
}
function replaceTab2Empty(content)
{
	var string = content;
	try{
		string=string.replace(/\t/g," ")

	}catch(e) {
		alert(e.message);
	}
	return string;
}
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
function trim(str){ //删除左右两端的空格
	return str.replace(/(^\s*)|(\s*$)/g, "");
}
function ltrim(str){ //删除左边的空格
	return str.replace(/(^\s*)/g,"");
}
function rtrim(str){ //删除右边的空格
	return str.replace(/(\s*$)/g,"");
}

function SplitByNone(str){
	var a=[];
	for(i=0;i<str.length;i++)
	{
		a.push( str.charAt(i)  );
	}
return a;
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
function replaceEnter2Empty(content)
{
	var string = content;
	try{
		string=string.replace(/\r\n/g," ")
		string=string.replace(/\n/g," ");
	}catch(e) {
		alert(e.message);
	}
	return string;
}
function replaceTab2Empty(content)
{
	var string = content;
	try{
		string=string.replace(/\t/g," ")

	}catch(e) {
		alert(e.message);
	}
	return string;
}


function removeToomanySpacechar(t,time)
{
	for(var i=0;i<time;i++)
	{
		t= t.replace("  "," ");
	}
	return t;

}
exports.substr_byMoustache_toEnd = substr_byMoustache_toEnd;
	exports.substr_byMoustache = substr_byMoustache;

	exports.substr_byPrefix = substr_byPrefix;
exports.SplitByNone = SplitByNone;
exports.trim = trim;


