// JavaScript Document

//    /aaa/g
function replaceAll(content,fromChar_regExpFmt,toChar)
{
	var string = content;
	try{
		string=string.replace(fromChar_regExpFmt,toChar);

	}catch(e) {
		alert(e.message);
	}
	return string;
}
function contain(string,substrx)
{
	return string.indexOf(substrx) >= 0;

}

try{
	exports.contain = contain;	exports.replaceAll = replaceAll;


}catch(e)
{

}
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


 String.prototype.endWith=function(str){  
            if(str==null||str==""||this.length==0||str.length>this.length)  
              return false;  
            if(this.substring(this.length-str.length)==str)  
              return true;  
            else  
              return false;  
            return true;  
        }  