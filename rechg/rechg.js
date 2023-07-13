// JavaScript Document



function today_rechg(clbk)
{
	try{
		var today_str=today_local();
		var today_start=today_str+" 00:00:01";
	var today_end=today_str+" 23:59:59";
	var sql="select sum(rmb) as cnt from recharge where status=1 and time>'$sdd$' and time<'$end$' ";
	  sql=sql.replace("$sdd$",today_start);
   sql=sql.replace("$end$",today_end);
	
	console.log(sql);
	var dsl="	com.attilax.ioc.Ioc4agent.getBean(com.attilax.db.DbServiceV4qb9.class).executeQuery(\"$s$\")";
	dsl=dsl.replace("$s$","");
	
	var jsbrj=new	AtiJsBridge();
	//	jsbrj.method="post";
		var para={};
		para.dsl=dsl;
		para.sql=sql;
		para.retFmt="json";
		jsbrj.exe(para,function(data){
			console.log(data);
			//$("#content").val(data);
			
			
			 var json=JSON.parse(data); // 
		  	var obj=json[0];
			clbk(obj.cnt);
		//	$("#cnt").text(obj.cnt);
		//	$("#r").text(obj.roomCount);
		//  	
		});
			//mycallJava("submitx",$("#title").val(),$("#content").val(),dropIds);
		}catch(e)
		{
			alert(e);
		}
		
}


function all_rechg(clbk)
{
try{
	var sql="select sum(rmb) as cnt from recharge where status=1 ";
	var dsl="	com.attilax.ioc.Ioc4agent.getBean(com.attilax.db.DbServiceV4qb9.class).executeQuery('$s$')";
	dsl=dsl.replace("$s$",sql);
	
		var jsbrj=new	AtiJsBridge();
	//	jsbrj.method="post";
		var para={};
		para.dsl=dsl;
		para.retFmt="json";
		jsbrj.exe(para,function(data){
			console.log(data);
			//$("#content").val(data);
			
			
			 var json=JSON.parse(data); //( data );			 	 
		  	var obj=json[0];
				clbk(obj.cnt);
		//	$("#r").text(obj.roomCount);
			
		});
			//mycallJava("submitx",$("#title").val(),$("#content").val(),dropIds);
		}catch(e)
		{
			alert(e);
		}
		
}