// JavaScript Document

function getSetTimeParamsSqlExp()
{
	
	
		var paramsql=" update \"ez_flow_timeparam\" ";
		
			var time_exp_arr=new Array();
			if($("#starttime").val())
			{
				var time_exp1="   \"starttime\"=to_timestamp('@start@', 'yyyy-mm-dd')  ";
				time_exp1=time_exp1.replace("@start@",$("#starttime").val());
				time_exp_arr.push(time_exp1);
			}
			if($("#endtime").val())
			{
			var	time_exp2="   \"endtime\"=to_timestamp('@end@', 'yyyy-mm-dd')  ";
				time_exp2=time_exp2.replace("@end@",$("#endtime").val());
				time_exp_arr.push(time_exp2);
			}
				var time_exp=time_exp_arr.join(",");
			if(time_exp.length>0)
				paramsql=paramsql+" set "+time_exp;
			else
				paramsql=" update \"ez_flow_timeparam\" set  \"starttime\"=null, \"endtime\"=null ";
				//paramsql=" update \"ez_flow_timeparam_blank\" set  \"starttime\"=null ";
				//	paramsql=paramsql+" set  \"starttime\"=to_timestamp('', 'yyyy-mm-dd'), \"endtime\"=to_timestamp('@end@', 'yyyy-mm-dd') ";
				return paramsql;
				
}