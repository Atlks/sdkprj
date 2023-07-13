// JavaScript Document
//jeig deparead
$(".ati-validatebox").each(function(){
                //  if($(this).attr("height")>高度)
                            var ops=(  $(this).attr("data-options") );
							var ops_json=eval( "({"+ops+"})" );
							if(ops_json.required)
							{
								if( $(this).val()=="")
								{
									alert(ops_json.missingMessage);
									throw "err";
								}
									
							}
							 
              });