function formatDateTextO7(date)
{
return	date.Format("yyyy-MM-dd hh:mm:ss");
}


function editIniLoad()
{
var id=UrlParm.parm('id') ;	
if(id==undefined)  //add mod
	return;
	elmtC.findById(id,function(data)
	
	{
		dwr.util.setValues (data);
		
		var plt_s=secs2str(data.playtime);
		$('#playtime').timespinner('setValue',plt_s); 
	//	alert();
	try{
		if(data.effectieTime)
			$('#effectieTime').datetimebox('setValue',formatDateTextO7(data.effectieTime)); 
		//	alert(formatDateTextO7(data.effectieTime));
			if(data.failureTime)
				$('#failureTime').datetimebox('setValue',formatDateTextO7(data.failureTime)); 
			}catch(e){}
		//	$('#effectieTime').datetimebox('setValue',"2014-12-12 12:12:13"); 
	//	$('#dt').datetimebox('setValue', '6/1/2012 12:30:56')
	});
}
//todox o7g validate
function save()
		{
		//	$("")
		//alert($(".ati-validatebox"));
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
		//	var jqmp=$("form").serializeArray();
	//$('#materialDescription').validatebox("disableValidation");	
//		var boo=$('#materialDescription').validatebox("isValid");
//	alert(boo	 );
//	if(!boo)
//	{
//		alert($('#materialDescription').validatebox('options').missingMessage);
//		return;
//	}
			
		var mp=	dwr.util.getValues("formx");
		mp.effectieTime= $("input[name='effectieTime']").val();
		mp.failureTime= $("input[name='failureTime']").val();
		elmtC.save_map(mp ,function(){
			//alert("保存成功");
			saveOkEvent();
			});	
		
		}
function saveOkEvent()
{
	alert("保存成功");
	// if (confirm("保存成功，转往列表查看？？"))
	 if(localflag)
	 {}else
	 	link_back();
}	


function form_load(){}	
$(function () {
 

// printLog("--o4a ini form ajax ret event:");
	//$('#formx').form({
//			success:function(data){
//					$.messager.alert('Info', data, 'info');
//			}
//	});
editIniLoad();
//save();	
});




