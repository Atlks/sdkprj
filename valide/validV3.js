
function AtiValidV3()
{
this.map={};
this.map_keys=new Array();
this.mapWaitValid=new Array();

}




AtiValidV3.prototype.bind_valid_rules=function(formSelector,rules)
{
	var self=this;
   $(formSelector+" input").each(
   			function(index,element)
   				{


   						var ctrlId=$(element).attr("id");

   							var element_rule=rules[ctrlId];
   					self.map[ctrlId]=element_rule;
					self.map_keys.push(ctrlId);

   				}


   	);


     
}

AtiValidV3.prototype.bind_valid_rules4element=function(ctrlId,rules)
{

this.map[ctrlId]=rules;
this.map_keys.push(ctrlId);
}

AtiValidV3.prototype.bind_valid_rules4multi_elem=function(ctrlIds,rules)
{
	var a=ctrlIds.split(",");
	for(var i=0;i<a.length;i++)
	{
		this.bind_valid_rules4element(a[i],rules);
	}
	 
}

AtiValidV3.prototype.bind_valid_rules_notempty=function(ctrlIds)
{
	var a=ctrlIds.split(",");
	for(var i=0;i<a.length;i++)
	{
		var rules={};
		rules.required=true;
		rules.msg="相关字段不能为空，请填写完整";
		this.bind_valid_rules4element(a[i],rules);
	}
	 
}

AtiValidV3.prototype.validAll=function()
{

}

AtiValidV3.prototype.valid=function(ctrlId)
{

   if(ctrlId)
   {
 	    this.mapWaitValid=new Array();
		this.mapWaitValid.push(ctrlId);
   }
 	else  
 	{
 		//valid all
 		  this.mapWaitValid=new Array();
	    	this.mapWaitValid=this.map_keys;
 	}

	for(var i=0;i<this.mapWaitValid.length;i++)
	{
				var now_ctrl_id=this.mapWaitValid[i];
				var val=$("#"+now_ctrl_id).val();
				if(val==undefined)
				{
						alert( "valid ctrl val is underified,ctrl is :"+now_ctrl_id);
						throw "valid ctrl val is underified,ctrl is :"+now_ctrl_id;
				}
				   var rules=this.map[now_ctrl_id];
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