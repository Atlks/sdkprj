
function AtiValidV2()
{
this.map={};
this.map_keys=new Array();
this.mapWaitValid=new Array();

}




AtiValidV2.prototype.bind_valid_rules=function(formSelector,rules)
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

AtiValidV2.prototype.bind_valid_rules4element=function(ctrlId,rules)
{

this.map[ctrlId]=rules;
this.map_keys.push(ctrlId);
}

AtiValidV2.prototype.validAll=function()
{

}

AtiValidV2.prototype.valid=function(ctrlId)
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