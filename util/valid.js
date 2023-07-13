
var  AtiValid={};
AtiValid.map={};
AtiValid.map_keys=new Array();
AtiValid.mapWaitValid=new Array();
AtiValid.bind_valid_rules=function(ctrlId,rules)
{

AtiValid.map[ctrlId]=rules;
AtiValid.map_keys.push(ctrlId);
}
AtiValid.valid=function(ctrlId)
{

   if(ctrlId)
   {
 	    AtiValid.mapWaitValid=new Array();
		AtiValid.mapWaitValid.push(ctrlId);
   }
 	else
 	{
 		  AtiValid.mapWaitValid=new Array();
	 	AtiValid.mapWaitValid=AtiValid.map_keys;
 	}

	for(var i=0;i<AtiValid.mapWaitValid.length;i++)
	{
				var now_ctrl_id=AtiValid.mapWaitValid[i];
				var val=$("#"+now_ctrl_id).val();
				if(val==undefined)
				{
						alert( "valid ctrl val is underified,ctrl is :"+now_ctrl_id);
						throw "valid ctrl val is underified,ctrl is :"+now_ctrl_id;
				}
				   var rules=AtiValid.map[now_ctrl_id];
				   if(rules.required)
				   {
					   	if(val=="")
					   	{
					   		alert(rules.msg);
							throw rules.msg;
					   	}
				   }

	}
   

}