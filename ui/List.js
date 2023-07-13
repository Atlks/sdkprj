// JavaScript Document

function ListUl(jq_table_obj_cssSltor)
{
	//this.table_id=jq_table_obj_id;
//	this.table_obj=	$("#"+jq_table_obj_id );
	this.tableType="table";//  canbe ul li	
	this.table_obj_cssSltor=jq_table_obj_cssSltor;
}
ListUl.prototype.bindData=function(json_arr)
{
//	$( this.table_obj).html("");
   $(""+this.table_obj_cssSltor +" li").eq(0).nextAll().remove();  //remove all dataline .for pagging.
	  
	var okHtml= $(this.table_obj_cssSltor  ).tmpl(json_arr);
    okHtml.appendTo(this.table_obj_cssSltor );	
	// 　$("#table1_tmpl").hide();
	  $(this.table_obj_cssSltor  +" li").eq(0).hide();//hide tmpl tr
	
}