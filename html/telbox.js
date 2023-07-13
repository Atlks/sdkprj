// JavaScript Document
function onlyinput($jqObj)
{
	
   //正则表达式
		    $jqObj.keyup(function(){   
           		 $(this).val($(this).val().replace(/[^0-9\-)]/g,''));  
	        }).bind("paste",function(){  //CTR+V事件处理  
	            $(this).val($(this).val().replace(/[^0-9]/g,''));   
	        }).css("ime-mode", "disabled"); //CSS设置输入法不可用  
	
}
$(".ati-telbox").each(function(){
                //  if($(this).attr("height")>高度)
				
				
                    onlyinput($(this));       
							 
              });