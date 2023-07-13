// JavaScript Document

function SelectDataBinder ()
{
	
}

SelectDataBinder.prototype.callback=function(data,otherParam)
{
	try{
		
		var cate_ctrl_id=otherParam;
		//ui.slect.bind_json2select();
		
	bind_json2select(data,cate_ctrl_id);
	}catch(e)
	{
	showErr(e);	
	}
}

SelectDataBinder.prototype.bind=function(controlId,p)
{
	var sql="select "+p.txt+" as t,"+p.v+" as v from "+p.tb;
		logx(sql);
		var mp="&$method=com.attilax.sql.SqlService.exe&$callback=page_load_callback&$mod=userMod&$view_store_path=com/attilax/order&$op=insert&param1="+encodeURIComponent(sql);
		HRE.exe(mp,this.callback.bind(this),controlId);	
	
}
 

 
