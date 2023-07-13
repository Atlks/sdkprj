// JavaScript Document

function TableV3(jq_table_obj_id)
{
	this.table_id=jq_table_obj_id;
	this.table_obj=	$("#"+jq_table_obj_id );
	this.tableType="table";//  canbe ul li	
}
TableV3.prototype.bindData=function(json_arr)
{
//	$( this.table_obj).html("");
   $("#"+this.table_id +" tr").eq(1).nextAll().remove();  //remove all dataline .for pagging.
	var tmplxx=　$("#"+this.table_id+" tr").eq(1);
	//tmplxx=$("<tr>"+tmplxx.html()+"</tr>");
	tmplxx.html(  "<tr>"+tmplxx.html()+"</tr>"  )
	
	var okHtml= tmplxx.tmpl(json_arr);
    okHtml.appendTo("#"+this.table_id);	
	// 　$("#table1_tmpl").hide();
	 $("#"+this.table_id +" tr").eq(1).hide();//hide tmpl tr
	
}