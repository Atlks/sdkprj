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