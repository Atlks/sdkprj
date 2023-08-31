// JavaScript Document

function  page_load()
{
	var pid=UrlParm.parm('parent_id');
	 var code="new(com.attilax.agent.AgentRechargeService).getRchgTotal_groupby_SubAgent_where_ParentAgentId($pid$)";
	 var sql="select sum(rmb) sumx, hiagt_id,hiagt_nick from rchg_agt_hiagt GROUP BY hiagt_id";
 code=code.replace("$pid$",pid);
 
		var orm=new atiOrmV4();
		orm.obj=sql ;
		//orm.metaParam="$utype=agent";
		orm.notloginEventHandler=function(data)
		{
			  if(confirm("没有登录,请先登录。。"))
				  {					
					 window.location="../login/login.htm";
					 return;
				  }
		}
	orm.callbackFun=function(data)
	{
		
			try{
			  processJavaEx_V2q315(data);
		   }catch(e)
		   {
			 
				 
				  showErr(e);
				  return;
		  
		   }
		   var json=str2json(data);
		 
		   var list=new TableV3("table1");
		 
			list.bindData(json);
		   
	};
	orm.query();
		
	//	ini_mem_total();
	
}


function  page_load()
{
	var pid=UrlParm.parm('parent_id');
	 var code="new(com.attilax.agent.AgentRechargeService).getRchgTotal_groupby_SubAgent_where_ParentAgentId($pid$)";
	 var sql="select sum(rmb) sumx, hiagt_id,hiagt_nick from rchg_agt_hiagt GROUP BY hiagt_id";
 code=code.replace("$pid$",pid);
 
		var orm=new atiOrmV4();
		orm.obj=sql ;
		//orm.metaParam="$utype=agent";
		orm.notloginEventHandler=function(data)
		{
			  if(confirm("没有登录,请先登录。。"))
				  {					
					 window.location="../login/login.htm";
					 return;
				  }
		}
	orm.callbackFun=function(data)
	{
		
			try{
			  processJavaEx_V2q315(data);
		   }catch(e)
		   {
			 
				 
				  showErr(e);
				  return;
		  
		   }
		   var json=str2json(data);
		 
		   var list=new TableV3("table1");
		 
			list.bindData(json);
		   
	};
	orm.query();
		
	//	ini_mem_total();
	
}