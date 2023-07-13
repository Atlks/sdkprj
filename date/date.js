// JavaScript Document

function getDateExp()
{
	 var startDay=$("#txtBeginDate").val();
	 var endDay=$("#txtEndDate").val();
	var today_start=$("#txtBeginDate").val()+" 00:00:01";
	var today_end=$("#txtEndDate").val()+" 23:59:59";
	var where_s="";
	if(startDay.length>3)
		 where_s=" and `timex`>'"+today_start+"'";
	 if(endDay.length>3)
	 	 where_s=where_s+" and `timex`<'"+today_end+"'";
	return where_s;
}


function getDateExpV2(timeCol)
{
	 var startDay=$("#txtBeginDate").val();
	 var endDay=$("#txtEndDate").val();
	var today_start=$("#txtBeginDate").val()+" 00:00:01";
	var today_end=$("#txtEndDate").val()+" 23:59:59";
	var where_s="";
	if(startDay.length>3)
		 where_s=" and `@c@`>'"+today_start+"'";
	 if(endDay.length>3)
	 	 where_s=where_s+" and `@c@`<'"+today_end+"'";
		 where_s=where_s.replace("@c@",timeCol);
	return where_s;
}

 