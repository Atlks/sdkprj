// JavaScript Document



function refuseQ4(order_id)
{
	if(!confirm("确认要拒绝吗??"))
	return;
		 try{
	var ds=new AtiJsBridge();
	 
		ds.exe("$method=com.attilax.order.OrderService4jobus.refuse&$tbtype=sq&$trigger000=com.attilax.dataService.meta_data_pars_from_txt_trigger&$trigtime=after&order_id=$uuid"+"&user_id=$uid&$member_id=$uid&param1="+order_id,function(data){
			console.log("--r:"+data);
		 	alert("ok..返回结果:"+data);
			//	data=str2json(data);
			//	var tb=new TableV3("table1");
			//	tb.bindData(data);
		//   data=str2json(data);
		//　$("#table1_tmpl").tmpl(data).appendTo('#table1');	
	    //  $("#table1 tr").eq(1).hide(); //tr0 is head ,,tr1 is tmpl
			
		}
		
		
		); 
	}catch(e)
	{
		showErr(e);
	}	
}

function acceptQ4(order_id)
{
	if(!confirm("确认要接受吗??"))
	return;
		 try{
	var ds=new AtiJsBridge();
	 
		ds.exe("$method=com.attilax.order.OrderService4jobus.accept&$tbtype=sq&$trigger000=com.attilax.dataService.meta_data_pars_from_txt_trigger&$trigtime=after&order_id=$uuid"+"&user_id=$uid&$member_id=$uid&param1="+order_id,function(data){
			console.log("--r:"+data);
		 	alert("ok..返回结果:"+data);
			//	data=str2json(data);
			//	var tb=new TableV3("table1");
			//	tb.bindData(data);
		//   data=str2json(data);
		//　$("#table1_tmpl").tmpl(data).appendTo('#table1');	
	    //  $("#table1 tr").eq(1).hide(); //tr0 is head ,,tr1 is tmpl
			
		}
		
		
		); 
	}catch(e)
	{
		showErr(e);
	}	
}
