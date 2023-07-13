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
