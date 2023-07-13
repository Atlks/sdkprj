// JavaScript Document

function onlyinput_number($jqObj)
{
	
   //正则表达式
		    $jqObj.keyup(function(){   
           		 $(this).val($(this).val().replace(/[^0-9]/g,''));  
	        }).bind("paste",function(){  //CTR+V事件处理  
	            $(this).val($(this).val().replace(/[^0-9]/g,''));   
	        }).css("ime-mode", "disabled"); //CSS设置输入法不可用  
	
}
$(".ati-numberbox").each(function(){
	 onlyinput_number($(this));     
               // //  if($(this).attr("height")>高度)
//                            var ops=(  $(this).attr("data-options") );
//							var ops_json=eval( "({"+ops+"})" );
//							if(ops_json.required)
//							{
//								if( $(this).val()=="")
//								{
//									alert(ops_json.missingMessage);
//									throw "err";
//								}
//									
//							}
							 
              });