// JavaScript Document

function TableV2(jq_table_obj_id)
{
	this.table_id=jq_table_obj_id;
	this.table_obj=	$("#"+jq_table_obj_id );
		
}
TableV2.prototype.bindData=function(json_arr)
{
	$("#"+this.table_id).html("");
	var tmplxx=　$("#"+this.table_id+"_tmpl");
     tmplxx.tmpl(json_arr).appendTo("#"+this.table_id);	
	// 　$("#table1_tmpl").hide();
	
}