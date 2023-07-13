function ExceptionOaf()
 {
	//this.type="" 
	 
 }
 function ValidException(msgx)
 {
	//this.type="" 
	this.type="ValidException";
	this.msg=msgx;
	 
 }
 function validOafa(isAlert)
 {
$(".ati-validatebox").each(function(){
                //  if($(this).attr("height")>height)
                            var ops=(  $(this).attr("data-options") );
							var ops_json=eval( "({"+ops+"})" );
							if(ops_json.required)
							{
								if( $(this).val()=="")
								{
									if(isAlert)
								 	alert(ops_json.missingMessage);
									throw  new ValidException(ops_json.missingMessage);
								}
									
							}
							 
              });
			  
 }